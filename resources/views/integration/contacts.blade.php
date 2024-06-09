<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Integrations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div 
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Contatos</h5>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($contacts AS $contact)
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{ $contact['profilePictureUrl'] ?? asset('img/wpp.png') }}"
                                    alt="{{ $contact['pushName'] ?? $contact['id'] }}">
                            </div>
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $contact['pushName'] ?? "Sem nome" }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ $contact['id'] }}
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</x-app-layout>
