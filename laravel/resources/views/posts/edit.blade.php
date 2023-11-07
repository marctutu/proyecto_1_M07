{{-- resources/views/posts/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Body:</label>
                        <textarea name="body" id="body" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $post->body }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="file_id" class="block text-gray-700 text-sm font-bold mb-2">File (optional):</label>
                        <input type="file" name="file_id" id="file_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @if($post->file)
                        <span class="text-sm text-gray-600">Current file: {{ $post->file->filepath }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                        <a href="{{ route('posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
