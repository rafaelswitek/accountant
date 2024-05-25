<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div x-data="{
        stats: {{ json_encode($stats) }}
    }">
        <section class="py-14">
            <div class="max-w-screen-xl mx-auto px-4 text-gray-600 md:px-8">
                <div class="mt-12">
                    <ul class="flex flex-col items-center justify-center gap-y-10 sm:flex-row sm:flex-wrap lg:divide-x">
                        <template x-for="(item, index) in stats" :key="index">
                            <li class="text-center px-12 md:px-16">
                                <h4 class="text-4xl text-indigo-600 font-semibold" x-text="item.data"></h4>
                                <p class="mt-3 font-medium" x-text="item.title"></p>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
