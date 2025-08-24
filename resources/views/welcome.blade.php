<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Welcome to My Learning Platform')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-primary bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Learning Platform</a>
            <form class="d-flex" role="search" style="margin-left: auto;">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
                <a class="nav-link" href="{{ route('register') }}">Create Account</a>
            </div>
        </div>
    </nav>

    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/femme-afro-americaine-portant-un-sac-a-dos-d-etudiant-et-tenant-des-livres-souriant-heureux-pointant-avec-la-main-et-le-doigt-sur-le-cote.jpg') }}"
                    class="d-block w-100" width="1500" height="500">
            </div>
            {{-- <div class="carousel-item">
                <img src="{{ asset('img/groupe-de-cinq-etudiants-africains-passant-du-temps-ensemble-sur-le-campus-de-la-cour-de-l-universite-amis-afro-noirs-etudiant-le-theme-de-l-education.jpg') }}"
                    class="d-block w-100" width="1500" height="500">
            </div> --}}
            <div class="carousel-item">
                <img src="{{ asset('img/femme-souriante-avec-un-afro-posant-dans-un-pull-rose.jpg') }}"
                    class="d-block w-100" width="1500" height="500">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mb-2">
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('img/img1.jpg') }}" class="card-img-top" alt="Course Image">
                    <div class="card-body">
                        <h5 class="card-title">ChatGPT & IA : Formation complète ChatGPT, Dall-e</h5>
                        <p class="card-text">Yassine Rochd</p>
                        <div class="rating">
                            <span>4.6</span> <i class="fas fa-star"></i> (588)
                        </div>
                        <div class="price">54,99 $US</div>
                        <a href="#" class="btn btn-primary">Premium</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('img/img2.jpg') }}" class="card-img-top" alt="Course Image">
                    <div class="card-body">
                        <h5 class="card-title">Course 1: Introduction to Programming</h5>
                        <p class="card-text"> HTML, CSS, and JavaScript.</p>
                        <div class="rating">
                            <span>4.5</span> <i class="fas fa-star"></i>
                        </div>
                        <div class="price">39,99 $US</div>
                        <a href="#" class="btn btn-primary">Enroll Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('img/img4.jpg') }}" class="card-img-top" alt="Course Image">
                    <div class="card-body">
                        <h5 class="card-title">Course 2: Web Development</h5>
                        <p class="card-text"> HTML, CSS, PHP, and JavaScript.</p>
                        <div class="rating">
                            <span>4.7</span> <i class="fas fa-star"></i>
                        </div>
                        <div class="price">49,99 $US</div>
                        <a href="#" class="btn btn-primary">Enroll Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('img/img3.webp') }}" class="card-img-top" alt="Course Image">
                    <div class="card-body">
                        <h5 class="card-title">Course 3: Data Science</h5>
                        <p class="card-text">Dive into data analysis and machine learning with Python.</p>
                        <div class="rating">
                            <span>4.8</span> <i class="fas fa-star"></i>
                        </div>
                        <div class="price">59,99 $US</div>
                        <a href="#" class="btn btn-primary">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
        @yield('container')
    </div>
    <footer>
        <p>&copy; 2025 My Learning Platform. All rights reserved.</p>
    </footer>

    <!-- Assurez-vous d'inclure les scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script>
        var myCarousel = document.querySelector('#carouselExampleAutoplaying')
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 2000, // intervalle de changement d'image en millisecondes
            wrap: true
        })
    </script>

</body>

</html>
