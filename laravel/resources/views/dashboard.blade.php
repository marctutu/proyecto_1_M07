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
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif    
                    {{ __("You're logged in!") }}
                    <h2 class="mb-4">{{ __('Resources') }}</h2>
                    <a href="{{ url('/files') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4">
                        {{ __('Files') }}
                    </a>
                    <a href="{{ url('/posts') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4">
                        {{ __('Posts') }}
                    </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
