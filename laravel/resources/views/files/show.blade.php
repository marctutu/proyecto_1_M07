@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success text-green-500 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-red-500 p-4 rounded">
            {{ session('error') }}
        </div>
    @endif

<div class="container">
    <div class="bg-white p-4 rounded shadow">
        <h1 class="mb-4 text-white">Post</h1>
        <img class="img-fluid mb-4" src="{{ Storage::url($file->filepath) }}" alt="Image" width="100" />
        @if($file->post)
            <p><strong>ID:</strong> {{ $file->post->id }}</p>
            <p><strong>Author ID:</strong> {{ $file->post->author_id }}</p>
            <p><strong>Post ID:</strong> {{ $file->post->id }}</p>
        @endif
        <p><strong>File ID:</strong> {{ $file->id }}</p>
        <p><strong>Filepath:</strong> {{ $file->filepath }}</p>
        <p><strong>Size:</strong> {{ $file->filesize }}</p>
        @if($file->post)
            <p><strong>Body:</strong> {{ $file->post->body }}</p>
        @endif
        <p><strong>Uploaded at:</strong> {{ $file->created_at->toDayDateTimeString() }}</p>
        <p><strong>Last updated:</strong> {{ $file->updated_at->toDayDateTimeString() }}</p>
        <!-- Action buttons -->
        <a href="{{ route('files.edit', $file) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">Edit</a>
        <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
        <a href="{{ url('/files') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">Back</a>
    </div>
</div>
@endsection
