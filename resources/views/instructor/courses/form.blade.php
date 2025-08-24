@extends('admin.dashboard')

@section('title', $course->exists ? 'Editer un cours' : 'Ajouter un cours')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
    </div>
@endsection

@section('container')


    <form class="vstack gap-2"
        action="{{ route($course->exists ? 'instructor.course.update' : 'instructor.course.store', $course) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method($course->exists ? 'PUT' : 'POST')

        <div class="flex space-x-4">
            <div class="flex-1 m-2">
                @include('shared.input', [
                    'label' => 'Titre :',
                    'name' => 'title',
                    'value' => old('title', $course->title ?? ''),
                ])
            </div>
            <div class="flex-1 m-2">
                @include('shared.input', [
                    'label' => 'Prix :',
                    'name' => 'price',
                    'value' => old('price', $course->price ?? ''),
                ])
            </div>
        </div>

        @include('shared.input', [
            'label' => 'Description :',
            'type' => 'textarea',
            'name' => 'description',
            'value' => old('description', $course->description ?? ''),
        ])

        @include('shared.select', [
            'label' => 'Categorie :',
            'name' => 'category_id',
            'value' => old('category_id', $course->category_id), // 👈 ici c’est une seule valeur
        ])



        @include('shared.input_video', [
            'name' => 'video_path',
            'value' => old('video_path', $course->video_path ?? ''),
        ])

        <div>
            <button class="btn btn-primary btn-sm">
                @if ($course->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>
    </form>

@endsection
