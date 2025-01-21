<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 min-[500px]:p-6 text-gray-900">
                    {!! htmlspecialchars_decode($debtorMessage) !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
