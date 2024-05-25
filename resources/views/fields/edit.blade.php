<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($fields) ? 'Edição' : 'Novo' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Campos personalizados</h2>
                @if (isset($fields))
                    <form method="POST" action="{{ route('fields.update', ['id' => $fields->id]) }}">
                        @method('PUT')
                    @else
                        <form method="POST" action="{{ route('fields.store') }}">
                @endif
                @csrf
                <div class="grid gap-4 sm:grid-cols-3 sm:gap-6 py-8">
                    <div class="w-full">
                        <label for="type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                        <select id="type" name="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option value="textInput" selected>Texto</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="label"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Label</label>
                        <input type="text" name="label" id="label"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            value="{{ @$fields->info->label }}" required>
                    </div>
                    <div class="w-full">
                        <label for="placeholder"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Placeholder</label>
                        <input type="text" name="placeholder" id="placeholder"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Razão Social" value="{{ @$fields->info->placeholder }}" required>
                    </div>
                    <div class="w-full">
                        <label for="required"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Obrigatorio</label>
                        <select id="required" name="required"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option value="1" {{ @$fields->info->required == true ? 'selected' : '' }}>Sim</option>
                            <option value="0" {{ @$fields->info->required == false ? 'selected' : '' }}>Não
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="status"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select id="status" name="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option value="1" {{ @$fields->status == true ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ @$fields->status == false ? 'selected' : '' }}>Inativo
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'field-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
                </form>
            </div>
        </section>
    </div>

</x-app-layout>
