<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Список документов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto min-[300px]:px-0 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 sm:p-6 text-gray-900">
                    @php
                        $documentFields = [
                            'passport_all_pages' => 'Паспорт (все страницы)',
                            'pts' => 'ПТС',
                            'scan_inn' => 'Скан ИНН',
                            'snils' => 'Скан СНИЛСа',
                            'marriage_certificate' => 'Скан свид. о заключении брака (если клиент в браке).',
                            'passport_spouse' => 'Паспорт супруга',
                            'snils_spouse' => 'Скан СНИЛСа в отношении супруга(и).',
                            'divorce_certificate' => 'Скан. свид. о расторжении брака (если брак ранее расторгался)',
                            'ndfl' => 'Скан 2-НДФЛ за последние 3 года (если клиент раб. официально)',
                            'childrens_birth_certificate' => 'Скан свид. о рождении детей (если у клиента есть иждивенцы до 18 лет)',
                            'extract_egrn' => 'Скан выписки из ЕГРН недвижимости за последние 3 года по всей территории РФ',
                            'scan_pts' => 'Скан ПТС (если у клиента в собственности есть движ. имущество)',
                            'sts' => 'Скан СТС (если у клиента в собственности есть движ. имущество)',
                            'pts_spouse' => 'Скан ПТС (если в собственности супруга(и) есть движимое имущество)',
                            'sts_spouse' => 'Скан СТС (если в собственности супруга(и) есть движимое имущество)',
                            'dkp' => 'Скан ДКП (если клиент за последние 3 г. продавал движимое имущество)',
                            'dkp_spouse' => 'Скан ДКП (если супруг(а) продавал(а) за последние 3 г. движимое имущество)'
                        ];
                    @endphp
                    @foreach ($documentFields as $field => $title)
                        <x-document-row title="{{$title}}" :checked="$documents->$field" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
