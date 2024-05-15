<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    @php
        $route = route('company.create');
    @endphp

    @section('tr')
        <tr>
            <th scope="col" class="px-6 py-3">
                Contabilidade
            </th>
            <th scope="col" class="px-6 py-3">
                Telefone
            </th>
            <th scope="col" class="px-6 py-3">
                Email
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
            const resource = 'company';

            function parseData(data) {
                return `
                    <th scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                            <span class="font-medium text-gray-600 dark:text-gray-300">${extractInitial(data.trade ?? data.name)}</span>
                        </div>
                        <div class="ps-3">
                            ${data.name ? `<div class="text-base font-semibold">${data.name}</div>` : ''}
                            <div class="font-medium text-gray-500">${data.document ? maskCNPJ(data.document) : ''}</div>
                            <div class="font-normal text-gray-500">${data.trade }</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        ${data.phone ?? '-'}
                    </td>
                    <td class="px-6 py-4">
                        ${data.email ?? '-'}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full bg-${data.status ? 'green' : 'red'}-500 me-2"></div> ${data.status ? 'Ativa' : 'Desativada'}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="/company/${data.id}/edit" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                    </td>
                `
            }
        </script>
    @endPushOnce

    @include('components.custom.table')
</x-app-layout>
