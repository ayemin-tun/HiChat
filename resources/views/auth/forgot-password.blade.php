<x-guest-layout>
    <div class="grid md:grid-cols-2 grid-cols-1 border p-4 rounded-lg shadow w-2/3">
        <div>
            <img src="{{ asset( 'logo/forgot_password.png' ) }}" alt="" class="object-cover w-full md:h-96 h-44">
        </div>
        <div class="flex items-center p-5">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="rounded-lg w-full">
                <p class="text-gray-500 mb-4">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4 gap-4">
                    <a href="/" class="cursor-pointer hover:underline duration-300">Back</a>
                    <button type="submit" class="px-3 py-2 text-white rounded-lg bg-blue-700 hover:bg-blue-400 duration-300">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>






</x-guest-layout>