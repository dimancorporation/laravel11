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
                    @php
                        $totalSum = $invoices->sum('opportunity');
                    @endphp

                    @foreach($invoices as $invoice)
                        <div class="flex flex-row justify-between items-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                {{ date_format(date_create($invoice->moved_time), 'd.m.Y') }}
                            </div>
                            <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                @if($invoice->b24_payment_type_name === 'Оплата на карту')
                                    <img class="w-[36px] h-auto" src="{{ asset('images/icons/card.png' )}}" alt="{{ $invoice->b24_payment_type_name }}" title="{{ $invoice->b24_payment_type_name }}">
                                @endif
                                @if($invoice->b24_payment_type_name === 'Наличные')
                                        <img class="w-[36px] h-auto" src="{{ asset('images/icons/cash.png' )}}" alt="{{ $invoice->b24_payment_type_name }}" title="{{ $invoice->b24_payment_type_name }}">
                                @endif
                                @if($invoice->b24_payment_type_name === 'На расчетный счет компании')
                                        <img class="w-[36px] h-auto" src="{{ asset('images/icons/bank.png' )}}" alt="{{ $invoice->b24_payment_type_name }}" title="{{ $invoice->b24_payment_type_name }}">
                                @endif
                            </div>
                            <div class="pl-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                                {{ number_format($invoice->opportunity, 0, ',', ' ') }} руб
                            </div>
                        </div>
                    @endforeach

                    <div class="flex flex-row justify-between items-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 font-semibold">
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12"></div>
                        <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                            ИТОГО:
                        </div>
                        <div class="pl-6 py-4 dark:text-white text-sm font-medium text-slate-700 w-4/12">
                            {{ number_format($totalSum, 0, ',', ' ') }} руб
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
