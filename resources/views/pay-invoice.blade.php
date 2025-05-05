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
                                <input type="hidden" name="terminalkey" value="1712638738287">
                                <input type="hidden" name="Token" value="">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff_v2.js"></script>
    <script type="text/javascript">
        console.log(99);
        const terminalKey = "{{ $paymentSettings[0] }}";
        const emailCompany = "opttg@yandex.ru";
        console.log(terminalKey);
        console.log(emailCompany);
        const TPF = document.getElementById('payform-tbank');

        // Функция для генерации токена
        function generateToken(terminalKey, amount, password, orderId, description) {
            // Создаем массив с данными для токена
            const tokenData = [
                { "TerminalKey": terminalKey },
                { "Amount": Math.round(amount * 100).toString() },
                { "OrderId": orderId },
                { "Description": description },
                { "Password": password }
            ];

            // Сортируем массив по ключам в алфавитном порядке
            tokenData.sort((a, b) => {
                const keyA = Object.keys(a)[0];
                const keyB = Object.keys(b)[0];
                return keyA.localeCompare(keyB);
            });

            // Конкатенируем только значения в одну строку
            let concatenatedString = '';
            for (const item of tokenData) {
                const key = Object.keys(item)[0];
                const value = item[key];
                if (value) { // Пропускаем пустые значения
                    concatenatedString += value;
                }
            }

            // Хешируем строку с помощью SHA-256
            return CryptoJS.SHA256(concatenatedString).toString();
        }

        TPF.addEventListener('submit', async function (e) {
            e.preventDefault();
            try {
                const {description, amount, email, phone, receipt, offer_agreement} = TPF;

                const terminalKey = document.querySelector('[name="terminalkey"]').value;
                const password = 'yntgerck7zzpt23w'; // Убедитесь, что это правильный пароль/секретный ключ
                const orderId = Date.now().toString(); // Уникальный ID заказа

                console.log('terminalKey:', terminalKey);
                console.log('amount:', amount.value);
                console.log('password:', password);
                console.log('description:', description.value);
                console.log('orderId:', orderId);

                if (!offer_agreement.checked) {
                    return alert('Обязательно согласие с договором публичной оферты');
                }

                // Создаем объект для отправки в Tinkoff API
                const paymentData = {
                    TerminalKey: terminalKey,
                    Amount: Math.round(amount.value * 100),
                    OrderId: orderId,
                    Description: description.value || 'Оплата'
                };

                if (receipt && (email.value || phone.value)) {
                    if (!email.value && !phone.value) {
                        return alert('Поле E-mail или Телефон не должно быть пустым');
                    }

                    // Создаем объект Receipt
                    paymentData.Receipt = {
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
                        ],
                        'Email': email.value || '',
                        'Phone': phone.value || ''
                    };
                }

                // Генерируем токен после формирования всех данных
                const token = generateToken(
                    terminalKey,
                    amount.value,
                    password,
                    orderId,
                    description.value || 'Оплата'
                );

                // Добавляем токен в данные запроса
                paymentData.Token = token;

                console.log('Отправляемые данные:', paymentData);

                // Отправляем запрос напрямую в API Tinkoff
                fetch('https://securepay.tinkoff.ru/v2/Init', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(paymentData)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Ответ от сервера:', data);
                        if (data.Success && data.PaymentURL) {
                            // Перенаправляем на страницу оплаты
                            window.location.href = data.PaymentURL;
                        } else {
                            alert('Ошибка при инициализации платежа: ' + (data.Message || 'Неизвестная ошибка'));
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при отправке запроса:', error);
                        alert('Ошибка при отправке запроса: ' + error.message);
                    });

            } catch (error) {
                console.error('Ошибка при обработке формы:', error);
                alert('Ошибка при обработке формы: ' + error.message);
            }
        });

        // Функция для генерации токена
        /*
        function generateToken(terminalKey, amount, password, description) {
            // 1. Создаем массив пар ключ-значение
            const pairs = [
                { 'TerminalKey': terminalKey },
                { 'Amount': amount },
                { 'Description': description },
                { 'Password': password }
            ];

            // 2. Сортируем массив по алфавиту по ключу
            pairs.sort((a, b) => {
                const keyA = Object.keys(a)[0];
                const keyB = Object.keys(b)[0];
                return keyA.localeCompare(keyB);
            });

            // 3. Конкатенируем значения в одну строку
            let concatenatedString = '';
            pairs.forEach(pair => {
                const key = Object.keys(pair)[0];
                concatenatedString += pair[key];
            });

            // 4. Применяем хеш-функцию SHA-256
            return sha256(concatenatedString);
        }
*/
        // Функция для вычисления SHA-256 (требует подключения внешней библиотеки)
        async function sha256(message) {
            // Кодируем строку в формате UTF-8
            const msgBuffer = new TextEncoder().encode(message);

            // Вычисляем хеш с использованием встроенного API
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);

            // Преобразуем ArrayBuffer в массив байтов
            const hashArray = Array.from(new Uint8Array(hashBuffer));

            // Преобразуем байты в шестнадцатеричную строку
            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

            return hashHex;
        }
    </script>
</x-app-layout>
