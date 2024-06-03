<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Custom Fields') }}
        </h2>
    </x-slot>

    @php
        $route = route('fields.create');
    @endphp

    @section('tr')
        <tr>
            <th scope="col" class="px-6 py-3">
                Tipo
            </th>
            <th scope="col" class="px-6 py-3">
                Label
            </th>
            <th scope="col" class="px-6 py-3">
                Obrigatorio
            </th>
            <th scope="col" class="px-6 py-3">
                Placeholder
            </th>
            <th scope="col" class="px-6 py-3">
                Status
            </th>
            <th scope="col" class="px-6 py-3">
                Ação
            </th>
        </tr>
    @endsection

    @pushOnce('scripts')
        <script>
            const resource = 'custom-fields';

            function parseData(data) {
                return `
                    <td class="px-6 py-4">
                        ${data.info.type ?? '-'}
                    </td>
                    <td class="px-6 py-4">
                        ${data.info.label ?? '-'}
                    </td>
                    <td class="px-6 py-4">
                        ${data.info.required == 1 ? 'Sim' : 'Não'}
                    </td>
                    <td class="px-6 py-4">
                        ${data.info.placeholder ?? '-'}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            ${data.status ? 
                            '<div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Ativo' :
                            '<div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> Inativo' }
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="/custom-fields/${data.id}/edit" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </td>
                `
            }
            function loadActionButtons (){}
        </script>
    @endPushOnce

    @include('components.custom.table')
</x-app-layout>
