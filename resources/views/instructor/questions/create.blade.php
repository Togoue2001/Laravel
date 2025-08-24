@extends('instructor.dashboard')

@section('title', 'Ajouter une Question et ses Réponses')

@section('navbar')
    <h1><strong>@yield('title')</strong></h1>
@endsection

@section('container')
    <div class="container">
        <h2><strong>Ajouter une Question et ses Réponses</strong></h2><br>
       <form class="vstack gap-3" id="questionForm" action="{{ route('instructor.questions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700" for="lesson_id">Leçon</label>
                <select class="form-control" name="lesson_id" required>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700" for="question_text">Texte de la Question</label>
                <input class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" type="text" class="form-control" name="question_text" required>
            </div>
            <div id="answers">
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700" for="answer_text">Texte de la Réponse</label>
                    <input class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" type="text" class="form-control" name="answers[0][text]" required>
                    <label class="text-sm font-medium text-gray-700" for="is_correct">Est-ce la bonne réponse ?</label>
                    <input type="radio" name="correct_answer" value="0" required>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="addAnswer">Ajouter une Réponse</button>
            <button type="submit" class="btn btn-primary btn-sm">Ajouter la Question et les Réponses</button>
        </form>
    </div>

    <script>
        let answerCount = 1;
        document.getElementById('addAnswer').addEventListener('click', function() {
            const answersDiv = document.getElementById('answers');
            const newAnswer = `
                <div class="form-group">
                    <label for="answer_text">Texte de la Réponse</label>
                    <input type="text" class="form-control" name="answers[${answerCount}][text]" required>
                    <label for="is_correct">Est-ce la bonne réponse ?</label>
                    <input type="radio" name="correct_answer" value="${answerCount}" required>
                </div>
            `;
            answersDiv.insertAdjacentHTML('beforeend', newAnswer);
            answerCount++;
        });
    </script>
@endsection
