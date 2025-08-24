@extends('admin.dashboard')

@section('title', 'Resultat')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')
<h1>Résultat du quiz : {{ $quiz->title }}</h1>

<p>Votre score : <strong>{{ $result->score }}</strong> / {{ $quiz->questions->count() }}</p>

<a href="{{ route('student.courses.show', $quiz->course_id) }}" class="btn btn-secondary btn-sm">Retour au cours</a>
@endsection
