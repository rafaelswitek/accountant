<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div
                class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 p-4 bg-white dark:bg-gray-900">
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Buscar">
                </div>
                <div>
                    <a href="{{ $route }}"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button">{{ __('Create') }}</a>
                </div>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    @yield('tr')
                </thead>
                <tbody id="searchResults"></tbody>
            </table>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4"
                aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Mostrando
                    <span class="font-semibold text-gray-900 dark:text-white"><span id="fromResults">0</span>-<span
                            id="toResults">0</span></span> de <span class="font-semibold text-gray-900 dark:text-white"
                        id="totalResults">0</span></span>
                <div id="pagination"></div>
            </nav>
        </div>
    </div>
</div>

@stack('scripts')

<script>
    init()

    function init() {
        getData()
    }

    function getData(page = 1) {
        const apiUrl = `${window.location.origin}/${resource}/list`;
        const textDropdown = document.getElementById('textDropdown')
        const queryParams = {
            param: document.getElementById('searchInput').value,
            page: page
        };

        const url = new URL(apiUrl);
        Object.entries(queryParams).forEach(([key, value]) => value ? url.searchParams.append(key, value) : null);

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na requisição.');
                }
                return response.json();
            })
            .then(results => {
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = '';
                results.data.forEach(result => {
                    const tempContainer = document.createElement('tr');
                    tempContainer.className =
                        "bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    tempContainer.innerHTML = parseData(result);

                    searchResults.appendChild(tempContainer);

                    document.getElementById('fromResults').innerHTML = results.from
                    document.getElementById('toResults').innerHTML = results.to
                    document.getElementById('totalResults').innerHTML = results.total
                });
                pagination(results.links)
                loadActionButtons() 
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }

    function createLink(link) {
        let classe =
            "flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white";

        if (link.label == '&laquo; Anterior') {
            classe =
                "flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
        }

        if (link.label == 'Próximo &raquo;') {
            classe =
                "flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
        }

        if (link.active) {
            classe =
                "flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
        }

        const page = getPageFromUrl(link.url)

        return `
        <li>
            <button data-page="${page}" class="pageLink ${classe}" ${link.url == null || link.active == true ? 'disabled' : ''}>${link.label}</button>
        </li>
        `
    }

    function getPageFromUrl(url) {
        if (url) {
            var url = new URL(url);
            var params = new URLSearchParams(url.search);
            return params.get("page");
        }

        return null
    }

    function pagination(links) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';
        const ul = document.createElement('ul');
        ul.className = "inline-flex -space-x-px rtl:space-x-reverse text-sm h-8"

        links.forEach(link => {
            ul.innerHTML = ul.innerHTML + createLink(link);
        })

        pagination.appendChild(ul)
    }

    let timerId;

    function aguardarDigitacao() {
        clearTimeout(timerId);
        timerId = setTimeout(getData, 500);
    }

    document.getElementById('searchInput').addEventListener('input', aguardarDigitacao);

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('pageLink')) {
            const page = event.target.getAttribute('data-page');
            getData(page);
        }
    });
</script>
