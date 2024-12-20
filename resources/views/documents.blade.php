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
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Паспорт (все страницы)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-1"
                                   type="checkbox"
                                   disabled
                                   @if($documents->passport_all_pages)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-1" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            ПТС
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-2"
                                   type="checkbox"
                                   disabled
                                   @if($documents->pts)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-2" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан ИНН
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-3"
                                   type="checkbox"
                                   disabled
                                   @if($documents->scan_inn)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-3" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан СНИЛСа
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-4"
                                   type="checkbox"
                                   disabled
                                   @if($documents->snils)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-4" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан свид. о заключении брака (если клиент в браке).
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-5"
                                   type="checkbox"
                                   disabled
                                   @if($documents->marriage_certificate)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-5" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан СНИЛСа в отношении супруга(и).
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-6"
                                   type="checkbox"
                                   disabled
                                   @if($documents->snils_spouse)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-6" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан. свид. о расторжении брака (если брак ранее расторгался)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-7"
                                   type="checkbox"
                                   disabled
                                   @if($documents->divorce_certificate)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-7" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан 2-НДФЛ за последние 3 года (если клиент раб. официально)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-8"
                                   type="checkbox"
                                   disabled
                                   @if($documents->ndfl)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-8" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан свид. о рождении детей (если у клиента есть иждивенцы до 18 лет)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-9"
                                   type="checkbox"
                                   disabled
                                   @if($documents->childrens_birth_certificate)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-9" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан выписки из ЕГРН недвижимости за последние 3 года по всей территории РФ
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-10"
                                   type="checkbox"
                                   disabled
                                   @if($documents->extract_egrn)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-10" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан ПТС (если у клиента в собственности есть движ. имущество)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-11"
                                   type="checkbox"
                                   disabled
                                   @if($documents->scan_pts)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-11" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан СТС (если у клиента в собственности есть движ. имущество)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-12"
                                   type="checkbox"
                                   disabled
                                   @if($documents->sts)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-12" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан ПТС (если в собственности супруга(и) есть движимое имущество)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-13"
                                   type="checkbox"
                                   disabled
                                   @if($documents->pts_spouse)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-13" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан СТС (если в собственности супруга(и) есть движимое имущество)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-14"
                                   type="checkbox"
                                   disabled
                                   @if($documents->sts_spouse)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-14" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан ДКП (если клиент за последние 3 г. продавал движимое имущество)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-15"
                                   type="checkbox"
                                   disabled
                                   @if($documents->dkp)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-15" class="sr-only">checkbox</label>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
                            Скан ДКП (если супруг(а) продавал(а) за последние 3 г. движимое имущество)
                        </div>
                        <div class="flex items-center justify-center w-4 p-4">
                            <input id="checkbox-table-16"
                                   type="checkbox"
                                   disabled
                                   @if($documents->dkp_spouse)
                                       checked
                                   @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-16" class="sr-only">checkbox</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
