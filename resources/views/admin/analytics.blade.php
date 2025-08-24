<!-- resources/views/admin/analytics.blade.php -->

@extends('dashboard')

@section('title', 'Gérer les statistiques')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
        {{-- <a href="#" class="btn btn-primary">Ajouter utilisateur</a> --}}
    </div>
@endsection

@section('container')
<div class="container">
    <hr><hr><hr><hr>
    <h1 class="text-center"><strong>@yield('title')</strong></h1>
    <hr><hr><hr><hr> <br>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Utilisateurs Inscrits</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $userCount }}</h5>
                    <p class="card-text">Total d'utilisateurs inscrits sur la plateforme.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Cours Disponibles</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $courseCount }}</h5>
                    <p class="card-text">Nombre total de cours disponibles.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Leçons Complétées</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $completedLessons }}</h5>
                    <p class="card-text">Total de leçons complétées par les utilisateurs.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Statistiques Détailées</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom du Cours</th>
                        <th>Utilisateurs Inscrits</th>
                        <th>Leçons Complétées</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseDetails as $course)
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->enrolled_users }}</td>
                            <td>{{ $course->completed_lessons }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
