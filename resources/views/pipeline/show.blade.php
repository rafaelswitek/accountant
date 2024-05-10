<x-app-layout>
    <x-slot name="header">
        <x-modal name="new-deal" focusable>
            <form method="post" action="{{ route('deal.create') }}" class="p-6">
                @csrf

                <div class="mt-6">
                    <x-input-label for="dealName" value="{{ __('Name') }}" />

                    <input type="text" id="dealName" name="dealName" data-dropdown-toggle="dropdownSearch"
                        data-dropdown-placement="bottom"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="{{ __('Deal') }}" required>
                </div>

                <div class="mt-6">
                    <x-input-label for="dealCompanyId" value="{{ __('Company') }}" />
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="dealCompanyId" data-dropdown-toggle="dropdownSearch"
                            data-dropdown-placement="bottom"
                            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar empresa" required>
                    </div>
                    <div id="dropdownSearch"
                        class="hidden h-50 z-20 bg-white rounded-lg shadow dark:bg-gray-700 w-full">
                        <ul id="companiesDiv"
                            class="h-20 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dealCompanyId">
                            @foreach ($companies as $company)
                                @include('components.custom.company-item', [
                                    'companyDocument' => $company->document,
                                    'companyName' => $company->name,
                                    'companyId' => $company->id,
                                ])
                            @endforeach
                        </ul>
                        <a href="#"
                            class="flex items-center p-3 text-sm font-medium text-blue-600 border-t border-gray-200 rounded-b-lg bg-gray-50 dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-blue-500 hover:underline">
                            <svg class="w-[25px] h-[25px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Cadastrar Empresa
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <x-input-label for="dealStageId" value="{{ __('Funnel') }}" />

                    <select id="dealStageId" name="dealStageId"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        @foreach ($stageFunnels as $funnelStages)
                            <option value="{{ $funnelStages->id }}">
                                {{ $funnelStages->funnel->name }} - {{ $funnelStages->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
        <div class="flex">
            <div class="flex me-2">
                <select id="funnels"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value='' selected>Selecione o funil</option>
                    @foreach ($funnels as $funnel)
                        <option value="{{ $funnel->id }}"
                            {{ $funnelSelected->id == $funnel->id ? 'selected' : '' }}>
                            {{ $funnel->name }}</option>
                    @endforeach
                </select>
                <button
                    class="border border-gray-300 inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-r-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    type="button">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                    </svg>
                </button>
            </div>

            <x-primary-button class="me-2" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'new-deal')">
                <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" />
                </svg>
                Negócio
            </x-primary-button>
            <x-primary-button class="me-2" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'new-funnel')">
                <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 17h6m-3 3v-6M4.857 4h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857H4.857A.857.857 0 0 1 4 9.143V4.857C4 4.384 4.384 4 4.857 4Zm10 0h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857h-4.286A.857.857 0 0 1 14 9.143V4.857c0-.473.384-.857.857-.857Zm-10 10h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857H4.857A.857.857 0 0 1 4 19.143v-4.286c0-.473.384-.857.857-.857Z" />
                </svg>
                Funil
            </x-primary-button>

            <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                </svg>
            </button>

            <div id="dropdownDots"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Em
                            aberto</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ganhos</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Perdidos</a>
                    </li>
                </ul>
                <div class="py-2">
                    <a href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Todos</a>
                </div>
            </div>
        </div>

    </x-slot>

    @include('pipeline.kanban')
</x-app-layout>

<script>
    const funnels = document.getElementById('funnels')
    funnels.addEventListener('change', function() {
        if (this.value) {
            location.href = `?id=${this.value}`
        }
    })

    const dealCompanyId = document.getElementById('dealCompanyId')
    const companiesDiv = document.getElementById('companiesDiv')
    let timerId;
    dealCompanyId.addEventListener('focus', function() {
        this.click()
    })
    dealCompanyId.addEventListener('keyup', function(e) {
        clearTimeout(timerId);

        timerId = setTimeout(function() {
            fetch(`/company/search?param=${e.target.value}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    companiesDiv.textContent = ''
                    data.forEach(element => {
                        const html = `@include('components.custom.company-item', [
                            'companyDocument' => '${element.document}',
                            'companyName' => '${element.name}',
                            'companyId' => '${element.id}',
                        ])`;
                        companiesDiv.innerHTML += html;
                    });

                    attachEventsToDealCompanyFields();
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }, 600);
    })

    document.addEventListener('DOMContentLoaded', function() {
        attachEventsToDealCompanyFields();
    });

    function attachEventsToDealCompanyFields() {
        const dealCompanyFields = document.querySelectorAll('.dealCompanyFields');

        dealCompanyFields.forEach(function(element) {
            element.addEventListener('click', function(e) {
                const companyId = e.target.getAttribute('id');
                dealCompanyId.value = e.target.id
                dealCompanyId.click()
            });
        });
    }
</script>
