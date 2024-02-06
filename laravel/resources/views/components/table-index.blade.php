@props([
    'cols',
    'rows',
    'enableActions' => false,
    'parentRoute',
    'enableSearch' => false,
    'search' => "",
])

<!-- https://flowbite.com/docs/components/tables/ -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    @if ($enableSearch)
    <form action="{{ route($parentRoute . '.index') }}" method="GET">
        <div class="pb-4 bg-white dark:bg-gray-100">
            <label for="table-search" class="sr-only">{{ __('Search') }}</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <x-text-input name="search" :value=$search id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Press Enter to search') }}" />
            </div>
        </div>
    </form>
    @endif
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($cols as $col)
                <th scope="col" class="px-6 py-3">
                    {{ __("fields.$col") }}
                </th>
                @endforeach
                @if (isset($parentRoute))
                <th scope="col" class="px-6 py-3 min-w-[120px]">
                    {{ __('Actions') }}
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
            <tr class="odd:bg-white odd:dark:bg-gray-100 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                @foreach ($cols as $col)
                @php
                    $keys = explode('.', $col, 2);
                    $value = count($keys) > 1 ? $row[$keys[0]][$keys[1]] : $row[$keys[0]];
                @endphp
                <td scope="row" class="px-6 py-4">
                    {{ $value }}
                </td>
                @endforeach
                @if ($enableActions)
                <td scope="row" class="px-6 py-4 min-w-[120px]">
                    @can('view', $row)
                    <a title="{{ __('View') }}"   href="{{ route($parentRoute . '.show',   $row) }}">👁️</a>
                    @endcan
                    @can('update', $row)
                    <a title="{{ __('Edit') }}"   href="{{ route($parentRoute . '.edit',   $row) }}">📝</a>
                    @endcan
                    @can('delete', $row)
                    <a title="{{ __('Delete') }}" href="{{ route($parentRoute . '.delete', $row) }}">🗑️</a>                
                    @endcan
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>