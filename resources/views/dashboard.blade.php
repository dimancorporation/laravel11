@props(['active', 'activeTheme' => 'blue'])
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Моё дело
        </h2>
    </x-slot>

    <div>
        <div>
            <div class="max-w-full mx-auto">
                <div class="overflow-hidden">
                    <div class="my-6 mx-6 text-center text-lg font-bold user-full-name">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="p-6 text-gray-900 flex justify-center min-[950px]:flex-row min-[320px]:flex-col gap-20 w-full text-center font-bold message-from-b24">
                        {{ Auth::user()->message_from_b24 }}
                    </div>
                    <div class="flex min-[950px]:flex-row min-[320px]:flex-col min-[320px]:items-center">
                        <div class="my-6 mx-6">
                            @php
                                $filePath = 'images/logo/logo.png';
                            @endphp

                            @if (file_exists(storage_path('app/public/' . $filePath)))
                                <img src="{{ Storage::url($filePath) }}" alt="Логотип" style="max-width: 320px;">
                            @else
                                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                            @endif
                        </div>
                        <div class="p-6 text-gray-900 flex justify-center min-[950px]:flex-row min-[320px]:flex-col gap-20 w-full text-center message-from-b24">

                        </div>
                    </div>
                    <div class="p-6 text-gray-900 flex justify-between min-[950px]:flex-row min-[320px]:flex-col gap-20">
                        <div class="min-[320px]:w-full min-[950px]:w-2/4 block rounded-lg text-center text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white">
                            <div class="title-info border-neutral-100 px-6 py-3 dark:border-white/10 text-3xl">
                                Моё дело
                            </div>
                            <div class="flex flex-col items-center w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 text-lg mt-3 font-semibold">
                                <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                    <div class="case-stage-label min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                        Мое дело находится в стадии:
                                    </div>
                                    <div class="case-stage-value rounded-card min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                        {{ $b24Status->name }}
                                    </div>
                                </div>
                                <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                    <div class="court-link-label min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                        Посмотреть в Арбитражном суде:
                                    </div>
                                    <div class="court-link-value rounded-card min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg group cursor-pointer"
                                         onclick="window.open(this.querySelector('a').getAttribute('href'), '_blank');">
                                        <a href="{{ Auth::user()->link_to_court }}" target="_blank">
                                            Арбитражный суд
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="min-[320px]:w-full min-[950px]:w-2/4 block rounded-lg text-center text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white">
                            <div class="title-info border-neutral-100 px-6 py-3 dark:border-white/10 text-3xl">
                                Мои оплаты
                            </div>
                            <div class="flex flex-col items-center w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 text-lg mt-3 font-semibold">
                                <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                    <div class="contract-amount-label min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                        Договор на сумму:
                                    </div>
                                    <div class="contract-amount-value rounded-card min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                        {{ number_format(Auth::user()->sum_contract, 0, ',', ' ') }} руб
                                    </div>
                                </div>
                                <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                    <div class="paid-amount-label min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                        Оплачено на текущий момент:
                                    </div>
                                    <div class="paid-amount-value rounded-card min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-green-500 rounded-lg">
                                        {{ number_format($alreadyPaid, 0, ',', ' ') }} руб
                                    </div>
                                </div>
                                <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                    <div class="remaining-amount-label min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                        Остаток по договору:
                                    </div>
                                    <div class="remaining-amount-value rounded-card min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-red-500 rounded-lg">
                                        @if(Auth::user()->sum_contract !== 0 && Auth::user()->sum_contract === Auth::user()->already_paid)
                                            Оплачено полностью!
                                        @else
                                            <a href="{{ route('payment') }}">
                                                {{ number_format(Auth::user()->sum_contract - $alreadyPaid, 0, ',', ' ') }} руб
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="max-w-full mx-auto">
                <div class="overflow-hidden">
                    <div class="progress-bar-title text-center px-6 py-3 dark:border-white/10 text-3xl">
                        Процесс выполнения
                    </div>
                    <div>
                        @php
                            $class = 'bg-custom-blue-500';

                            if ($activeTheme === 'green') {
                                $class = 'bg-custom-green-500';
                            } elseif ($activeTheme === 'yellow') {
                                $class = 'bg-custom-yellow-500';
                            } elseif ($activeTheme === 'red') {
                                $class = 'bg-custom-red-500';
                            } elseif ($activeTheme === 'turquoise') {
                                $class = 'bg-custom-turquoise-500';
                            }
                        @endphp
                        <div class="progress-container my-4 mx-6 h-8 {{ $class }} relative">
                            <div class="progress-bar flex justify-center items-center h-12 font-medium text-center p-0.5 leading-none text-lg
                            @if($progressBarData['width'] !== '0%') bg-blue-600 text-blue-100 @else w-full text-black @endif"
                                 @if($progressBarData['width'] !== '0%')
                                     style="width: {{ $progressBarData['width'] }};
                                     animation: {{ $progressBarData['animation'] }};"
                                 @endif
                                 >
                                {{ $progressBarData['width'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="max-w-full mx-auto">
                <div class="overflow-hidden">
                    <div class="max-w-6xl mx-auto grid justify-items-center min-[300px]:grid-cols-2 min-[460px]:grid-cols-3 min-[500px]:grid-cols-3 min-[660px]:grid-cols-4 min-[850px]:grid-cols-4 min-[900px]:grid-cols-5 min-[1200px]:grid-cols-6">
                        @foreach ($progressImages as $image)
                            <div class="my-5 mx-3 w-[145px] h-auto">
                                <img class="w-[145px] h-auto" src="{{ asset($image) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
