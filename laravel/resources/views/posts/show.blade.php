{{-- resources/views/posts/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <p class="mb-4">Post: {{ $post->body }}</p>
                <p class="text-sm text-gray-600">Posted on: {{ $post->created_at->format('m/d/Y') }}</p>
                <p class="text-sm text-gray-600">Posted on: {{ $post->updated_at->format('m/d/Y') }}</p>
                <p class="text-sm text-gray-600">Author ID: {{ $post->author_id }}</p>
                
                @if($post->file)
                <div class="mt-4">
                    <h2 class="text-xl font-bold mb-2">File Details</h2>
                    <img src="{{ Storage::url($post->file->filepath) }}" alt="File Image" class="w-32 h-32 object-cover mb-2">
                    <!-- <p class="text-sm text-gray-600">File Size: {{ number_format($post->file->filesize / 1024, 2) }} KB</p> -->
                </div>
                @endif
                
                <div class="flex items-center justify-start mt-4">
                    <a href="{{ route('posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Back to all posts</a>
                    <a href="{{ route('posts.edit', $post) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


