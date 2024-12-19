<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Настройки
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 p-6 text-gray-900">
                    Форма с настройками полей битрикс24 и сайта
                    <form method="post" action="" class="mt-6 space-y-6">
                        @csrf
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Создать лк клиенту
                                    </span>
                                <input type="text" name="USER_CREATE_ACCOUNT"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
                        </div>
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Логин лк клиента
                                    </span>
                                <input type="text" name="USER_LOGIN"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
                        </div>
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Пароль лк клиента
                                    </span>
                                <input type="text" name="USER_PASSWORD"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
                        </div>
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Статус для лк клиента
                                    </span>
                                <input type="text" name="USER_STATUS"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
                        </div>
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Сумма договора
                                    </span>
                                <input type="text" name="USER_CONTRACT_AMOUNT"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
                        </div>
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Сообщение клиенту от компании
                                    </span>
                                <input type="text" name="USER_MESSAGE_FROM_B24"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
                        </div>
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Ссылка на дело в кадр. арбитр
                                    </span>
                                <input type="text" name="USER_LINK_TO_COURT"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
                        </div>
                        <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <label class="w-full flex items-center">
                                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                                        Дата последней авторизации (мск)
                                    </span>
                                <input type="text" name="USER_LAST_AUTH_DATE"
                                       class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                                       placeholder="UF_CRM_1234567890123"/>
                                <input type="text" class="hidden">
                            </label>
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
</x-app-layout>
