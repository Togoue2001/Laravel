@extends('admin.dashboard')

@section('title', 'Mon cours')

@section('navbar')
<div class="d-flex justify-content-between align-item-center">
    <h1><strong>@yield('title')</strong></h1>
</div>
@endsection

@section('container')
<div class="container mt-4">
    <h1 class="mb-3">{{ $course->title }}</h1>
    <p class="lead">{{ $course->description }}</p>

    <h2 class="mt-4">Leçons</h2><br>
    <ul class="list-group">
        @foreach ($lessons as $lesson)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('student.lessons.show', $lesson->id) }}" class="text-decoration-none">
                    {{ $lesson->title }}
                </a>
                @if ($lesson->users->count() > 0)
                    <span class="badge bg-success">Terminée</span>
                @else
                    <span class="badge bg-warning">À faire</span>
                @endif
            </li>
        @endforeach
    </ul>

    @if($courseIsCompletedByUser && $certificate)
        <a href="{{ route('student.certificates.download', $certificate->id) }}" class="btn btn-primary mt-4">
            📄 Télécharger mon certificat
        </a>
    @endif
</div>
@endsection
