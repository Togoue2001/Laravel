@extends('admin.dashboard')

@section('title', 'Mes Cours')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
        <a href="{{ route('instructor.course.create') }}" class="btn btn-primary btn-sm">Ajouter cour</a>
    </div>
@endsection

@section('container')

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Date de création</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->description }}</td>
                    <td>{{ number_format($course->price, thousands_separator: ' ') }} $</td>
                    <td>{{ $course->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-2 w-100 justify-content-end">
                            <a href="{{ route('instructor.course.edit', $course) }}" class="btn btn-primary btn-sm">Editer</a>

                            <form action="{{ route('instructor.course.destroy', $course) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $courses->links() }}

@endsection
