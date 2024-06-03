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
                        <a href="/custom-fields/${data.id}/edit" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                    </td>
                `
            }
            function loadActionButtons (){}
        </script>
    @endPushOnce

    @include('components.custom.table')
</x-app-layout>
