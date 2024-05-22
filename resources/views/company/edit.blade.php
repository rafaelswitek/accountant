<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($company) ? 'Edição' : 'Novo' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <section class="bg-white dark:bg-gray-900">
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
                        <label for="photo"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto</label>
                        <img src="{{ route('company.image', ['id' => @$company->id]) }}" alt="Imagem" width="215"
                            height="215">
                        <input type="file" name="image">
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
                                    text="{{ $cField->values->info->value ?? null }}" disabled="false" readonly="false"
                                    required="{{ $cField->info->required ? 'true' : 'false' }}"
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
        </section>
    </div>

</x-app-layout>
