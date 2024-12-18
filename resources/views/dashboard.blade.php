<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Моё дело
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex md:flex-row justify-between min-[320px]:flex-col gap-2">
                    <div class="block rounded-lg bg-white text-center text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white">
                        <div class="border-b-2 border-neutral-100 px-6 py-3 dark:border-white/10 text-3xl">
                            Моё дело
                        </div>
                        <div>
                            <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 text-lg">
                                <colgroup>
                                    <col width="280">
                                    <col width="230">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        Мое дело находится в стадии:
                                    </th>
                                    <td class="p-4">
                                        <div class="p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                            Запросы БКИ
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        Посмотреть в Арбитражном суде:
                                    </th>
                                    <td class="p-4">
                                        <div class="p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                            Арбитражный суд
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="block rounded-lg bg-white text-center text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white">
                        <div class="border-b-2 border-neutral-100 px-6 py-3 dark:border-white/10 text-3xl">
                            Мои оплаты
                        </div>
                        <div>
                            <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 text-lg">
                                <colgroup>
                                    <col width="280">
                                    <col width="230">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        Договор на сумму:
                                    </th>
                                    <td class="p-4">
                                        <div class="p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                            180 000 руб
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        Оплачено на текущий момент:
                                    </th>
                                    <td class="p-4">
                                        <div class="p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                            10 000 руб
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        Остаток по договору:
                                    </th>
                                    <td class="p-4">
                                        <div class="p-2 flex justify-center items-center border-2 border-solid border-blue-500 rounded-lg">
                                            170 000 руб
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                    <div class="max-w-3xl mx-auto my-4 h-12 bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="flex justify-center items-center h-12 bg-blue-600 font-medium text-blue-100 text-center p-0.5 leading-none rounded-full text-lg" style="width: 75%; animation: progressAnimationStrike75_1 6s;"> 75%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 pb-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="max-w-6xl mx-auto grid justify-items-center min-[300px]:grid-cols-2 min-[460px]:grid-cols-3 min-[500px]:grid-cols-3 min-[660px]:grid-cols-4 min-[850px]:grid-cols-4 min-[900px]:grid-cols-5 min-[1200px]:grid-cols-6">
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                    <div class="my-5 mx-3 w-[145px] h-auto">
                        <img class="w-[145px] h-auto" src="{{asset('images/img1.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes progressAnimationStrike75_1 {
            from {
                width: 0;
            }

            to {
                width: 75%;
            }
        }
    </style>
</x-app-layout>
