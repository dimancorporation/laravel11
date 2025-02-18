<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Оплата
        </h2>
    </x-slot>
    <!-- Main modal -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Форма оплаты
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form class="space-y-2 px-5 pb-5" name="payform-tbank" id="payform-tbank">
                        <!-- Скрытые поля -->
                        <input type="hidden" name="terminalkey" value="{{ $paymentSettings[0] }}">
                        <input type="hidden" name="frame" value="false">
                        <input type="hidden" name="language" value="ru">
                        <input type="hidden" name="receipt" value="">
                        <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="b24DealId" value="{{ Auth::user()->id_b24 }}">
                        <!-- Видимые поля -->
                        <div class="flex flex-col space-y-1">
                            <label for="amount">Сумма</label>
                            <input id="amount"
                                   class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   type="text" placeholder="Сумма" name="amount" required>
                        </div>
                        <div class="flex flex-col space-y-1 hidden">
                            <label for="order">Номер заказа</label>
                            <input id="order"
                                   disabled
                                   class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   type="text" placeholder="Номер заказа" name="order">
                        </div>
                        <div class="flex flex-col space-y-1 hidden">
                            <label for="description">Описание заказа</label>
                            <input id="description"
                                   value="Оплата по договору"
                                   disabled
                                   class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   type="text" placeholder="Описание заказа" name="description">
                        </div>
                        <div class="flex flex-col space-y-1 hidden">
                            <label for="name">ФИО плательщика</label>
                            <input id="name"
                                   value="{{ $user->name }}"
                                   disabled
                                   class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   type="text" placeholder="ФИО плательщика" name="name">
                        </div>
                        <div class="flex flex-col space-y-1 hidden">
                            <label for="email">E-mail</label>
                            <input id="email"
                                   value="{{ $user->email }}"
                                   disabled
                                   class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   type="email" placeholder="E-mail" name="email">
                        </div>
                        <div class="flex flex-col space-y-1 hidden">
                            <label for="phone">Контактный телефон</label>
                            <input id="phone"
                                   value="{{ $user->phone }}"
                                   disabled
                                   class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   type="tel" placeholder="Контактный телефон" name="phone">
                        </div>
                        <div class="flex flex-col space-y-1">
                            <label for="offer_agreement" class="inline-flex items-center">
                                <input id="offer_agreement" type="checkbox"
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                       name="offer_agreement" checked>
                                <span class="ms-2 text-sm text-gray-600">Согласен с договором <a
                                        class="text-blue-600 border-b border-dashed border-b-blue-500"
                                        href="{{ asset('storage/docs/offer_agreement.pdf') }}" target="_blank">публичной офферты</a></span>
                            </label>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <button
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">Оплатить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto min-[300px]:px-0 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 sm:p-6 text-gray-900">
                    @php
                        $alreadyPaid = $invoices->sum('opportunity');
                    @endphp

                    @foreach($invoices as $invoice)
                        <div
                            class="flex flex-row justify-between items-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                <div class="flex items-center gap-1 mb-1">
                                    <img class="w-[18px] h-[18px]" src="{{ asset('images/icons/calendar.png' )}}" alt="Дата оплаты" title="Дата оплаты">
                                    {{ date_format(date_create($invoice->moved_time), 'd.m.Y') }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <img class="w-[18px] h-[18px]" src="{{ asset('images/icons/clock.png' )}}" alt="Время оплаты" title="Время оплаты">
                                    {{ date_format(date_create($invoice->moved_time), 'H:i') }}
                                </div>
                            </div>
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                <div id="tooltip-top{{$invoice->id}}" role="tooltip"
                                     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    {{ $invoice->b24_payment_type_name }}
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                                @if($invoice->b24_payment_type_name === 'Оплата на карту')
                                    <img class="w-[36px] h-auto" src="{{ asset('images/icons/card.png' )}}"
                                         alt="{{ $invoice->b24_payment_type_name }}"
                                         title="{{ $invoice->b24_payment_type_name }}"
                                         data-tooltip-target="tooltip-top{{$invoice->id}}" data-tooltip-placement="top">
                                @endif
                                @if($invoice->b24_payment_type_name === 'Наличные')
                                    <img class="w-[36px] h-auto" src="{{ asset('images/icons/cash.png' )}}"
                                         alt="{{ $invoice->b24_payment_type_name }}"
                                         title="{{ $invoice->b24_payment_type_name }}"
                                         data-tooltip-target="tooltip-top{{$invoice->id}}" data-tooltip-placement="top">
                                @endif
                                @if($invoice->b24_payment_type_name === 'На расчетный счет компании')
                                    <img class="w-[36px] h-auto" src="{{ asset('images/icons/bank.png' )}}"
                                         alt="{{ $invoice->b24_payment_type_name }}"
                                         title="{{ $invoice->b24_payment_type_name }}"
                                         data-tooltip-target="tooltip-top{{$invoice->id}}" data-tooltip-placement="top">
                                @endif
                            </div>
                            <div class="pl-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                {{ number_format($invoice->opportunity, 0, ',', ' ') }} руб
                            </div>
                        </div>
                    @endforeach

                    @if (count($invoices) > 0)
                        <div
                            class="flex flex-row justify-between items-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 font-semibold">
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12"></div>
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                ИТОГО:
                            </div>
                            <div class="pl-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                {{ number_format($alreadyPaid, 0, ',', ' ') }} руб
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-between items-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 font-semibold">
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12"></div>
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                ОСТАТОК ПО ДОГОВОРУ:
                            </div>
                            <div class="pl-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                {{ number_format(Auth::user()->sum_contract - $alreadyPaid, 0, ',', ' ') }} руб
                            </div>
                        </div>
                    @endif

                    <div
                        class="flex flex-row justify-between items-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700 font-semibold">
                        <div
                            class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-full flex justify-center">
                            <!-- Modal toggle -->
                            <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                                    class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                    type="button">
                                Внести оплату по договору
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff_v2.js"></script>
    <script type="text/javascript">
        const terminalKey = "{{ $paymentSettings[0] }}";
        const emailCompany = "{{ $paymentSettings[1] }}";
        console.log(terminalKey);
        console.log(emailCompany);
        const TPF = document.getElementById('payform-tbank');

        TPF.addEventListener('submit', function (e) {
            e.preventDefault();
            const {description, amount, email, phone, receipt, offer_agreement} = TPF;

            if (!offer_agreement.checked) {
                return alert('Обязательно согласие с договором публичной оферты');
            }

            if (receipt) {
                if (!email.value && !phone.value) {
                    return alert('Поле E-mail или Телефон не должно быть пустым');
                }

                TPF.receipt.value = JSON.stringify({
                    'EmailCompany': emailCompany,
                    'Taxation': 'patent',
                    'FfdVersion': '1.2',
                    'Items': [
                        {
                            'Name': description.value || 'Оплата',
                            'Price': Math.round(amount.value * 100),
                            'Quantity': 1.00,
                            'Amount': Math.round(amount.value * 100),
                            'PaymentMethod': 'full_prepayment',
                            'PaymentObject': 'service',
                            'Tax': 'none',
                            'MeasurementUnit': 'pc'
                        }
                    ]
                });
            }
            console.log('TPF', TPF);
            pay(TPF);
        })
    </script>
</x-app-layout>
