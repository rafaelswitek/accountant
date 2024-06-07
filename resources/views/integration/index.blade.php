<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Integrations') }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center h-[60vh] m-0 bg-gray-100">
        <button type="button" id="connectWhatsapp"
            class="text-white bg-[#25D366] hover:bg-[#25D366]/90 focus:ring-4 focus:outline-none focus:ring-[#25D366]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#25D366]/55 me-2 mb-2">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd"
                    d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z"
                    clip-rule="evenodd" />
                <path fill="currentColor"
                    d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z" />
            </svg>

            Conectar WhatsApp
        </button>

        <figure class="max-w-lg hidden" id="qrCodeDiv">
            <img class="h-auto max-w-full rounded-lg" src="" alt="image description" id="qrCode">
            <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Leia o QR Code para integrar
                ao WhatsApp</figcaption>
        </figure>
    </div>

    <script>
        const connectWhatsapp = document.getElementById('connectWhatsapp')
        const qrCodeDiv = document.getElementById('qrCodeDiv')
        const qrCode = document.getElementById('qrCode')
        connectWhatsapp.addEventListener('click', function() {
            showLoading()
            fetch('integration/instance', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message ||
                                'Erro na solicitação');
                        });
                    }
                    return response.json()
                })
                .then(response => {
                    console.log(response)
                    connectWhatsapp.classList.add('hidden')
                    qrCodeDiv.classList.remove('hidden')
                    qrCode.src = response.qrcode.base64
                    hideLoading()
                    getState()
                })
                .catch(error => {
                    hideLoading()
                    showAlert(error.message)
                });
        });

        let timerId;

        function getState() {
            fetch('integration/instance/state', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Erro na solicitação');
                        });
                    }
                    return response.json();
                })
                .then(response => {
                    console.log(response);
                    if (response.instance.state !== 'open') {
                        timerId = setTimeout(getState, 3000);
                    } else {
                        qrCodeDiv.classList.add('hidden')
                    }
                })
                .catch(error => {
                    showAlert(error.message);
                });
        }
    </script>

</x-app-layout>
