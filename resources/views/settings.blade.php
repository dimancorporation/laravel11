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
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                            <x-tabs-buttons :tabs="[
                                [
                                    'id' => 'profile',
                                    'title' => 'Договор оферты'
                                ],
                                [
                                    'id' => 'dashboard',
                                    'title' => 'Поля сделки Битрикс24'
                                ],
                                [
                                    'id' => 'statuses',
                                    'title' => 'Статусы сделки Битрикс24'
                                ],
                                [
                                    'id' => 'settings',
                                    'title' => 'Документы Битрикс24'
                                ],
                                [
                                    'id' => 'contacts',
                                    'title' => 'Вебхуки Битрикс24 и Онлайн касса'
                                ]
                            ]" />
                        </ul>
                    </div>
                    <div id="default-tab-content">
                        <x-offer-agreement-tab />
                        <x-user-fields-tab :b24-user-fields="$b24UserFields" />
                        <x-statuses-tab :b24-statuses="$b24Statuses" />
                        <x-docs-tab :b24-doc-fields="$b24DocFields" />
                        <x-webhook-tab :settings-fields="$settingsFields" />
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
