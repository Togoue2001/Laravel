@extends('admin.dashboard')

@section('title', 'Quiz')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')
    <h1>Quiz : {{ $quiz->title }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student.lessons.submitQuiz', $quiz->id) }}" method="POST">
        @csrf
        @foreach ($quiz->questions as $question)
            <div class="mb-4">
                <p><strong>{{ $loop->iteration }}. {{ $question->content }}</strong></p>
                @foreach ($question->answers as $answer)
                    <div>
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}"
                            id="answer-{{ $answer->id }}">
                        <label for="answer-{{ $answer->id }}">{{ $answer->content }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary btn-sm">Soumettre le quiz</button>
    </form>
@endsection
