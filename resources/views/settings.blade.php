<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Настройки
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    <div class="mb-4 dark:border-gray-700">
                        <form method="post" action="{{ route('upload.offer.agreement') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Договор оферты</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                   id="file_input"
                                   name="file"
                                   value="offer-agreement.pdf"
                                   type="file"
                                   accept="application/pdf">
                            <div class="flex justify-end">
                                <x-primary-button-green class="mr-3">
                                    {{ __('Сохранить') }}
                                </x-primary-button-green>
                            </div>
                        </form>

                        <form method="post" action="{{ route('admin.theme.update') }}" class="mt-6 space-y-6">
                            @csrf
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="theme_name">Выберите тему:</label>
                            <select name="theme_name" id="theme_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($themes as $theme)
                                    @php
                                        $formattedThemeName = ucwords(str_replace('_', ' ', $theme->theme_name));
                                    @endphp
                                    <option value="{{ $theme->theme_name }}" {{ $activeTheme->theme_name === $theme->theme_name ? 'selected' : '' }} data-description="{{ $theme->description }}">
                                        {{ $formattedThemeName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="flex justify-end">
                                <x-primary-button-green class="mr-3">
                                    {{ __('Сохранить') }}
                                </x-primary-button-green>
                            </div>
                        </form>

                        <form method="post" action="{{ route('admin.logo.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="logo">Выберите логотип (макс. размер 10мб, допустимые расширения .jpeg, .jpg, .png)</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                   id="logo"
                                   name="logo"
                                   type="file"
                                   accept=".jpeg,.jpg,.png,image/jpeg,image/png">

{{--                            Текущий логотип--}}
{{--                            @php--}}
{{--                                $filePath = 'images/logo/logo.png';--}}
{{--                            @endphp--}}

{{--                            @if (file_exists(storage_path('app/public/' . $filePath)))--}}
{{--                                <img src="{{ Storage::url($filePath) }}" alt="Логотип" style="max-width: 200px;">--}}
{{--                            @else--}}
{{--                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />--}}
{{--                            @endif--}}

                            <div class="flex justify-end">
                                <x-primary-button-green class="mr-3">
                                    {{ __('Сохранить') }}
                                </x-primary-button-green>
                            </div>
                        </form>

                        <form id="debtorTextForm" method="post" action="{{ route('save.debtor.text') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="debtorText" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Текст для страницы должников</label>
                                <div id="debtorText">
                                    {!! $debtorMessage !!}
                                </div>
                                <textarea name="DEBTOR_MESSAGE" id="debtorMessageTextarea" style="display:none;"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <x-primary-button-green class="mr-3">
                                    {{ __('Сохранить') }}
                                </x-primary-button-green>
                            </div>
                        </form>

                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                            <x-tabs-buttons :tabs="[
                                [
                                    'id' => 'profile',
                                    'visible' => false,
                                    'title' => 'Настройки'
                                ],
                                [
                                    'id' => 'dashboard',
                                    'visible' => false,
                                    'title' => 'Поля сделки Битрикс24'
                                ],
                                [
                                    'id' => 'statuses',
                                    'visible' => false,
                                    'title' => 'Статусы сделки Битрикс24'
                                ],
                                [
                                    'id' => 'settings',
                                    'visible' => false,
                                    'title' => 'Документы Битрикс24'
                                ],
                                [
                                    'id' => 'contacts',
                                    'visible' => false,
                                    'title' => 'Вебхуки Битрикс24 и Онлайн касса'
                                ]
                            ]" />
                        </ul>
                    </div>
                    <div id="default-tab-content">
                        <x-offer-agreement-tab :activeTheme="$activeTheme" :themes="$themes"/>
                        <x-user-fields-tab :b24-user-fields="$b24UserFields" />
                        <x-statuses-tab :b24-statuses="$b24Statuses" />
                        <x-docs-tab :b24-doc-fields="$b24DocFields" />
                        <x-webhook-tab :settings-fields="$settingsFields" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <div class="py-12 hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    <div class="mb-4 border-gray-200 dark:border-gray-700">
                        <form id="debtorTextForm" method="post" action="{{ route('save.debtor.text') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="debtorText" class="w-1/2 after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700 mb-3">Текст для страницы должников</label>
                                <div id="debtorText">
                                    {!! $debtorMessage !!}
                                </div>
                                <textarea name="DEBTOR_MESSAGE" id="debtorMessageTextarea" style="display:none;"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <x-primary-button-green class="mr-3">
                                    {{ __('Сохранить') }}
                                </x-primary-button-green>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        const toolbarOptions = [
            ['bold', 'italic', 'underline'],
            ['link'],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            ['clean']
        ];
        const quill = new Quill('#debtorText', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    </script>
    <script>
        document.querySelector('#debtorTextForm').addEventListener('submit', function(event) {
            event.preventDefault();
            document.querySelector('#debtorMessageTextarea').value = document.querySelector('#debtorText .ql-editor').innerHTML;
            this.submit();
        });
    </script>
    <style>
        .ql-editor {
            min-height: 320px;
        }
    </style>
</x-app-layout>
