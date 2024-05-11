<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($funnel) ? 'Edição' : 'Novo' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Dados do funil</h2>
                @if (isset($funnel))
                    <form method="POST" action="{{ route('pipeline.update', ['id' => $funnel->id]) }}">
                        @method('PUT')
                    @else
                        <form method="POST" action="{{ route('pipeline.store') }}">
                @endif
                @csrf
                <div class="mt-6">
                    <x-input-label for="name" value="{{ __('Name') }}" />

                    <input type="text" id="name" name="name"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="{{ __('Funnel') }}" value="{{ @$funnel->name }}" required>
                </div>

                <div class="py-8">
                    <div class="flex justify-between items-start">
                        <h2 class="mr-4 mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __('Stages') }}
                        </h2>
                        <button
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            type="button" id="newStage">{{ __('New') }}</button>
                    </div>
                    <div id="stages">
                        @if (isset($stages))
                            @foreach ($stages as $stage)
                                @include('components.custom.stage-field', [
                                    'id' => $stage->id,
                                    'name' => $stage->name,
                                ])
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'pipeline-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                </form>
            </div>
        </section>
    </div>

</x-app-layout>

<script>
    const newStageButton = document.getElementById('newStage');
    const stages = document.getElementById('stages');

    newStageButton.addEventListener('click', createNewStage);

    function createNewStage() {
        const id = new Date().getTime().toString();
        const stageDiv = document.createElement('div');
        stageDiv.className = 'mt-6';
        stageDiv.id = `stage-container-${id}`;
        stageDiv.innerHTML = generateStageHTML(id);
        stages.appendChild(stageDiv);
    }

    function generateStageHTML(id) {
        return `
        <x-input-label for="name" value="{{ __('Name') }}" />
        <div class="flex">
            <div class="relative w-full">
                <input type="text" name="stages[]"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg rounded-s-gray-100 rounded-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" required />
                <button type="button" class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-red-700 rounded-e-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 delete-stage-button" onclick="deleteStage('${id}')">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 22 22">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                    </svg>
                </button>
            </div>
        </div>
    `;
    }

    function deleteStage(id) {
        const div = document.getElementById(`stage-container-${id}`);
        div.remove();
    }
</script>
