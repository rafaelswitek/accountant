<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Custom Fields') }}
        </h2>
    </x-slot>

    @include('fields.partials.table')
</x-app-layout>
