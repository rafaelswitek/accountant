<div class="flex flex-col h-screen overflow-auto text-gray-700">
    <div class="px-10 mt-6">
        <h1 class="text-2xl font-bold">Funil: {{ $funnelSelected->name }}</h1>
    </div>
    <div class="flex flex-grow px-10 mt-4 space-x-6 overflow-auto">
        @foreach ($stages as $stage)
            <div class="flex flex-col flex-shrink-0 w-72 droppable" data-stage-id="{{ $stage->id }}"
                data-stage-name="{{ $stage->name }}">
                <div class="flex items-center flex-shrink-0 h-10 px-2">
                    <span class="block text-sm font-semibold">{{ $stage->name }}</span>
                    <span
                        class="flex items-center justify-center w-5 h-5 ml-2 text-sm font-semibold text-indigo-500 bg-white rounded bg-opacity-30 count-span">{{ $stage->deals->count() }}</span>
                    <button
                        class="flex items-center justify-center w-6 h-6 ml-auto text-indigo-500 rounded hover:bg-indigo-500 hover:text-indigo-100 newDeal">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-col pb-2 overflow-auto drop-zone">
                    @foreach ($stage->deals as $deal)
                        <a href="/deal/{{ $deal->id }}"
                            class="draggable relative flex flex-col items-start p-4 mt-3 bg-white rounded-lg cursor-pointer bg-opacity-90 group hover:bg-opacity-100"
                            draggable="true" data-deal-id="{{ $deal->id }}" data-deal-name="{{ $deal->name }}">
                            <span
                                class="flex items-center h-6 px-3 text-xs font-semibold text-{{ App\Helpers\FromTo::colorStatusDeal($deal->status) }}-500 bg-{{ App\Helpers\FromTo::colorStatusDeal($deal->status) }}-100 rounded-full">{{ App\Helpers\FromTo::statusDeal($deal->status) }}</span>
                            <h4 class="mt-3 text-sm font-medium">{{ $deal->name }}</h4>
                            <div class="flex items-center w-full mt-3 text-xs font-medium text-gray-400">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-300 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="ml-1 leading-none">{{ $deal->created_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                                {{-- <div class="relative flex items-center ml-4">
                                    <svg class="relative w-4 h-4 text-gray-300 fill-current"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-1 leading-none">4</span>
                                </div>
                                <div class="flex items-center ml-4">
                                    <svg class="w-4 h-4 text-gray-300 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-1 leading-none">1</span>
                                </div> --}}
                                <img class="w-6 h-6 ml-auto rounded-full" src="{{ route('profile.image', ['id' => $deal->user_id]) }}" />
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="flex-shrink-0 w-6"></div>
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

        const sourceStageId = draggedItem.closest('.droppable').dataset.stageId;
        const sourceStage = document.querySelector(`.droppable[data-stage-id="${sourceStageId}"]`);
        const countSpan = sourceStage.querySelector('.count-span');
        const newCount = parseInt(countSpan.textContent) - 1;
        countSpan.textContent = newCount;
    }

    function dragEnd() {
        if (draggedItem !== null) {
            const sourceStageId = draggedItem.closest('.droppable').dataset.stageId;
            const sourceStage = document.querySelector(`.droppable[data-stage-id="${sourceStageId}"]`);
            const countSpan = sourceStage.querySelector('.count-span');
            const newCount = parseInt(countSpan.textContent) + 1;
            countSpan.textContent = newCount;
        }
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
            const dealId = draggedItem.dataset.dealId;
            const dealName = draggedItem.dataset.dealName;
            const stageId = this.dataset.stageId;
            const stageName = this.dataset.stageName;
            const destinationStage = this.querySelector('.drop-zone');
            destinationStage.appendChild(draggedItem);
            draggedItem = null;
            this.classList.remove("hovered");

            const countSpan = this.querySelector('.count-span');
            const newCount = parseInt(countSpan.textContent) + 1;
            countSpan.textContent = newCount;

            const data = {
                dealId,
                stageId,
            };

            const options = {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            };

            fetch('/pipeline/update-deal', options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na solicitação');
                    }
                    showAlert(`${dealName} inserido no ${stageName}`)
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
        }
    }

    var buttons = document.querySelectorAll('.newDeal');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var stageId = this.closest('.droppable').getAttribute('data-stage-id');

            var dealStageSelect = document.getElementById('dealStageId');
            dealStageSelect.value = stageId;
            var openModalButton = document.querySelector(
                '[x-on\\:click\\.prevent="$dispatch(\'open-modal\', \'new-deal\')"]');
            openModalButton.click();
        });
    });
</script>
