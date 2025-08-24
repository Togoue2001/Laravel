@extends('instructor.dashboard')

@section('title', 'Liste des Questions')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
        <a href="{{ route('instructor.questions.create') }}" class="btn btn-primary btn-sm">Ajouter une question</a>
    </div>
@endsection

@section('container')
    <div class="container">
        <h2>Liste des Questions</h2><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Réponses</th>
                    <th class="text-end">Actions</th> <!-- Nouvelle colonne pour les actions -->
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->question_text }}</td>
                        <td>
                            <ul>
                                @foreach ($question->answers as $answer)
                                    <li>
                                        {{ $answer->answer_text }}
                                        ({{ $answer->is_correct ? 'Correct' : 'Incorrect' }})
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <div class="d-flex gap-2 w-100 justify-content-end">
                                <form action="{{ route('instructor.questions.destroy', $question->id) }}" method="POST"
                                    style="display:inline;">
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
