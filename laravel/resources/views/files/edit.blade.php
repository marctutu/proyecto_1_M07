@extends('layouts.app')

@section('content')
<!-- ... -->
<form method="POST" action="{{ route('file.update', $file->post->id) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <!-- Campo para editar el body del post -->
    <div class="mb-4">
        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Body:</label>
        <textarea name="body" id="body" rows="3" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $file->post->body }}</textarea>
    </div>

    <!-- Campo para actualizar el archivo -->
    <div class="mb-4">
        <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">Update File:</label>
        <input type="file" name="upload" class="border-gray-300 p-2 rounded">
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">Update</button>
</form>
<!-- ... -->
@endsection

