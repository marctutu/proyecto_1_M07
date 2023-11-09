@extends('layouts.app')

@section('content')
<div class="flex flex-wrap gap-4 justify-start">
    <form method="POST" action="{{ route('files.update', $file) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <input type="file" name="upload" required class="border-gray-300 p-2 rounded">
        </div>
        <button type="submit" style="background-color: blue;" class="text-white font-bold py-2 px-4 rounded">Update Image</button>
        <a href="{{ route('files.show', $file) }}" style="background-color: black;" class="text-white font-bold py-2 px-4 rounded">Back</a>
    </form>
</div>
@endsection
