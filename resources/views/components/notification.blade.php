<div id="alert" class="hidden fixed bottom-0 right-0 mb-4 mr-4 p-4 text-white rounded shadow-lg">
    <span id="alertText"></span>
    <button id="closeAlert" class="ml-2">Fechar</button>
</div>

<script>
    let timeoutId;

    function showAlert(message, type = 'green') {
        document.getElementById('alertText').innerText = message;
        const alert = document.getElementById('alert');
        alert.classList.remove('hidden');
        alert.classList.add(`bg-${type}-500`);

        clearTimeout(timeoutId);
        timeoutId = setTimeout(hideAlert, 3000);
    }

    function hideAlert() {
        document.getElementById('alert').classList.add('hidden');
    }

    document.getElementById('closeAlert').addEventListener('click', hideAlert);
</script>
