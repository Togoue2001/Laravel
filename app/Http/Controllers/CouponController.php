<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('user')->latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $users = User::where('role', 'student')->get();
        return view('admin.coupons.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'user_id' => 'nullable|exists:users,id',
            'discount' => 'required|numeric|min:0',
            'is_percentage' => 'required|boolean',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Code promo créé avec succès');
    }

    public function edit(Coupon $coupon)
    {
        $users = User::where('role', 'student')->get();
        return view('admin.coupons.edit', compact('coupon', 'users'));
    }


    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'user_id' => 'nullable|exists:users,id',
            'discount' => 'required|numeric|min:0',
            'is_percentage' => 'required|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Code promo mis à jour avec succès');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Code promo supprimé avec succès');
    }

    public function apply(Request $request)
    {
        $user = Auth::user();
        $coupon = Coupon::where('code', $request->input('code'))->first();

        // Vérifier validité
        if (!$coupon || !$coupon->is_active || ($coupon->expires_at && $coupon->expires_at < now())) {
            return back()->with('error', 'Code promo invalide ou expiré.');
        }

        // Vérifier si déjà utilisé par l’utilisateur
        if ($user->coupons()->where('coupon_id', $coupon->id)->exists()) {
            return back()->with('error', 'Vous avez déjà utilisé ce code promo.');
        }

        // Exemple : total panier (tu peux adapter)
        $total = 100; // à remplacer par ton vrai calcul de panier
        $discount = $coupon->is_percentage ? ($total * $coupon->discount / 100) : $coupon->discount;

        // Enregistrer l’utilisation dans la pivot
        $user->coupons()->attach($coupon->id, ['used_at' => now()]);

        return back()->with('success', "Code promo appliqué ! Réduction de {$discount}.");
    }
}
