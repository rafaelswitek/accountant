<x-modal name="activity" focusable>
    <form method="post" action="{{ route('deal.activity.store', ['id' => $deal->id]) }}" class="p-6"
        onsubmit="disableButton('btnCreateActivity')">
        @csrf

        <div class="mt-6">
            <x-input-label for="activityTitle" value="{{ __('Titulo') }}" />

            <input type="text" id="activityTitle" name="activityTitle"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>

        <div class="mt-6">
            <label for="activityDescription"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Descrição') }}</label>
            <textarea id="activityDescription" name="activityDescription" rows="4" required
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
        </div>

        <div class="mt-6 flex space-x-4">
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input id="activityDate" name="activityDate" datepicker datepicker-autohide datepicker-buttons
                    datepicker-autoselect-today datepicker-format="dd/mm/yyyy" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
            </div>
            <div class="relative w-full">
                <input type="time" id="activityTime" name="activityTime"
                    class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="00:00" required />
            </div>
        </div>

        <div class="mt-6">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="activityFinished" name="activityFinished" class="sr-only peer">
                <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Finalizado</span>
            </label>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3" id="btnCreateActivity">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
<div class="mt-4 ml-8 mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
        data-tabs-toggle="#default-tab-content" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                type="button" role="tab" aria-controls="profile" aria-selected="false">Atividades</button>
        </li>
        <li class="me-2" role="presentation">
            <button
                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard"
                aria-selected="true">Notas</button>
        </li>
    </ul>
</div>
<div id="default-tab-content">
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
        aria-labelledby="profile-tab">
        <x-primary-button class="ml-8" x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'activity')">
            <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z" />
            </svg>
            Criar
        </x-primary-button>
        <div
            class="p-5 mb-4 border border-gray-100 rounded-lg bg-white dark:bg-gray-800 dark:border-gray-700 mt-4 ml-8 droppable">
            <time class="text-lg font-semibold text-gray-900 dark:text-white flex">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                </svg>

                Agendados
            </time>
            <ol class="mt-3 divide-y divider-gray-200 dark:divide-gray-700 overflow-y-scroll h-64 drop-zone">
                @foreach ($scheduled as $activity)
                    @include('components.custom.activity-item', ['activity' => $activity])
                @endforeach
            </ol>
        </div>
        <div
            class="p-5 mb-4 border border-gray-100 rounded-lg bg-white dark:bg-gray-800 dark:border-gray-700 mt-8 ml-8 droppable">
            <time class="text-lg font-semibold text-gray-900 dark:text-white flex">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                </svg>

                Concluidos
            </time>
            <ol class="mt-3 divide-y divider-gray-200 dark:divide-gray-700 overflow-y-scroll h-64 drop-zone">
                @foreach ($completed as $activity)
                    @include('components.custom.activity-item', ['activity' => $activity])
                @endforeach
            </ol>
        </div>

    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
        aria-labelledby="dashboard-tab">

        <form>
            <div
                class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" rows="4"
                        class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                        placeholder="Write a comment..." required></textarea>
                </div>
                <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                    <button type="submit"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                        Enviar
                    </button>
                </div>
            </div>
        </form>

        <div class="w-full mb-4 ">
            <div
                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Need a help in
                        Claim?</h5>
                </a>
                <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Go to this step by step guideline process
                    on how to certify for your weekly benefits:</p>
                <a href="#" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                    See our guideline
                    <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    let draggedItem = null;
    const draggableElements = document.querySelectorAll(".draggable");
    const droppableElements = document.querySelectorAll(".droppable");

    draggableElements.forEach(elem => {
        elem.addEventListener("dragstart", dragStart);
        elem.addEventListener("dragend", dragEnd);
    });

    droppableElements.forEach(elem => {
        elem.addEventListener("dragover", dragOver);
        elem.addEventListener("dragenter", dragEnter);
        elem.addEventListener("dragleave", dragLeave);
        elem.addEventListener("drop", drop);
    });

    function dragStart() {
        draggedItem = this;
        this.classList.add("dragging");
    }

    function dragEnd() {
        draggedItem = null;
        this.classList.remove("dragging");
    }

    function dragOver(e) {
        e.preventDefault();
    }

    function dragEnter(e) {
        e.preventDefault();
        this.classList.add("hovered");
    }

    function dragLeave() {}

    function drop() {
        if (draggedItem !== null) {
            const activityId = draggedItem.dataset.activityId;
            const destinationStage = this.querySelector('.drop-zone');
            destinationStage.appendChild(draggedItem);
            draggedItem = null;
            this.classList.remove("hovered");

            const options = {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            };

            fetch(`/deal/activity/${activityId}`, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na solicitação');
                    }
                    showAlert(`Atividade atualizada`)
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
        }
    }

    var buttons = document.querySelectorAll('.remove');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            this.disabled = true
            var node = this.closest('li');
            var activityId = node.getAttribute('data-activity-id');

            const options = {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
            };

            fetch(`/deal/activity/${activityId}`, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na solicitação');
                    }
                    node.remove()
                    showAlert(`Atividade removida`)
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
        });
    });

    function disableButton(id) {
        document.getElementById(id).disabled = true;
    }
</script>
