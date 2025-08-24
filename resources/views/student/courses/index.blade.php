@extends('admin.dashboard')

@section('title', 'Liste des Cours')

@section('navbar')
    <div class="d-flex justify-content-between align-item-center">
        <h1><strong>@yield('title')</strong></h1>
        {{-- <a href="{{ route('instructor.course.create') }}" class="btn btn-primary">Ajouter cour</a> --}}
    </div>
@endsection

@section('container')

    <div class="container mb-2">
        <h1 class="my-2"><strong>@yield('title')</strong></h1>
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-3">
                    <div class="card mb-4 shadow-sm" style="width: 18rem;">
                        {{-- <img src="{{ asset('img/img1.jpg') }}" class="card-img-top" alt="Course Image"> --}}
                        <div class="card-body">
                            <h5 class="card-title"><strong>{{ $course->title }}</strong></h5>
                            <p class="card-text">{{ $course->description }}</p>
                            <div class="rating">
                                <span>4.6</span> <i class="fas fa-star"></i> (588)
                            </div>
                            <p class="card-text"><strong>Prix : €{{ $course->price }}</strong></p>
                            <div class="flex">
                                <a href="{{ route('student.addToCard', $course->id) }}" class="btn btn-primary btn-sm">Panier</a>
                                &nbsp;&nbsp;
                                {{-- <form action="{{ route('student.stripe.checkout', $course->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Payer</button>
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
