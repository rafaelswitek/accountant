<div id="accordion-open" data-accordion="open" class="mt-4">
    <h2 id="accordion-open-heading-2">
        <button type="button"
            class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-white-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-white dark:hover:bg-white gap-3 bg-white dark:bg-white"
            data-accordion-target="#accordion-open-body-1" aria-expanded="false" aria-controls="accordion-open-body-1">
            <span class="flex items-center">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01" />
                </svg>
                Negócio
            </span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5 5 1 1 5" />
            </svg>
        </button>
    </h2>
    <div id="accordion-open-body-1" class="hidden bg-white dark:bg-white" aria-labelledby="accordion-open-heading-1">
        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-white">
            <form class="max-w-sm mx-auto" method="POST" action="{{ route('deal.update', ['id' => $deal->id]) }}">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label for="dealName"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Name') }}</label>
                    <input type="text" id="dealName" name="dealName"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required value="{{ $deal->name }}" />
                </div>
                <div class="mb-5">
                    <label for="stageId"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Funnel') }}</label>
                    <select id="stageId" name="stageId"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        @foreach ($funnels as $funnelStages)
                            <option value="{{ $funnelStages->id }}"
                                {{ $funnelStages->id == $deal->stage_id ? 'selected' : '' }}>
                                {{ $funnelStages->funnel->name }} - {{ $funnelStages->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
    <div class="border-t border-gray-300 my-4"></div>
    <h2 id="accordion-open-heading-2">
        <button type="button"
            class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-white dark:hover:bg-white gap-3 bg-white dark:bg-white"
            data-accordion-target="#accordion-open-body-2" aria-expanded="true" aria-controls="accordion-open-body-2">
            <span class="flex items-center">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 6H5m2 3H5m2 3H5m2 3H5m2 3H5m11-1a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2M7 3h11a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm8 7a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                </svg>
                Contato
            </span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5 5 1 1 5" />
            </svg>
        </button>
    </h2>
    <div id="accordion-open-body-2" class="hidden bg-white dark:bg-white" aria-labelledby="accordion-open-heading-2">
        <div
            class="flex justify-start flex-wrap p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-white">
            @foreach ($deal->company->toArray() as $key => $company)
                <x-input-clipboard label="{{ $key }}" text="{{ $company }}" />
            @endforeach

            @foreach ($customFields as $cField)
                <x-input-clipboard label="custom_{{ $cField->id }}"
                    text="{{ $cField->values->info->value ?? null }}" />
            @endforeach

            <a href="{{ route('company.edit', ['id' => $deal->company->id]) }} "
                class="mt-2 ml-2 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Editar</a>
        </div>
    </div>
</div>
