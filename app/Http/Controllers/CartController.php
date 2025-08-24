<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CartController extends Controller
{
   public function addToCart($courseId)
{
    $course = Course::findOrFail($courseId);
    $cart = session()->get('cart', []);

    if (isset($cart[$courseId])) {
        $cart[$courseId]['quantite']++; // Utilisez 'quantite' pour l'incrémentation
    } else {
        $cart[$courseId] = [
            "name" => $course->title,
            "quantite" => 1, // Assurez-vous d'utiliser la même clé ici
            "price" => $course->price,
            "description" => $course->description,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Cours ajouté au panier !');
}

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('student.cart.view', compact('cart'));
    }

    public function checkout(Request $request)
    {
        // Logique de paiement avec Stripe

        // Après le paiement réussi, inscrire l'utilisateur au cours
        foreach (session('cart') as $id => $details) {
            // Créer une entrée dans la table d'inscription
            auth()->user()->courses()->attach($id);
        }

        session()->forget('cart'); // Vider le panier
        return redirect()->route('courses.index')->with('success', 'Achat réussi !');
    }
}
