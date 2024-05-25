<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($company) ? 'Edição' : 'Novo' }}
        </h2>
    </x-slot>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" x-show="show"
            x-data="{ show: {{ isset($company) }} }" data-tabs-toggle="#default-styled-tab-content"
            data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500"
            data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
            role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="fields-styled-tab"
                    data-tabs-target="#styled-fields" type="button" role="tab" aria-controls="fields"
                    aria-selected="false">Campos</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="history-styled-tab" data-tabs-target="#styled-history" type="button" role="tab"
                    aria-controls="history" aria-selected="false">Histórico</button>
            </li>
        </ul>
    </div>
    <div id="default-styled-tab-content">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-fields" role="tabpanel"
            aria-labelledby="fields-tab">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Dados da empresa</h2>
                @if (isset($company))
                    <form method="POST" action="{{ route('company.update', ['id' => $company->id]) }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                @endif
                @csrf
                <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                    <div class="w-full">
                        <label for="document"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CNPJ</label>
                        <x-input-clipboard label="document" text="{{ @$company->document }}" disabled="false"
                            readonly="false"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                    </div>
                    <div class="w-full">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Razão
                            Social</label>
                        <x-input-clipboard label="name" text="{{ @$company->name }}" disabled="false" readonly="false"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                    </div>
                    <div class="w-full">
                        <label for="trade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome
                            Fantasia*</label>
                        <x-input-clipboard label="trade" text="{{ @$company->trade }}" disabled="false"
                            readonly="false" required="true"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                    </div>
                    <div class="w-full">
                        <label for="phone"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                        <x-input-clipboard label="phone" text="{{ @$company->phone }}" disabled="false"
                            readonly="false"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                    </div>
                    <div class="w-full">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <x-input-clipboard label="email" text="{{ @$company->email }}" disabled="false"
                            readonly="false"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                    </div>
                    <div class="w-full">
                        <label for="status"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select id="status" name="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600"
                            required>
                            <option value="1" {{ @$company->status == true ? 'selected' : '' }}>Ativo
                            </option>
                            <option value="0" {{ @$company->status == false ? 'selected' : '' }}>Inativo
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="photo"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto</label>
                        <figure class="max-w-lg">
                            <img id="imagePreview" src="{{ route('company.image', ['id' => @$company->id]) }}"
                                alt="Imagem" width="215" height="215">
                            <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                <input type="file" name="image" id="fileInput">
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="py-8">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Campos personalizados</h2>
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        @foreach ($customFields as $cField)
                            <div class="w-full">
                                <label for="brand"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $cField->info->label }}{{ $cField->info->required ? '*' : '' }}</label>
                                <x-input-clipboard label="custom_{{ $cField->id }}"
                                    text="{{ $cField->values->info->value ?? null }}" disabled="false"
                                    readonly="false" required="{{ $cField->info->required ? 'true' : 'false' }}"
                                    placeholder="{{ $cField->info->placeholder }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />

                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'company-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
                </form>
            </div>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-history" role="tabpanel"
            aria-labelledby="history-tab">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <ol class="relative border-s border-gray-200 dark:border-gray-700">
                    @foreach ($changes as $change)
                        <li class="mb-10 ms-6">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                <img class="rounded-full shadow-lg w-8 h-6"
                                    src="{{ route('profile.image', ['id' => $change->user->id]) }}"
                                    alt="Bonnie image" />
                            </span>
                            <div
                                class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                                <div class="w-full text-sm font-normal text-gray-500 dark:text-gray-300">
                                    <time
                                        class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ \Carbon\Carbon::parse($change->created_at)->diffForHumans() }}</time>

                                    <div class="relative overflow-x-auto">
                                        <table
                                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead
                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">
                                                        Campo
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Antigo
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Novo
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($change->payload->changes as $field)
                                                    <tr
                                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <th scope="row"
                                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{ $field->field }}
                                                        </th>
                                                        <td class="px-6 py-4">
                                                            {{ $field->old }}
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            {{ $field->new }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

</x-app-layout>
