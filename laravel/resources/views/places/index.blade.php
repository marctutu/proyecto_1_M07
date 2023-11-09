{{-- resources/views/places/index.blade.php --}}

@extends('layouts.app') {{-- Asegúrate de extender el layout que estás usando --}}

@section('content')

<!-- Aquí comienza el estilo de la tabla -->
<table class="min-w-full divide-y divide-gray-200 mt-4">
    <a href="{{ url('/places/create') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4">
        Create
    </a>
    <form action="{{ route('places.index') }}" method="GET" class="mb-4">
        <div class="flex mt-4">
            <input type="text" name="search" class="form-control" placeholder="Buscar" value="{{ request()->query('search') }}" autofocus>
            <button style="background-color:green" type="submit" class="ml-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md hover:bg-gray-700">
                Buscar
            </button>
        </div>
    </form>
    <thead class="bg-gray-50">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Author</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse ($places as $place)
            <tr>
                <td>{{ $place->id }}</td>
                <td>{{ $place->name }}</td>
                <td>{{ $place->description }}</td>
                <td>{{ $place->latitude }}</td>
                <td>{{ $place->longitude }}</td>
                <td>{{ $place->author->name }}</td>
                <td>{{ $place->created_at->toFormattedDateString() }}</td>
                <td>{{ $place->updated_at->toFormattedDateString() }}</td>
                <td>
                    <a href="{{ route('places.show', $place->id) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('places.edit', $place->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('places.destroy', $place->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No places found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<div style="background-color: white;">{{ $places->appends(['search' => request()->query('search')])->links() }}</div>

@endsection


