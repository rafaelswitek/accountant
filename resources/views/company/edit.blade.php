<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edição
        </h2>
    </x-slot>
    <div class="py-12">
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Dados da empresa</h2>
                <form method="post" action="{{ route('company.update', ['id' => $company->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                        <div class="w-full">
                            <label for="document"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CNPJ</label>
                            <input type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                value="{{ $company->document }}" disabled>
                        </div>
                        <div class="w-full">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Razão
                                Social</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Razão Social" value="{{ $company->name }}">
                        </div>
                        <div class="w-full">
                            <label for="trade"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome
                                Fantasia</label>
                            <input type="text" name="trade" id="trade"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Nome Fantasia" value="{{ $company->trade }}">
                        </div>
                        <div class="w-full">
                            <label for="phone"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                            <input type="text" name="phone" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Telefone" value="{{ $company->phone }}">
                        </div>
                        <div class="w-full">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="text" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Email" value="{{ $company->email }}">
                        </div>
                    </div>
                    <div class="py-8">
                        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Campos personalizados</h2>
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            @foreach ($customFields as $cField)
                                <div class="w-full">
                                    <label for="brand"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $cField->info->label }}{{ $cField->info->required ? '*' : '' }}</label>
                                    <input type="text" name="custom_{{ $cField->id }}"
                                        id="custom_{{ $cField->id }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="{{ $cField->info->placeholder }}"
                                        value="{{ $cField->values->info->value ?? null }}"
                                        {{ $cField->info->required ? 'required' : '' }}>
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
