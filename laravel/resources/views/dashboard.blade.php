<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @if (session('info'))
                            <div class="mb-4 text-sm">
                                {{ session('info') }}
                            </div>
                        @endif    
                        <p style="color: green;" class="mb-4">{{ __("You're logged in!") }}</p>
                        <!-- <p>Role: {{ auth()->user()->role }}</p>  -->
                        <div class="flex flex-wrap gap-4 justify-start">
                            @can('create', App\Models\File::class)
                                <a href="{{ url('/files') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                    {{ __('Files') }}
                                </a>
                            @endcan
                            <a href="{{ url('/posts') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Posts') }}
                            </a>
                            <a href="{{ url('/places') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Places') }}
                            </a>
                            <a href="{{ url('/home') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Home') }}
                            </a>
                            <a href="{{ url('/about-us') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('About Us') }}
                            </a>
                            <a href="{{ url('/postsm09') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Posts M09') }}
                            </a>
                            <a href="{{ url('/placesm09') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Places M09') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
