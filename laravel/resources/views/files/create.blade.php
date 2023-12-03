<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload File') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Mensaje de error -->
                        @if (session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="upload">File:</label>
                                <input type="file" class="form-control" name="upload"/>
                            </div>
                            <button type="submit" class="btn btn-primary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Create</button>
                            <button type="reset" class="btn btn-secondary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Reset</button>
                            <a href="{{ url('/files') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-4">
                                Back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
