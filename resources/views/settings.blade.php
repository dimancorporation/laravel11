<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Настройки
        </h2>
    </x-slot>

    {{--
    https://flowbite.com/docs/components/tabs/
    --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                            data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                    Договор оферты
                                </button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button
                                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                                    Поля сделки Битрикс24
                                </button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button
                                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="statuses-tab" data-tabs-target="#statuses" type="button" role="tab" aria-controls="statuses" aria-selected="false">
                                    Статусы сделки Битрикс24
                                </button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button
                                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
                                    Документы Битрикс24
                                </button>
                            </li>
                            <li role="presentation">
                                <button
                                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                    Вебхуки Битрикс24 и Онлайн касса
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div id="default-tab-content">
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
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
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="statuses" role="tabpanel" aria-labelledby="statuses-tab">
                            <form method="post" action="{{ route('save.b24statuses.fields') }}" class="mt-6 space-y-6">
                                @csrf

                                @foreach($b24Statuses as $field)
                                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 pb-1">
                                        <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        {{ $field->name }}
                                    </span>
                                            <input type="text" name="{{ $field->id }}"
                                                   value="{{ $field->b24_status_id }}"
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
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
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
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
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
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/{{$tinymceApiKey}}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#debtorText',
            height: 500,
            menubar: false,
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'link', 'lists', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                'casechange', 'export', 'formatpainter', 'pageembed', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'mentions', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf', 'textcolor'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | styleselect fontselect fontsizeselect | forecolor backcolor',
        });
    </script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    <div class="mb-4 border-gray-200 dark:border-gray-700">
                        <form method="post" action="{{ route('save.debtor.text') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="debtorText" class="w-1/2 after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700 mb-3">Текст для страницы должников</label>
                                <textarea id="debtorText" name="DEBTOR_MESSAGE" rows="10" cols="50">
                                    {{ $debtorMessage }}
                                </textarea>
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
</x-app-layout>
