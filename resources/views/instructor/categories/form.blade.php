@extends('admin.dashboard')

@section('title', $category->exists ? 'Editer une categorie' : 'Ajouter une categorie')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')

<form class="vstack gap-2" action="{{ route($category->exists ? 'instructor.category.update' : 'instructor.category.store', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($category->exists ? 'PUT' : 'POST')

    @include('shared.input', [
        'label' => 'Nom :',
        'name' => 'name',
        'value' => old('name', $category->name ?? '')
    ])

    <div>
        <button class="btn btn-primary btn-sm">
            @if ($category->exists)
                Modifier
            @else
                Créer
            @endif
        </button>
    </div>
</form>

@endsection
