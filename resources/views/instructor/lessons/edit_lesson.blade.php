@extends('instructor.dashboard')

@section('title', 'Modifier une Leçon')

@section('navbar')
    <h1><strong>@yield('title')</strong></h1>
@endsection

@section('container')
    <h2><strong>Modifier la Leçon: {{ $lesson->title }}</strong></h2><br>
    <div class="container">
        <form class="vstack gap-2" action="{{ route('instructor.instructor.updateLesson', $lesson->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="course_id" class="block text-sm font-medium text-gray-700">Cours</label>
                <select
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    name="course_id" required>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ $lesson->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    name="title" value="{{ $lesson->title }}" required>
            </div>

            <div class="form-group">
                <label for="video_path" class="block text-sm font-medium text-gray-700">Vidéo (optionnel)</label>
                <input type="file"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    name="video_path" accept="video/*">
                @if ($lesson->video_path)
                    <p class="mt-2 text-sm text-gray-600">Vidéo actuelle : <a
                            href="{{ asset('storage/' . $lesson->video_path) }}" target="_blank">Voir Vidéo</a></p>
                @endif
            </div>

            <div class="form-group">
                <label for="content" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    name="content">{{ $lesson->content }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Mettre à Jour la Leçon</button>
        </form>
    </div>
@endsection
