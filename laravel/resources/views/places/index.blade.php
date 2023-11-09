{{-- resources/views/places/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <a href="{{ route('places.create') }}" style="background-color: green;" class="text-white font-bold py-2 px-4 rounded mb-4">Crear Nuevo Lugar</a>
                <form action="{{ route('places.index') }}" method="GET" class="mb-4">
                    <div class="flex mt-4">
                        <input type="text" name="search" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Buscar Lugar" value="{{ request()->query('search') }}" autofocus>
                        <button type="submit" style="background-color: blue;" class="ml-2 text-white font-bold py-2 px-4 rounded-md">
                            Buscar
                        </button>
                    </div>
                </form>
                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($places as $place)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->latitude }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->longitude }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->author->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->created_at->toFormattedDateString() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $place->updated_at->toFormattedDateString() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('places.show', $place->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                    <a href="{{ route('places.edit', $place->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <form action="{{ route('places.destroy', $place->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay lugares disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $places->appends(['search' => request()->query('search')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


