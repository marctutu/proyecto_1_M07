{{-- resources/views/places/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('places.update', $place) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <textarea name="name" id="name" rows="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $place->name }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $place->description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="file_id" class="block text-gray-700 text-sm font-bold mb-2">File (optional):</label>
                        <input type="file" name="file_id" id="file_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @if($place->file)
                        <span class="text-sm text-gray-600">Current file: {{ $place->file->filepath }}</span>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
                        <input type="number" step="0.01" name="latitude" id="latitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $place->latitude }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
                        <input type="number" step="0.01" name="longitude" id="longitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $place->longitude }}" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                        <a href="{{ route('places.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection