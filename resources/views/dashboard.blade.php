<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ url('/dashboard/filtrar') }}" method="POST" id="searchForm">
                @csrf
                <input type="text" name="name" placeholder="Filtrar por nome" id="searchInput">
                <input type="date" name="data" placeholder="Filtrar por data">
                <button type="submit">Filtrar</button>
            </form>

            <div id="searchResults">
                @foreach ($registros as $registro)
                    {{ $registro->name }} - {{ $registro->created_at }} <br>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário (recarregar a página)

            // Obtém o valor do input de busca
            const searchQuery = document.getElementById('searchInput').value;

            // Realiza a busca via Fetch
            fetch(`/dashboard/filtrar?name=${searchQuery}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na requisição.');
                    }
                    return response.json();
                })
                .then(data => {
                    // Manipula os dados recebidos
                    const searchResults = document.getElementById('searchResults');
                    searchResults.innerHTML = ''; // Limpa os resultados anteriores
                    data.data.forEach(result => {
                    console.log(result);
                        const resultElement = document.createElement('p');
                        resultElement.textContent = result.name; // Suponha que cada resultado tenha um título
                        searchResults.appendChild(resultElement);
                    });
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
        });
    </script>
</x-app-layout>
