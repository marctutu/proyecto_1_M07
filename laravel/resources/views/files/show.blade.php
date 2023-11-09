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
    <h1 class="mb-4 text-white">{{ $file->filepath }}</h1>
    
    <div class="mb-4 flex">
        <a href="{{ route('files.edit', $file) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">Edit</a>
        <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="mr-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">Delete</button>
        </form>
        <a href="{{ url('/files') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
    </div>

    
    <img class="img-fluid" src='{{ $url }}' />
</div>
@endsection