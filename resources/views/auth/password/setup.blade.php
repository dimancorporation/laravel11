<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('После первой авторизации вы должны сменить пароль. Укажите свой email и на него будет отправлена информация о новом пароле.') }}
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.setup.update') }}">
        @csrf
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            @error('email')
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            @enderror
        </div>

        <!-- Old Password -->
        <div class="mt-4">
            <x-input-label for="current_password" :value="__('Старый пароль')" />

            <x-text-input id="current_password" class="block mt-1 w-full"
                          type="password"
                          name="current_password" required autocomplete="old-password" />

            @error('email')
                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Новый пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

            @error('email')
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Подтверждение нового пароля')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            @error('email')
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button-green class="ms-4">
                {{ __('Сменить пароль') }}
            </x-primary-button-green>
        </div>
    </form>
</x-guest-layout>
