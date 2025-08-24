@extends('admin.dashboard')

@section('title', 'Confirmation d\'Inscription')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')

    <div class="container mb-2">
        <h1 class="my-2"><strong>@yield('title')</strong></h1>

        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Achat réussi !</h4>
            <p>Votre paiement a été traité avec succès. Vous avez acheté le cours.</p>
            <hr>
            <p class="mb-0">Merci d'avoir choisi notre plateforme. Vous allez recevoir un email de confirmation concernant votre achat.</p>
        </div>

        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Inscription réussie !</h4>
            <p>Vous êtes désormais inscrit au cours.</p>
            <hr>
            <p class="mb-0">Vous recevrez bientôt des informations sur le contenu du cours et les prochaines étapes.</p>
        </div>

        <a href="{{ route('student.dashboard') }}" class="btn btn-primary">Retour à mon tableau de bord</a>
    </div>

@endsection
