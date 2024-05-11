<div id="stage-container-{{ $id }}" class="mt-6">
    <x-input-label for="name" value="{{ __('Name') }}" />
    <div class="flex">
        <div class="relative w-full">
            <input type="text" name="stages[]"
                class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg rounded-s-gray-100 rounded-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                value="{{ $name }}" required />
            <button type="button" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-stage-deletion-{{ $id }}')"
                class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-red-700 rounded-e-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 22 22">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
            </button>
        </div>
    </div>
</div>

<x-modal name="confirm-stage-deletion-{{ $id }}" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete the stage?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once the transaction is deleted, all your records and deals will be permanently deleted.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" type="button" x-on:click="$dispatch('close')"
                onclick="deleteStage({{ $id }})">
                {{ __('Delete') }}
            </x-danger-button>
        </div>
    </div>
</x-modal>
