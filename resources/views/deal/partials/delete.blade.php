<x-modal name="confirm-deal-deletion" focusable>
    <form method="post" action="{{ route('deal.destroy', ['id' => $deal->id]) }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete the deal?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once the deal is deleted, all of its logs and data will be permanently deleted.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
<x-primary-button class="px-5 py-2.5 me-2" x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-deal-deletion')">
    <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd"
            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
            clip-rule="evenodd" />
    </svg>
    Excluir
</x-primary-button>
