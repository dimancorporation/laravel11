<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Настройки
        </h2>
    </x-slot>

    {{--
    https://flowbite.com/docs/plugins/wysiwyg/
    --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
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
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    <form method="post" action="{{ route('save.user.fields') }}" class="mt-6 space-y-6">
                        @csrf

                        @foreach($b24UserFields as $field)
                            <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 pb-1">
                                <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        {{ $field->b24_field }}
                                    </span>
                                    <input type="text" name="{{ $field->site_field }}"
                                           value="{{ $field->uf_crm_code }}"
                                           class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                           placeholder="UF_CRM_1234567890123"/>
                                </label>
                            </div>
                        @endforeach
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    Форма с настройками полей битрикс24 и сайта
                    <form method="post" action="{{ route('save.doc.fields') }}" class="mt-6 space-y-6">
                        @csrf

                        @foreach($b24DocFields as $field)
                            <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 pb-1">
                                <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        {{ $field->b24_field }}
                                    </span>
                                    <input type="text" name="{{ $field->site_field }}"
                                           value="{{ $field->uf_crm_code }}"
                                           class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                           placeholder="UF_CRM_1234567890123"/>
                                </label>
                            </div>
                        @endforeach
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    Настройки вебхуков и данных для оплаты через Т-Кассу
                    <form method="post" action="{{ route('save.setting.fields') }}" class="mt-6 space-y-6">
                        @csrf

                        @foreach($settingsFields as $field)
                            <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 pb-1">
                                <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        {{ $field->name }}
                                    </span>
                                    <input type="text" name="{{ $field->code }}"
                                           value="{{ $field->value }}"
                                           class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                           placeholder="{{ $field->value }}"/>
                                </label>
                            </div>
                        @endforeach
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
</x-app-layout>
