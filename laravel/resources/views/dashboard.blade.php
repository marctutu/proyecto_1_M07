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
                        <div class="flex flex-wrap gap-4 justify-start">
                            <a href="{{ url('/files') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Files') }}
                            </a>
                            <a href="{{ url('/posts') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Posts') }}
                            </a>
                            <a href="{{ url('/places') }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                {{ __('Places') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>