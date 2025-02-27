<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Моё дело
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex min-[950px]:flex-row min-[320px]:flex-col min-[320px]:items-center">
                    <div>
                        @php
                            $filePath = 'images/logo/logo.png';
                        @endphp

                        @if (file_exists(storage_path('app/public/' . $filePath)))
                            <img src="{{ Storage::url($filePath) }}" alt="Логотип" style="max-width: 320px;">
                        @else
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        @endif
                    </div>
                    <div class="p-6 text-gray-900 flex justify-center min-[950px]:flex-row min-[320px]:flex-col gap-20 w-full text-center">
                        {{ Auth::user()->message_from_b24 }}
                    </div>
                </div>
                <div class="p-6 text-gray-900 flex justify-between min-[950px]:flex-row min-[320px]:flex-col gap-20">
                    <div class="min-[320px]:w-full min-[950px]:w-2/4 block rounded-lg bg-white text-center text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white">
                        <div class="border-b-2 border-neutral-100 px-6 py-3 dark:border-white/10 text-3xl">
                            Моё дело
                        </div>
                        <div class="flex flex-col items-center w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 text-lg mt-3 font-semibold">
                            <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                    Мое дело находится в стадии:
                                </div>
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                    {{ $b24Status->name }}
                                </div>
                            </div>
                            <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                    Посмотреть в Арбитражном суде:
                                </div>
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg group cursor-pointer"
                                     onclick="window.open(this.querySelector('a').getAttribute('href'), '_blank');">
                                    <a href="{{ Auth::user()->link_to_court }}" class="hover:text-blue-800 hover:underline underline-offset-4 group-hover:text-blue-800 group-hover:underline" target="_blank">
                                        Арбитражный суд
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="min-[320px]:w-full min-[950px]:w-2/4 block rounded-lg bg-white text-center text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white">
                        <div class="border-b-2 border-neutral-100 px-6 py-3 dark:border-white/10 text-3xl">
                            Мои оплаты
                        </div>
                        <div class="flex flex-col items-center w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 text-lg mt-3 font-semibold">
                            <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                    Договор на сумму:
                                </div>
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                    {{ number_format(Auth::user()->sum_contract, 0, ',', ' ') }} руб
                                </div>
                            </div>
                            <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                    Оплачено на текущий момент:
                                </div>
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-green-500 rounded-lg">
                                    {{ number_format($alreadyPaid, 0, ',', ' ') }} руб
                                </div>
                            </div>
                            <div class="flex min-[280px]:flex-col min-[430px]:flex-row min-[280px]:items-end min-[430px]:items-center mb-3 w-full">
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 mr-3 text-right">
                                    Остаток по договору:
                                </div>
                                <div class="min-[280px]:w-full min-[430px]:w-2/4 p-2 flex justify-center items-center border-2 border-solid border-red-500 rounded-lg">

                                    @if(Auth::user()->sum_contract !== 0 && Auth::user()->sum_contract === Auth::user()->already_paid)
                                        Оплачено полностью!
                                    @else
                                        <a href="{{ route('payment') }}" class="hover:text-blue-800 hover:underline underline-offset-4">
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

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-center px-6 py-3 dark:border-white/10 text-3xl">
                    Процесс выполнения
                </div>
                <div class="min-[300px]:mx-6">
                    <div class="max-w-3xl mx-auto my-4 h-12 bg-gray-200 rounded-full dark:bg-gray-700 relative">
                        <div class="flex justify-center items-center h-12 font-medium  text-center p-0.5 leading-none rounded-full text-lg
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

    <div class="py-4 pb-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
</x-app-layout>
