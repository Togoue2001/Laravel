@extends('instructor.dashboard')

@section('title', 'Ajouter une Leçon')

@section('navbar')
    <h1><strong>@yield('title')</strong></h1>
@endsection

@section('container')
<div class="container">
 <form class="vstack gap-2" action="{{ route('instructor.instructor.storeLesson') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="course_id" class="block text-sm font-medium text-gray-700">Cours</label>
        <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="course_id" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="title" required>
    </div>

    <div class="form-group">
        <label for="video_path" class="block text-sm font-medium text-gray-700">Vidéo (optionnel)</label>
        <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="video_path" accept="video/*">
    </div>

    <div class="form-group">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="description"></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Ajouter la Leçon</button>
</form>
</div>
@endsection
