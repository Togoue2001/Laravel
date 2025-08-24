<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if (Auth::user()->role === 'admin')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.admin.analytics')" :active="request()->routeIs('admin.admin.analytics')">
                            Analyse
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            Gérer utilisateurs
                        </x-nav-link>
                        <x-nav-link :href="route('admin.coupons.index')" :active="request()->routeIs('admin.coupons.index')">
                            Coupons
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'instructor')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('instructor.course.index')" :active="request()->routeIs('instructor.course.index')">
                            Cours
                        </x-nav-link>
                        <x-nav-link :href="route('instructor.category.index')" :active="request()->routeIs('instructor.category.index')">
                            Catégories
                        </x-nav-link>
                        <x-nav-link :href="route('instructor.instructor.lessons')" :active="request()->routeIs('instructor.instructor.lessons')">
                            Leçons
                        </x-nav-link>
                        <x-nav-link :href="route('instructor.questions.index')" :active="request()->routeIs('instructor.questions.index')">
                            Questions
                        </x-nav-link>
                        <x-nav-link :href="route('instructor.statistics')" :active="request()->routeIs('instructor.statistics')">
                            Statistique
                        </x-nav-link>
                        <x-nav-link :href="route('chat')" :active="request()->routeIs('chat')">
                            ChatBot
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'student')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('student.index')" :active="request()->routeIs('student.index')">
                            Mes Cours
                        </x-nav-link>
                        <x-nav-link :href="route('student.courses.index')" :active="request()->routeIs('student.courses.index')">
                            Liste de cour
                        </x-nav-link>
                        <x-nav-link :href="route('student.courses.achats')" :active="request()->routeIs('student.courses.achats')">
                            Mes Achats
                        </x-nav-link>
                        <x-nav-link :href="route('chat')" :active="request()->routeIs('chat')">
                            ChatBot
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    @if (auth()->check() && auth()->user()->role === 'student')
                        <!-- Première instance du dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        <i class="fa fa-cart-plus"></i>
                                        <strong>Panier ({{ count(session('cart', [])) }})</strong>
                                    </div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @if (session('cart') && count(session('cart')) > 0)
                                    @foreach (session('cart') as $key => $value)
                                        <div class="row" style="width: 400px">
                                            <div class="col-md-4">
                                                {{-- <img src="/images/{{ $value['image'] }}" class="img-fluid" alt="{{ $value['name'] }}"> --}}
                                            </div>
                                            <div class="col-md-8 m-2">
                                                <p><strong>{{ $value['name'] }}</strong></p>
                                                Description : {{ $value['description'] }} <br>
                                                Prix : €{{ number_format($value['price'], 2) }} <!-- Formatage du prix -->
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-center">
                                        <a href="{{ route('student.courses.cart') }}" class="btn btn-primary">Tout voir</a>
                                    </div>
                                @else
                                    <p class="text-center">Votre panier est vide.</p>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    @endif
                    &nbsp;&nbsp;
                    <!-- Deuxième instance du dropdown avec un espace -->
                    <x-dropdown align="right" width="48" class="ms-4">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
