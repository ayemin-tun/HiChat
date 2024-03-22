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
                    <br/>
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