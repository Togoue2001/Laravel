@extends('admin.dashboard')

@section('title', 'Paiement annulé')

@section('container')
<div class="container my-5 d-flex justify-content-center">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%; border-radius: 15px; border: 1px solid #dc3545;">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mb-3" width="72" height="72" fill="#dc3545" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1
                .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
            <h1 class="mb-3 text-danger fw-bold">Paiement annulé</h1>
            <p class="lead mb-4 text-secondary">Vous avez annulé le paiement. Votre panier est toujours disponible.</p>
            <a href="{{ route('student.courses.cart') }}" class="btn btn-outline-danger btn-lg px-5 shadow-sm btn-sm">
                Retour au panier
            </a>
        </div>
    </div>
</div>
@endsection
