@extends('admin.dashboard')

@section('title', 'Mes certificats')

@section('container')
<div class="container mt-4">
    <h1>🎓 Mes certificats</h1>

    @if($certificates->isEmpty())
        <p>Vous n’avez pas encore de certificats.</p>
    @else
        <ul class="list-group mt-3">
            @foreach($certificates as $certificate)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Certificat du cours : <strong>{{ $certificate->course->title }}</strong>
                    <a href="{{ route('student.certificates.download', $certificate->id) }}" class="btn btn-success">
                        📄 Télécharger
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
