<ol
    class="mt-4 flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse overflow-x-auto">
    @foreach ($stages as $stage)
        @php
            $color = $stage->id <= $deal->stage_id ? 'blue' : 'gray';
        @endphp
        <li class="flex items-center text-{{ $color }}-600 dark:text-{{ $color }}-500">
            <span
                class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-{{ $color }}-500 rounded-full shrink-0 dark:border-{{ $color }}-400">
                {{ $stage->order }}
            </span>
            {{ $stage->name }}
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m7 9 4-4-4-4M1 9l4-4-4-4" />
            </svg>
        </li>
    @endforeach
</ol>
