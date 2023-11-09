{{-- resources/views/files/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-gray-800 text-xl font-semibold mb-4">ID: {{ $file->id }}</h1>
                <h1 class="text-gray-800 text-xl font-semibold mb-4">Filepath: {{ $file->filepath }}</h1>
                <h1 class="text-gray-800 text-xl font-semibold mb-4">Filesize: {{ $file->filesize }}</h1>
                <h1 class="text-gray-800 text-xl font-semibold mb-4">Created: {{ $file->created_at }}</h1>
                <img class="w-full h-full object-cover mb-2" src="{{ Storage::url($file->filepath) }}" alt="File Image" />

                <div class="flex flex-wrap gap-4 justify-start">
                    <a href="{{ url('/files') }}" style="background-color: black;" class="text-white font-bold py-2 px-4 rounded mr-2 mt-4">Back</a>
                    <a href="{{ route('files.edit', $file) }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded mr-2 mt-4">Edit</a>
                    <form action="{{ route('files.destroy', $file) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-4">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
