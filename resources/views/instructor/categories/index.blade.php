@extends('admin.dashboard')

@section('title', 'Mes Categorie')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
        <a href="{{ route('instructor.category.create') }}" class="btn btn-primary btn-sm">Ajouter une categorie</a>
    </div>
@endsection

@section('container')

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date de creation</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <div class="d-flex gap-2 w-100 justify-content-end">
                            <a href="{{ route('instructor.category.edit', $category) }}" class="btn btn-primary btn-sm">Editer</a>
                            <form action="{{ route('instructor.category.destroy', $category) }}" method="post">
                                @csrf
                                @method("delete")
                                <button class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}

@endsection
