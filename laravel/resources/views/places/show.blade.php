{{-- resources/views/places/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-gray-800 text-xl font-semibold mb-4">Name: {{ $place->name }}</h1>
                <p class="text-gray-800 text-xl font-semibold mb-4">Description: {{ $place->description }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Updated on: {{ $place->updated_at->format('m/d/Y') }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Created on: {{ $place->created_at->format('m/d/Y') }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Photo: {{ $place->file_id }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Latitude: {{ $place->latitude }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Longitude: {{ $place->longitude }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Author: {{ $place->author->name }}</p>
                
                @if($place->file)
                <div class="mt-4">
                    <h2 class="text-gray-800 text-xl font-semibold mb-4">File Details</h2>
                    <img src='{{ asset("storage/{$place->file->filepath}") }}' class="w-32 h-32 object-cover mb-2">
                    <!-- <p class="text-sm text-gray-600">File Size: {{ number_format($place->file->filesize / 1024, 2) }} KB</p> -->
                </div>
                @endif
                
                <div class="flex flex-wrap gap-4 justify-start">
                    <a href="{{ route('places.index') }}" style="background-color: black;" class="text-white font-bold py-2 px-4 rounded mr-2 mt-4">Back</a>
                    <a href="{{ route('places.edit', $place) }}" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded mr-2 mt-4">Edit</a>
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
