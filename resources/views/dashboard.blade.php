<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @include('accountancy.list')

    {{-- <form action="{{ url('/dashboard/filtrar') }}" method="POST" id="searchForm">
                @csrf
                <input type="text" name="name" placeholder="Filtrar por nome" id="searchInput">
                <input type="date" name="data" placeholder="Filtrar por data">
                <button type="submit">Filtrar</button>
            </form> --}}

</x-app-layout>
