@extends('layouts.app')

@section('content')
<!-- ... -->
<form method="POST" action="{{ route('files.update', $file) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')
    <!-- ... campos del formulario ... -->
    <div class="mb-4">
        <input type="file" name="upload" required class="border-gray-300 p-2 rounded">
    </div>
    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Update Image</button>
    <a href="{{ route('files.show', $file) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
    <!-- ... -->
</form>
<!-- ... -->
@endsection
