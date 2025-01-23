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
                        <source src="{{ asset('video/status_desc_video.mp4' )}}" type="video/mp4">
                        Ваш браузер не поддерживает данный видео тег.
                    </video>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12 pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @php
                        $dealStatuses = [
                            ['header' => 'Договор неактивен', 'description' => 'Статус означает что ваш договор на текущий момент не передан в исполнение.'],
                            ['header' => 'Правовой анализ', 'description' => 'Статус означает что ваше дело было принято Юристом в работу. Наш юрист создает стратегию по вашему делу. Производит анализ Анкеты, заполненную в вашем присутствии в нашем офисе. В зависимости от сложности дела количество и доступность документов, сделка может находиться в данной стадии до 1 недели.'],
                            ['header' => 'Запросы БКИ', 'description' => 'Статус означает, что в отношении вас было подготовлено и направлено заявление в ЦБ РФ о предоставлении перечня БКИ для предоставления информации по вашим кредитам (долгам). Дело может находиться в данной стадии до 20 дней в зависимости от работы ведомств.'],
                            ['header' => 'Поиск имущества и сделок', 'description' => 'Статус означает, что наши юристы проверяют все данные по вашему имуществу, путем запросов информации из соответствующих ведомств. Срок нахождения в данной стадии до 30 дней.'],
                            ['header' => 'Реестр документов', 'description' => 'Статус означает, наши юристы получили ответы по вашему имуществу и сделкам, а так же по всем вашим долгам. Формируют итоговый список документов. Срок нахождения в данной стадии до 30 дней.'],
                            ['header' => 'Сбор документов', 'description' => 'Статус означает, на этом этапе происходит отправка запросов в Государственные органы (ГиБДД, ГиМС, РосГвардия, ГосТехНадзор и т.д.) Максимальный срок нахождения на данном этапе до 65 дней, зависит от ведомств и наличия документов у клиента.'],
                            ['header' => 'Готов на подачу в АС', 'description' => 'Наши юристы получили все необходимые ответы из ведомств и сейчас формируют пакет документов для подачи в Арбитражный суд. Срок нахождения в данной стадии зависит от оплат клиентом и наличия документов, в среднем до 30 дней.'],
                            ['header' => 'Введение процедуры БФЛ', 'description' => 'Наши юристы подали заявление в Арбитражный суд, ожидаем даты назначения первого заседания в суде. Срок нахождения на данном этапе до 30 дней, зависит от загруженности Арбитражного суда.'],
                            ['header' => 'Судебный процесс', 'description' => 'Основной этап, судебного процесса в Арбитражном суде. Информацию по прохождению дела можете получить на странице «Мое дело», нажав на кнопку Арбитражный суд. Срок нахождения в данной стадии до предположительного окончания судебного процесса.'],
                            ['header' => 'Завершение суда', 'description' => 'На данном этапе наши юристы готовятся к окончанию судебного процесса. Срок нахождения до завершения судебного процесса.'],
                            ['header' => 'Списание долга', 'description' => 'Судебное заседание по делу завершено. На данном этапе происходит проверка данных, а также проверка возможных апелляционных жалоб от кредиторов. Срок на данном этапе 14 дней.']
                        ];
                    @endphp
                    @foreach ($dealStatuses as $status)
                        <x-deal-status header="{{ $status['header'] }}" description="{{ $status['description'] }}" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
