@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Display file info and image -->
    <h1>{{ $file->filepath }}</h1>
    <img class="img-fluid" src='{{ $url }}' />

    <!-- Edit button -->
    <a href="{{ route('files.edit', $file) }}" class="btn btn-primary">Edit</a>

    <!-- Delete button -->
    <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection
