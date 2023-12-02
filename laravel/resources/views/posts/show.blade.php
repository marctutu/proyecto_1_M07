<!-- resources/views/posts/show.blade.php -->
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
                
                <p class="text-gray-800 text-xl font-semibold mb-4">
                    <!-- Muestra el número total de likes con estilo usando Tailwind CSS -->
                    {{ $post->liked->count() }} Likes
                </p>

                <!-- Muestra el botón de "like" o "unlike" -->
                @if (!$post->liked->contains(auth()->user()))
                    @can('like', $post)
                        <form action="{{ route('posts.like', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" style="background:green;" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Like</button>
                        </form>
                    @endcan
                @else
                    @can('unlike', $post)
                        <form action="{{ route('posts.unlike', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Unlike</button>
                        </form>
                    @endcan
                @endif

                <div class="flex flex-wrap gap-4 justify-start mt-4">
                    <a href="{{ route('posts.index') }}" style="background:black;" class="bg-black text-white font-bold py-2 px-4 rounded">Back</a>
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}" style="background:blue;" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                    @endcan
                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

