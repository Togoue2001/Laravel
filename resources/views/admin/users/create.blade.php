@extends('dashboard')

@section('title', $user->exists ? 'Modifier un utilisateur' : 'Ajouter un utilisateur')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')
    <div class="container">
        <form action="{{ route($user->exists ? 'admin.users.update' : 'admin.users.store', $user) }}" method="POST" class="vstack gap-2">
            @csrf
            @method($user->exists ? 'PUT' : 'POST')

            <div class="form-group">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="form-group">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>

            <div class="form-group">
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select name="role"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="student" {{ (isset($user) && $user->role == 'student') ? 'selected' : '' }}>Student</option>
                    <option value="instructor" {{ (isset($user) && $user->role == 'instructor') ? 'selected' : '' }}>Instructor</option>
                    <option value="admin" {{ (isset($user) && $user->role == 'admin') ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                {{-- <small class="text-gray-500">Laissez vide pour conserver le mot de passe actuel.</small> --}}
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

        <div>
            <button class="btn btn-primary btn-sm">
                @if ($user->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>
        </form>
    </div>
@endsection
