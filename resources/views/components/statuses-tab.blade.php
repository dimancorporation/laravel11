<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="statuses" role="tabpanel" aria-labelledby="statuses-tab">
    <form method="post" action="{{ route('save.b24statuses.fields') }}" class="mt-6 space-y-6">
        @csrf

        @foreach($b24Statuses as $field)
            <div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 pb-1">
                <label class="w-full flex items-center">
                    <span class="w-1/2 after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                        {{ $field->name }}
                    </span>
                    <input type="text" name="{{ $field->id }}"
                           value="{{ $field->b24_status_id }}"
                           class="w-1/2 mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1"
                           placeholder="UF_CRM_1234567890123"/>
                </label>
            </div>
        @endforeach
        <div class="flex justify-end">
            <x-primary-button-green class="mr-3">
                {{ __('Сохранить') }}
            </x-primary-button-green>
        </div>
    </form>
</div>
