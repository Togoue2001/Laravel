@extends('admin.dashboard')

@section('title', 'Gérer les utilisateurs')

@section('navbar')
    <div class="d-flex justify-content-between align-items-center">
        <h1><strong>@yield('title')</strong></h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Ajouter utilisateur</a>
    </div>
@endsection

@section('container')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <div class="d-flex gap-2 w-100 justify-content-end">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
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

    <!-- Pagination Links -->
    {{ $users->links() }}
@endsection
