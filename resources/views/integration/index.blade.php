<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Integrations') }}
        </h2>
    </x-slot>

    @php
        $isOpen = $whatsapp->state == 'open';
        $hasQrCode = !empty($whatsapp->qrCode);
    @endphp

    <div class="flex justify-center items-center h-[60vh] m-0 bg-gray-100">
        <button type="button" id="btnConnectWhatsapp"
            class="text-white bg-[#25D366] hover:bg-[#25D366]/90 focus:ring-4 focus:outline-none focus:ring-[#25D366]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#25D366]/55 me-2 mb-2 {{ !$isOpen && !$hasQrCode ? '' : 'hidden' }}">
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

        <figure class="max-w-lg me-2 mb-2 {{ $hasQrCode ? '' : 'hidden' }}" id="divQrCode">
            <img class="h-auto max-w-full rounded-lg" src="{{ $whatsapp->qrCode ?? '' }}" alt="image description"
                id="qrCode">
            <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Leia o QR Code para integrar
                ao WhatsApp</figcaption>
        </figure>

        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 {{ $isOpen ? '' : 'hidden' }}"
            id="divProfile">
            <div class="flex justify-end px-4 pt-4">
                <button id="dropdownButton" data-dropdown-toggle="dropdown"
                    class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                    type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 16 3">
                        <path
                            d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown"
                    class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2" aria-labelledby="dropdownButton">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export
                                Data</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col items-center pb-10">
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ $whatsapp->user->picture ?? '' }}"
                    alt="{{ $whatsapp->user->name ?? 'Imagem do perfil' }}" id="profilePicture" />
                <span class="flex flex-row items-end">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white mr-2" id="profileName">
                        {{ $whatsapp->user->name ?? '' }}
                    </h5>
                    <h6 class="mb-1 text-xd font-medium text-gray-900 dark:text-white" id="profileNumber">
                        ({{ $whatsapp->user->number ?? '' }})
                    </h6>
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400"
                    id="profileStatus">{{ $whatsapp->user->status ?? '' }}</span>
                <div class="flex mt-4 md:mt-6">
                    <a href="{{ route('integration.getMessages') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Mensagens</a>
                    <a href="{{ route('integration.getContacts') }}"
                        class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Contatos</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnConnectWhatsapp = document.getElementById('btnConnectWhatsapp')
            const divQrCode = document.getElementById('divQrCode')
            const divProfile = document.getElementById('divProfile')
            const qrCode = document.getElementById('qrCode')
            const profileName = document.getElementById('profileName')
            const profileNumber = document.getElementById('profileNumber')
            const profileStatus = document.getElementById('profileStatus')
            const profilePicture = document.getElementById('profilePicture')

            let timerId

            btnConnectWhatsapp.addEventListener('click', function() {
                showLoading()
                connectToIntegration()
            })

            async function connectToIntegration() {
                try {
                    const response = await httpClient("{{ route('integration.createInstance') }}", 'POST')
                    btnConnectWhatsapp.classList.add('hidden')
                    divQrCode.classList.remove('hidden')
                    qrCode.src = response.qrCode
                    hideLoading()
                    getState()
                } catch (error) {
                    hideLoading()
                    showAlert(error.message)
                }
            }

            async function getState() {
                try {
                    const response = await httpClient("{{ route('integration.getConnectionState') }}", 'GET')
                    if (response.state !== 'open') {
                        timerId = setTimeout(getState, 3000)
                    } else {
                        profileName.innerText = response.user.name
                        profileNumber.innerText = response.user.number
                        profileStatus.innerText = response.user.status
                        profilePicture.src = response.user.picture

                        divQrCode.classList.add('hidden')
                        divProfile.classList.remove('hidden')
                    }
                } catch (error) {
                    showAlert(error.message)
                }
            }
        })

        // const messages = document.getElementById('messages')

        // function createMessage(id, message, author, fromMe) {
        //     return `
    //         <div class="flex items-start gap-2.5 m-4 ${fromMe ? '':'flex-row-reverse'}">
    //             <img class="w-8 h-8 rounded-full"
    //                 src="https://pps.whatsapp.net/v/t61.24694-24/419689634_765170105466612_1451057841561953213_n.jpg?ccb=11-4&oh=01_Q5AaIA2DgcWt9dPyQWVSFxz-NSjBf27yJ8cVL127k7CKxZLT&oe=666FA992&_nc_sid=e6ed6c&_nc_cat=103"
    //                 alt="Jese image">
    //             <div
    //                 class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-${fromMe ? 'green':'blue'}-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
    //                 <div class="flex items-center space-x-2 rtl:space-x-reverse  ${fromMe ? '':'justify-end'}">
    //                     <span class="text-sm font-semibold text-gray-900 dark:text-white">${author}</span>
    //                     <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>
    //                 </div>
    //                 <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">${message}</p>
    //                 <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Delivered</span>
    //             </div>
    //             <button id="dropdownMenuIconButton-${id}" data-dropdown-toggle="dropdownDots-${id}"
    //                 data-dropdown-placement="bottom-end"
    //                 class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
    //                 type="button">
    //                 <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
    //                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
    //                     <path
    //                         d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
    //                 </svg>
    //             </button>
    //             <div id="dropdownDots-${id}"
    //                 class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
    //                 <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton-${id}">
    //                     <li>
    //                         <a href="#"
    //                             class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
    //                     </li>
    //                     <li>
    //                         <a href="#"
    //                             class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
    //                     </li>
    //                     <li>
    //                         <a href="#"
    //                             class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
    //                     </li>
    //                     <li>
    //                         <a href="#"
    //                             class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
    //                     </li>
    //                     <li>
    //                         <a href="#"
    //                             class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
    //                     </li>
    //                 </ul>
    //             </div>
    //         </div>
    //     `
        // }

        // // fetchMessages()

        // function fetchMessages() {
        //     const raw = JSON.stringify({
        //         "where": {
        //             "key": {
        //                 "remoteJid": "556292085795"
        //             }
        //         }
        //     })
        //     fetch('http://localhost:8080/chat/findMessages/Teste', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'apikey': 'mude-me'
        //             },
        //             body: raw,
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 return response.json().then(data => {
        //                     throw new Error(data.message || 'Erro na solicitação')
        //                 })
        //             }
        //             return response.json()
        //         })
        //         .then(response => {
        //             console.log(response)
        //             response.forEach(element => {
        //                 console.log(element)
        //                 const div = document.createElement('div')
        //                 div.innerHTML = createMessage(element.key.id, element.message.conversation, element
        //                     .pushName, element.key.fromMe)
        //                 messages.appendChild(div)

        //             })
        //         })
        //         .catch(error => {
        //             showAlert(error.message)
        //         })
        // }
    </script>

</x-app-layout>
