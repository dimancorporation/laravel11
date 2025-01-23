@foreach ($tabs as $tab)
    <li class="me-2" role="presentation">
        <button
            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
            id="{{ $tab['id'] }}-tab"
            data-tabs-target="#{{ $tab['id'] }}"
            type="button"
            role="tab"
            aria-controls="{{ $tab['id'] }}"
            aria-selected="false"
        >
            {{ $tab['title'] }}
        </button>
    </li>
@endforeach
