<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
            <div>{{ $availableLocales[$currentLocale] }} ({{ $currentLocale }})</div>
        </button>
    </x-slot>
    <x-slot name="content">
    @foreach($availableLocales as $locale => $localeName)
        @if($locale !== $currentLocale)
            <x-dropdown-link :href="route('language', $locale)">
                {{ $localeName }} ({{ $locale }})
            </x-dropdown-link>
        @endif
    @endforeach
    </x-slot>
</x-dropdown>