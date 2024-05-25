<li>
    <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
        <input id="{{ $companyDocument }} - {{ $companyName ?? $companyTrade }}" name="dealCompanyId" type="radio"
            value="{{ $companyId }}"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500 dealCompanyFields">
        <label for="{{ $companyDocument }} - {{ $companyName ?? $companyTrade }}"
            class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ $companyDocument }}
            - {{ $companyName ?? $companyTrade }}</label>
    </div>
</li>
