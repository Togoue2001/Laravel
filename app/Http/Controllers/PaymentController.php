<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('student.courses.index', compact('courses'));
    }

    public function addToCard($courseId)
    {
        $course = Course::findOrFail($courseId);
        $cart = session()->get('cart', []);

        $cart[$courseId] = [
            "name" => $course->title,
            "description" => $course->description,
            "price" => $course->price,
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cours ajouté au panier !');
    }

public function create(Request $request)
{
    $cart = session('cart');

    if (!$cart) {
        return redirect()->back()->with('error', 'Votre panier est vide');
    }

    // Validation des champs
    $request->validate([
        'receiver_address' => 'required|string|max:255',
        'receiver_phone'   => 'required|string|max:15',
        'promo_code'       => 'nullable|string|max:50',
    ]);

    // Calcul du total
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'];
    }

    $user = auth()->user();
    $discount = 0;

    // Vérification et application du code promo
    if (!empty($request->promo_code)) {
        $coupon = Coupon::where('code', $request->promo_code)->first();

        if (!$coupon) {
            return redirect()->back()
                ->withErrors(['promo_code' => 'Ce code promo est invalide.'])
                ->withInput();
        }

        if (!$coupon->is_active) {
            return redirect()->back()
                ->withErrors(['promo_code' => 'Ce code promo n\'est plus actif.'])
                ->withInput();
        }

        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return redirect()->back()
                ->withErrors(['promo_code' => 'Ce code promo a expiré.'])
                ->withInput();
        }

        // Vérifier si déjà utilisé par cet utilisateur
        if ($user->coupons()->where('coupon_id', $coupon->id)->exists()) {
            return redirect()->back()
                ->withErrors(['promo_code' => 'Vous avez déjà utilisé ce code promo.'])
                ->withInput();
        }

        // Application de la réduction
        if ($coupon->is_percentage) {
            $discount = $coupon->discount; // en %
            $total -= ($total * ($discount / 100));
        } else {
            $discount = $coupon->discount; // montant fixe
            $total -= $discount;
        }

        // Ne jamais avoir un total négatif
        if ($total < 0) {
            $total = 0;
        }

        // Enregistrer l’utilisation du coupon dans la table pivot
        $user->coupons()->attach($coupon->id, ['used_at' => now()]);
    }

    // Sauvegarde de la commande
    $order = new Order();
    $order->user_id = $user->id;
    $order->course_id = implode(',', array_keys($cart));
    $order->receiver_address = $request->receiver_address;
    $order->receiver_phone = $request->receiver_phone;
    $order->payment_status = 'pending';
    $order->total_price = $total; // total avec réduction si coupon
    $order->save();

    // Création de la session Stripe
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $lineItems = [
        [
            'price_data' => [
                'currency'     => 'eur',
                'product_data' => [
                    'name'        => 'Achat de cours',
                    'description' => 'Contenu éducatif',
                ],
                'unit_amount'  => intval($total * 100), // prix final en centimes
            ],
            'quantity' => 1,
        ]
    ];

    $session = StripeSession::create([
        'payment_method_types' => ['card'],
        'line_items'           => $lineItems,
        'mode'                 => 'payment',
        'success_url'          => route('student.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'           => route('student.cancel'),
        'metadata'             => [
            'order_id' => $order->id,
        ],
    ]);

    return redirect($session->url);
}


    public function cart()
    {
        $cartItems = session('cart');

        if (!$cartItems) {
            return view('student.courses.cart', ['courses' => []]);
        }

        $courseIds = array_keys($cartItems);
        $courses = Course::whereIn('id', $courseIds)->get();

        return view('student.courses.cart', [
            'courses' => $courses,
            'cart'    => $cartItems,
        ]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('student.courses.index')->with('error', 'Session de paiement invalide.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect()->route('student.courses.index')->with('error', 'Impossible de récupérer les informations de paiement.');
        }

        if ($session->payment_status === 'paid') {
            $orderId = $session->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);

                if ($order && $order->payment_status !== 'paid') {
                    $order->payment_status = 'paid';
                    $order->save();
                }
            }

            session()->forget('cart');

            return redirect()->route('student.courses.index')->with('success', 'Paiement réussi ! Voici vos cours.');
        }

        return redirect()->route('student.courses.index')->with('error', 'Le paiement n’a pas été confirmé.');
    }

    public function cancel()
    {
        return view('student.cancel');
    }

    public function removeFromCart($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
            return redirect()->route('student.courses.cart')->with('success', 'Cours retiré du panier.');
        }

        return redirect()->route('student.courses.cart')->with('error', 'Cours non trouvé dans le panier.');
    }
}
