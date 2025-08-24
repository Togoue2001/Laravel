@extends('admin.dashboard')

@section('title', 'Mes cours acheter')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')
<div class="container my-4">
    <h1 class="mb-4">@yield('title')</h1>

    @if ($courses->isEmpty())
        <p>Vous n'avez aucun cours acheté pour le moment.</p>
    @else
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        {{-- <img src="{{ $course->image_url ?? asset('img/default_course.jpg') }}" class="card-img-top" alt="{{ $course->title }}"> --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text text-truncate">{{ $course->description }}</p>

                            @php
                                // Calcul de la progression (nombre de leçons terminées / total)
                                $totalLessons = $course->lessons->count();
                                $userLessonsCompleted = $course->lessons->filter(function($lesson) {
                                    return $lesson->users->contains(auth()->id());
                                })->count();
                                $progressPercent = $totalLessons > 0 ? round(($userLessonsCompleted / $totalLessons) * 100) : 0;
                            @endphp

                            <div class="mt-auto">
                                <div class="mb-2">
                                    Progression : {{ $userLessonsCompleted }} / {{ $totalLessons }} leçons ({{ $progressPercent }}%)
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progressPercent }}%;" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-primary btn-block btn-sm">Voir les leçons</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
