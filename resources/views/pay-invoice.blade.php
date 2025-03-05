<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Оплата
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto min-[300px]:px-0 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 sm:p-6 text-gray-900">
                    <div class="flex flex-row justify-between items-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700 font-semibold">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-full flex justify-center">
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
                                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                        Оплатить
                                    </button>
                                </div>
                            </form>
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
