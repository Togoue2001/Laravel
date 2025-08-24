@extends('instructor.dashboard')

@section('title', 'Listes des leçons')

@section('navbar')
    <div class="d-flex justify-content-between align-items-center">
        <h1><strong>@yield('title')</strong></h1>
        <a href="{{ route('instructor.instructor.createLesson') }}" class="btn btn-primary btn-sm">Ajouter une leçon</a>
    </div>
@endsection

@section('container')
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Liste des Leçons</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Cours</th>
                    <th>Vidéo</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->title }}</td>
                        <td>{{ $lesson->course->title }}</td>
                        <td>
                            @if ($lesson->video_path)
                                <a href="{{ asset('storage/' . $lesson->video_path) }}" target="_blank">Voir Vidéo</a>
                            @else
                                <span class="text-muted">Pas de vidéo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('instructor.instructor.editLesson', $lesson->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                                <form action="{{ route('instructor.instructor.deleteLesson', $lesson->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette leçon ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
