{{-- resources/views/places/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <p class="mb-4">Name: {{ $place->name }}</p>
                <p class="text-sm text-gray-600">Description: {{ $place->description }}</p>
                <p class="text-sm text-gray-600">Updated on: {{ $place->updated_at->format('m/d/Y') }}</p>
                <p class="text-sm text-gray-600">Created on: {{ $place->created_at->format('m/d/Y') }}</p>
                <p class="text-sm text-gray-600">File id: {{ $place->file_id }}</p>
                <p class="text-sm text-gray-600">Latitude: {{ $place->latitude }}</p>
                <p class="text-sm text-gray-600">Longitude: {{ $place->longitude }}</p>
                <p class="text-sm text-gray-600">Author ID: {{ $place->author_id }}</p>
                
                @if($place->file)
                <div class="mt-4">
                    <h2 class="text-xl font-bold mb-2">File Details</h2>
                    <img src="{{ Storage::url($place->file->filepath) }}" alt="File Image" class="w-32 h-32 object-cover mb-2">
                    <!-- <p class="text-sm text-gray-600">File Size: {{ number_format($place->file->filesize / 1024, 2) }} KB</p> -->
                </div>
                @endif
                
                <div class="flex items-center justify-start mt-4">
                    <a href="{{ route('places.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2 mt-4">Back to all places</a>
                    <a href="{{ route('places.edit', $place) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2 mt-4">Edit</a>
                    <form action="{{ route('places.destroy', $place) }}" method="POST" class="inline">
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
