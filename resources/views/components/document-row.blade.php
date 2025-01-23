@props([
    'title' => '',
    'checked' => false,
])

<div class="flex flex-row justify-between odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
    <div class="px-6 py-4 dark:text-white text-sm font-medium text-slate-700">
        {{ $title }}
    </div>
    <div class="flex items-center justify-center w-4 p-4">
        <input id="{{ $attributes['id'] ?? 'checkbox-table-' . uniqid() }}"
               type="checkbox"
               disabled
               @if ($checked)
                   checked
               @endif
               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="{{ $attributes['id'] ?? 'checkbox-table-' . uniqid() }}" class="sr-only">checkbox</label>
    </div>
</div>
