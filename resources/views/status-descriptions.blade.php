<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Описание статусов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <video class="w-full h-auto max-w-full" controls>
                        <source src="{{asset('video/status_desc_video.mp4')}}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12 pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Договор неактивен
                            </a>
                        </div>
                        <div>
                            - Статус означает что ваш договор на текущий момент не передан в исполнение.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Правовой анализ
                            </a>
                        </div>
                        <div>
                            - Статус означает что ваше дело было принято Юристом в работу. Наш юрист создает стратегию по вашему делу. Производит анализ Анкеты, заполненную в вашем присутствии в нашем офисе. В зависимости от сложности дела количество и доступность документов, сделка может находиться в данной стадии до 1 недели.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Запросы БКИ
                            </a>
                        </div>
                        <div>
                            - Статус означает, что в отношении вас было подготовлено и направлено заявление в ЦБ РФ о предоставлении перечня БКИ для предоставления информации по вашим кредитам (долгам). Дело может находиться в данной стадии до 20 дней в зависимости от работы ведомств.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Поиск имущества и сделок
                            </a>
                        </div>
                        <div>
                            – Статус означает, что наши юристы проверяют все данные по вашему имуществу, путем запросов информации из соответствующих ведомств. Срок нахождения в данной стадии до 30 дней.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Реестр документов
                            </a>
                        </div>
                        <div>
                            – Статус означает, наши юристы получили ответы по вашему имуществу и сделкам, а так же по всем вашим долгам. Формируют итоговый список документов. Срок нахождения в данной стадии до 30 дней.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Сбор документов
                            </a>
                        </div>
                        <div>
                            – Статус означает, на этом этапе происходит отправка запросов в Государственные органы (ГиБДД, ГиМС, РосГвардия, ГосТехНадзор и т.д.) Максимальный срок нахождения на данном этапе до 65 дней, зависит от ведомств и наличия документов у клиента.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Готов на подачу в АС
                            </a>
                        </div>
                        <div>
                            - Наши юристы получили все необходимые ответы из ведомств и сейчас формируют пакет документов для подачи в Арбитражный суд. Срок нахождения в данной стадии зависит от оплат клиентом и наличия документов, в среднем до 30 дней.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Введение процедуры БФЛ
                            </a>
                        </div>
                        <div>
                            – Наши юристы подали заявление в Арбитражный суд, ожидаем даты назначения первого заседания в суде. Срок нахождения на данном этапе до 30 дней, зависит от загруженности Арбитражного суда.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Судебный процесс
                            </a>
                        </div>
                        <div>
                            - Основной этап, судебного процесса в Арбитражном суде. Информацию по прохождению дела можете получить на странице «Мое дело», нажав на кнопку Арбитражный суд. Срок нахождения в данной стадии до предположительного окончания судебного процесса.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Завершение суда
                            </a>
                        </div>
                        <div>
                            – На данном этапе наши юристы готовятся к окончанию судебного процесса. Срок нахождения до завершения судебного процесса.
                        </div>
                    </div>
                    <div class="my-5 max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex gap-5 items-center min-[320px]:flex-col max-[600px]:flex-col sm:flex-row">
                        <div class="min-[320px]:w-full sm:w-60">
                            <a href="#" class="h-14 min-[320px]:w-full sm:w-60 justify-center min-w-60 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-blue-800">
                                Списание долга
                            </a>
                        </div>
                        <div>
                            - Судебное заседание по делу завершено. На данном этапе происходит проверка данных, а также проверка возможных апелляционных жалоб от кредиторов. Срок на данном этапе 14 дней.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
