<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hi Chat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <header class="w-full container mx-auto px-5 absolute py-3 md:block hidden">
        @if (Route::has('login'))
        <nav class="-mx-3 flex flex-1 justify-end">
            @auth
            <x-dropdown align="right" width="48">

                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div class="flex items-center gap-2">
                            <x-avatar class="w-6 h-6" src="{{Auth::user()->image}}" />
                            {{Auth::user()->name}}
                        </div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
            @else
            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-blue-700 font-medium ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Log in
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-blue-700 font-medium ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Register
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>

    <div class="flex h-screen md:justify-center md:items-center">
        <div class="grid md:grid-cols-2 grid-cols-1">
            <div class="flex flex-col justify-center container mx-auto px-7 bg-blue-700 text-white md:rounded-r-full rounded-b-3xl py-5">
                <h1 class="md:text-5xl text-2xl font-extrabold font-blackHans pb-4">HI CHAT</h1>
                <p class="text-pretty md:text-lg text-medium mb-3">
                    Connect and chat instantly with friends, family, and colleagues with our Hi Chat application. Powered by Laravel Livewire, our chat platform offers a seamless experience for real-time communication.
                    <br />
                    <a href="{{route('users')}}">
                        <button class="border py-2 px-4 mt-4 rounded-lg hover:bg-white hover:text-black duration-300 text-sm font-medium">
                            Get Started
                        </button>
                    </a>
                </p>
            </div>

            <img src="{{ asset( 'logo/home.png' ) }}" alt="" class="object-cover">

        </div>

    </div>

</body>
@livewireScripts

</html>