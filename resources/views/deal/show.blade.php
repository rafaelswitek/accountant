<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $deal->name }}
                <span x-data="{ show: {{ $deal->status == 'opened' }} }" x-show="show"
                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Em
                    Aberto</span>
                <span x-data="{ show: {{ $deal->status == 'won' }} }" x-show="show"
                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Ganho</span>
                <span x-data="{ show: {{ $deal->status == 'lost' }} }" x-show="show"
                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Perdido</span>
            </h2>
            <div>
                @include('deal.partials.delete')
                @include('deal.partials.won-lost', ['type' => 'won'])
                @include('deal.partials.won-lost', ['type' => 'lost'])
            </div>
        </div>
    </x-slot>

    @if (session('status') === 'deal-updated')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ session('message') }}
        </div>
    @endif

    @include('deal.partials.stepper')

    <div class="grid grid-cols-2">
        <div class="col">
            @include('deal.partials.contact')
        </div>
        <div class="col">
            @include('deal.partials.timeline')
        </div>
    </div>
</x-app-layout>
