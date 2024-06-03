<li class="flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-700 draggable" draggable="true"
    data-activity-id="{{ $activity->id }}">
    <div class="items-center block p-3 sm:flex">
        @if (!$activity->user->photo)
            <div
                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 w-12 h-12 mb-3 me-3 rounded-full sm:mb-0">
                <span
                    class="font-medium text-gray-600 dark:text-gray-300">{{ \App\Helpers\Text::extractInitial($activity->user->name) }}</span>
            </div>
        @else
            <img class="w-12 h-12 mb-3 me-3 rounded-full sm:mb-0"
                src="{{ route('profile.image', ['id' => $activity->user->id]) }}"
                alt="{{ $activity->user->name }} image" />
        @endif
        <div class="text-gray-600 dark:text-gray-400">
            <div class="text-base font-normal">{{ $activity->title }}</div>
            <div class="text-sm font-normal">{{ $activity->description }}</div>
            <span class="inline-flex items-center text-xs font-normal text-gray-500 dark:text-gray-400">
                <svg class="w-[18px] h-[18px] text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                        clip-rule="evenodd" />
                </svg>

                {{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>
    <div>
        <x-primary-button class="me-2 remove">
            <svg class="w-6 h-6 text-white-800 dark:text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
            </svg>
        </x-primary-button>
    </div>
</li>
