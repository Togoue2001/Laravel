@extends('admin.dashboard')

@section('title', $lesson->title)

@section('navbar')
    <div class="bg-white border-bottom py-3 px-4">
        <h1 class="text-dark h4 m-0 fw-bold">@yield('title')</h1>
    </div>
@endsection

@section('container')
    <div class="container mt-4" style="max-width: 100%;">
        <div class="row">
            {{-- Colonne gauche : sidebar des leçons restantes --}}
            <div class="col-md-3 mb-4">
                <div class="bg-white border rounded shadow-sm p-3">
                    <h5 class="fw-bold mb-3 text-primary">📚 Leçons restantes</h5>
                    @if($remainingLessons->isEmpty())
                        <p class="text-muted">✅ Toutes les leçons sont terminées.</p>
                    @else
                        <ul class="list-group">
                            @foreach($remainingLessons as $remaining)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('student.lessons.show', $remaining->id) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($remaining->title, 40) }}
                                    </a>
                                    <span class="badge bg-secondary">⏳</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Colonne droite : contenu principal --}}
            <div class="col-md-9">
                @if (session('success'))
                    <div class="alert alert-success text-center fw-bold">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger text-center fw-bold">
                        {{ session('error') }}
                    </div>
                @endif

                <h2 class="mb-3 fw-bold text-dark text-center fs-2">{{ $lesson->title }}</h2>

                <div class="mb-4">
                    <h4 class="text-secondary mb-2">📘 Description</h4>
                    <p class="text-muted lh-lg fs-5">{!! nl2br(e($lesson->description)) !!}</p>
                </div>

                <div class="course-video-container">
                    <video controls class="course-video" poster="/images/cover.jpg">
                        <source src="{{ asset('storage/' . $lesson->video_path) }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                </div>
                <br><br>

                {{-- Bouton terminer --}}
                <div class="text-center mb-5">
                    <form action="{{ route('student.lessons.complete', $lesson->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success fw-bold px-4 py-2 btn-sm">
                            ✅ Marquer comme terminée
                        </button>
                    </form>
                </div>

                {{-- Quiz s'il est débloqué --}}
                @if (
                    $lesson->questions->isNotEmpty() &&
                        $lesson->users()->where('user_id', auth()->id())->whereNotNull('lesson_user.completed_at')->exists())
                    <div class="container mt-5">
                        <div class="card shadow-lg rounded bg-light">
                            <div class="card-body">
                                <h3 class="mb-4 text-primary fw-bold text-center">📝 Quiz</h3>

                                <form action="{{ route('student.lessons.submitQuiz', $lesson->id) }}" method="POST">
                                    @csrf

                                    @foreach ($lesson->questions as $question)
                                        <div class="mb-4 p-3 bg-white rounded shadow-sm border">
                                            <p class="fw-semibold text-dark fs-5 mb-3">
                                                {{ $question->question_text ?? $question->content }}
                                            </p>

                                            @foreach ($question->answers as $answer)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="answers[{{ $question->id }}]" value="{{ $answer->id }}"
                                                        id="answer-{{ $answer->id }}">

                                                    <label class="form-check-label text-dark" for="answer-{{ $answer->id }}">
                                                        {{ $answer->answer_text ?? $answer->content }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary fw-bold px-5 py-2 mt-3 btn-sm">
                                            ✅ Soumettre le quiz
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

            </div> {{-- Fin colonne droite --}}
        </div> {{-- Fin row --}}
    </div> {{-- Fin container --}}
@endsection

@push('styles')
    <style>
        .course-video-container {
            width: 100%;
            max-width: 100%;
            margin: 2rem auto;
            padding: 0 1rem;
            box-sizing: border-box;
        }

        .course-video {
            width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .list-group-item a:hover {
            color: #0d6efd;
        }
    </style>
@endpush
