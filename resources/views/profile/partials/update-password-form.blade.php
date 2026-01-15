{{-- 
Sezione: Aggiornamento password utente (Automarket)

Funzionalità:
- Permette all’utente di aggiornare la propria password
- Richiede password attuale, nuova password e conferma
- Mostra errori di validazione per ogni campo
- Conferma visiva “Saved.” con dissolvenza automatica
- Utilizza componenti Jetstream (x-input-label, x-text-input, x-primary-button)
- Stile coerente con tema dark/light
--}}

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Password attuale --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" required />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Nuova password con validazione dinamica + mostra/nascondi + forza --}}
        <div x-data="{
            pwd: '',
            show: false,
            get hasLower() { return /[a-z]/.test(this.pwd) },
            get hasUpper() { return /[A-Z]/.test(this.pwd) },
            get hasNumber() { return /[0-9]/.test(this.pwd) },
            get hasSpecial() { return /[@$!%*#?&]/.test(this.pwd) },
            get hasLength() { return this.pwd.length >= 8 },
        
            // Calcolo forza password
            get strength() {
                let score = 0;
                if (this.hasLower) score++;
                if (this.hasUpper) score++;
                if (this.hasNumber) score++;
                if (this.hasSpecial) score++;
                if (this.hasLength) score++;
        
                if (score <= 2) return 'weak';
                if (score === 3 || score === 4) return 'medium';
                return 'strong';
            }
        }">

            <x-input-label for="update_password_password" :value="__('New Password')" />

            <div class="relative">
                <x-text-input id="update_password_password" name="password" :type="show ? 'text' : 'password'"
                    class="mt-1 block w-full pr-10" autocomplete="new-password" required minlength="8"
                    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}"
                    title="Minimo 8 caratteri, almeno una maiuscola, una minuscola, un numero e un carattere speciale"
                    x-model="pwd" />

                {{-- Bottone mostra/nascondi --}}
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-200">
                    <span x-show="!show">👁️</span>
                    <span x-show="show">🙈</span>
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

            {{-- Indicatore forza password --}}
            <div class="mt-2 text-sm font-semibold"
                :class="{
                    'text-red-400': strength === 'weak',
                    'text-yellow-400': strength === 'medium',
                    'text-green-400': strength === 'strong'
                }">
                <span
                    x-text="strength === 'weak' ? 'Password debole'
                             : strength === 'medium' ? 'Password media'
                             : 'Password forte'"></span>
            </div>

            {{-- Lista requisiti dinamici --}}
            <ul class="mt-3 text-sm space-y-1">
                <li :class="hasLower ? 'text-green-400' : 'text-red-400'">
                    <span x-text="hasLower ? '✔' : '✘'"></span> Una lettera minuscola
                </li>
                <li :class="hasUpper ? 'text-green-400' : 'text-red-400'">
                    <span x-text="hasUpper ? '✔' : '✘'"></span> Una lettera maiuscola
                </li>
                <li :class="hasNumber ? 'text-green-400' : 'text-red-400'">
                    <span x-text="hasNumber ? '✔' : '✘'"></span> Un numero
                </li>
                <li :class="hasSpecial ? 'text-green-400' : 'text-red-400'">
                    <span x-text="hasSpecial ? '✔' : '✘'"></span> Un carattere speciale (@$!%*#?&)
                </li>
                <li :class="hasLength ? 'text-green-400' : 'text-red-400'">
                    <span x-text="hasLength ? '✔' : '✘'"></span> Minimo 8 caratteri
                </li>
            </ul>
        </div>

        {{-- Conferma nuova password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" autocomplete="new-password" required />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Pulsanti --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
