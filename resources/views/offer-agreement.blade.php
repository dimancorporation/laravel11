<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Договор оферты
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    <iframe src="{{ asset('storage/docs/offer_agreement.pdf') }}" width="100%" height="700px"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
