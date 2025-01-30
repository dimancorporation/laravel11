<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Список документов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto min-[300px]:px-0 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="min-[300px]:px-0 sm:p-6 text-gray-900">
                    @foreach ($documentFields as $field => $title)
                        <x-document-row title="{{$title}}" :checked="$documents->$field" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
