<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <form method="post" action="{{ route('upload.offer.agreement') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf

        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Договор оферты</label>
        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
               id="file_input"
               name="file"
               value="offer-agreement.pdf"
               type="file"
               accept="application/pdf">
        <div class="flex justify-end">
            <x-primary-button-green class="mr-3">
                {{ __('Сохранить') }}
            </x-primary-button-green>
        </div>
    </form>
</div>
