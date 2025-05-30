@props(['theme' => 'blue']) <!-- По умолчанию тема 'blue' -->
@php
    $class = 'bg-custom-blue-500'; // Значение по умолчанию

    if ($theme === 'green') {
        $class = 'bg-custom-green-500';
    } elseif ($theme === 'yellow') {
        $class = 'bg-custom-yellow-500';
    } elseif ($theme === 'red') {
        $class = 'bg-custom-red-500';
    } elseif ($theme === 'turquoise') {
        $class = 'bg-custom-turquoise-500';
    }
@endphp

<nav x-data="{ open: false }" class="{{ $class }}">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        @php
                            $filePath = 'images/logo/logo.png';
                        @endphp

                        @if (file_exists(storage_path('app/public/' . $filePath)))
                            <img src="{{ Storage::url($filePath) }}" alt="Логотип" style="max-height: 36px;">
                        @else
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        @endif
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->isUser() && Auth::user()->b24Status->name !== 'Должник')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" :theme="session('active_theme', 'blue')">
                            Моё дело
                        </x-nav-link>
                        <x-nav-link :href="route('status-descriptions')" :active="request()->routeIs('status-descriptions')" :theme="session('active_theme', 'blue')">
                            Описание статусов
                        </x-nav-link>
                        <x-nav-link :href="route('documents')" :active="request()->routeIs('documents')" :theme="session('active_theme', 'blue')">
                            Список документов
                        </x-nav-link>
                        <x-nav-link :href="route('offer-agreement')" :active="request()->routeIs('offer-agreement')" :theme="session('active_theme', 'blue')">
                            Договор оферты
                        </x-nav-link>
                        <x-nav-link :href="route('pay-invoice')" :active="request()->routeIs('pay-invoice')" :theme="session('active_theme', 'blue')">
                            Оплата
                        </x-nav-link>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('settings')" :active="request()->routeIs('settings')" :theme="session('active_theme', 'blue')">
                            Настройки
                        </x-nav-link>
                    @endif
                        <form method="POST" action="{{ route('logout') }}" class="group nav-link uppercase inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-white hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300 transition duration-150 ease-in-out">
                            @csrf

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">Выход</a>
                        </form>
                </div>
            </div>

            <!-- Settings Dropdown -->
{{--            <div class="hidden sm:flex sm:items-center sm:ms-6">--}}
{{--                <x-dropdown align="right" width="48">--}}
{{--                    <x-slot name="trigger">--}}
{{--                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">--}}
{{--                            <div>{{ Auth::user()->name }}</div>--}}

{{--                            <div class="ms-1">--}}
{{--                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />--}}
{{--                                </svg>--}}
{{--                            </div>--}}
{{--                        </button>--}}
{{--                    </x-slot>--}}

{{--                    <x-slot name="content">--}}
{{--                        <x-dropdown-link :href="route('profile.edit')">--}}
{{--                            Профиль--}}
{{--                        </x-dropdown-link>--}}

{{--                        <!-- Authentication -->--}}
{{--                        <form method="POST" action="{{ route('logout') }}">--}}
{{--                            @csrf--}}

{{--                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">--}}
{{--                                Выйти--}}
{{--                            </x-dropdown-link>--}}
{{--                        </form>--}}
{{--                    </x-slot>--}}
{{--                </x-dropdown>--}}
{{--            </div>--}}

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->isUser() && Auth::user()->b24Status->name !== 'Должник')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Моё дело
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('status-descriptions')" :active="request()->routeIs('status-descriptions')">
                    Описание статусов
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('documents')" :active="request()->routeIs('documents')">
                    Список документов
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('offer-agreement')" :active="request()->routeIs('offer-agreement')">
                    Договор оферты
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pay-invoice')" :active="request()->routeIs('pay-invoice')">
                    Оплата
                </x-responsive-nav-link>
            @endif
            @if(Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
                    Настройки
                </x-responsive-nav-link>
            @endif
                <form method="POST" action="{{ route('logout') }}" class="cursor-pointer block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                    @csrf

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">Выход</a>
                </form>
        </div>

        <!-- Responsive Settings Options -->
{{--        <div class="pt-4 pb-1 border-t border-gray-200">--}}
{{--            <div class="px-4">--}}
{{--                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>--}}
{{--                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>--}}
{{--            </div>--}}

{{--            <div class="mt-3 space-y-1">--}}
{{--                <x-responsive-nav-link :href="route('profile.edit')">--}}
{{--                    {{ __('Профиль') }}--}}
{{--                </x-responsive-nav-link>--}}

{{--                <!-- Authentication -->--}}
{{--                <form method="POST" action="{{ route('logout') }}">--}}
{{--                    @csrf--}}

{{--                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">--}}
{{--                        {{ __('Выйти') }}--}}
{{--                    </x-responsive-nav-link>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</nav>
