{{-- resources/views/posts/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <p class="text-gray-800 text-xl font-semibold mb-4">Post: {{ $post->body }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Posted on: {{ $post->created_at->format('m/d/Y') }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Author: {{ $post->author->name }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Latitude: {{ $post->latitude }}</p>
                <p class="text-gray-800 text-xl font-semibold mb-4">Longitude: {{ $post->longitude }}</p>
                
                @if($post->file)
                <div class="mt-4">
                    <h2 class="text-gray-800 text-xl font-semibold mb-4">File Details</h2>
                    <img src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" class="w-32 h-32 object-cover mb-2">
                </div>
                @endif
                
                <div class="flex flex-wrap gap-4 justify-start">
                    <a href="{{ route('posts.index') }}" style="background: black;" class="text-white font-bold py-2 px-4 rounded mr-2 mt-4">Back</a>
                    <a href="{{ route('posts.edit', $post) }}" style="background: blue;" class="text-white font-bold py-2 px-4 rounded mr-2 mt-4">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
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


