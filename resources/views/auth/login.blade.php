<x-guest-layout>

    <div class="w-full max-w-md bg-gray-800 p-10 rounded-xl shadow-xl">

        <h1
            class="text-3xl font-bold mb-8 text-transparent bg-clip-text bg-gradient-to-r 
                from-green-400 via-green-500 to-green-600 drop-shadow-[0_0_20px_#22c55e] text-center">
            Accedi al tuo account
        </h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-green-400 text-sm text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-300" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                    autocomplete="username" class="w-full rounded bg-gray-700 text-white border-gray-600 p-3" />
                <x-input-error :messages="$errors->get('email')" class="text-red-400 text-sm mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-300" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full rounded bg-gray-700 text-white border-gray-600 p-3" />
                <x-input-error :messages="$errors->get('password')" class="text-red-400 text-sm mt-1" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded bg-gray-700 border-gray-600 text-green-500 focus:ring-green-500">
                <label for="remember_me" class="ms-2 text-sm text-gray-300">
                    {{ __('Ricordami') }}
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-green-400 hover:underline">
                        {{ __('Hai dimenticato la password?') }}
                    </a>
                @endif

                <x-primary-button
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-lg shadow">
                    {{ __('Accedi') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-guest-layout>
