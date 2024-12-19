<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('После первой авторизации вы должны сменить пароль. Укажите свой email и на него будет отправлена информация о новом пароле.') }}
    </div>

    <form method="POST" action="{{ route('setup-password') }}">
        @csrf
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Old Password -->
        <div class="mt-4">
            <x-input-label for="old_password" :value="__('Старый пароль')" />

            <x-text-input id="old_password" class="block mt-1 w-full"
                          type="password"
                          name="old_password" required autocomplete="old-password" />

            <x-input-error :messages="$errors->get('old_password')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Подтверждение пароля')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button-green class="ms-4">
                {{ __('Сменить пароль') }}
            </x-primary-button-green>
        </div>
    </form>
</x-guest-layout>
