{{-- resources/views/posts/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <a href="{{ route('posts.create') }}" style="background-color: green;" class="text-white font-bold py-2 px-4 rounded mb-4">Crear Nuevo Post</a>
                <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
                    <div class="flex mt-4">
                    <input type="text" name="search" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" postholder="Buscar Post" value="{{ request()->query('search') }}" autofocus>
                        <button type="submit" style="background-color: blue;" class="ml-2 text-white font-bold py-2 px-4 rounded-md">
                            Buscar
                        </button>
                    </div>
                </form>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Body</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $post->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ strlen($post->body) > 20 ? substr($post->body, 0, 20) . '...' : $post->body }}
                                        @if(strlen($post->body) > 20)
                                            <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver más</a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($post->file)
                                            <div class="mt-4">
                                                <img src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" class="w-32 h-32 object-cover mb-2">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $post->author->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $post->created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $post->longitude }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $post->latitude }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay posts disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $posts->appends(['search' => request()->query('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


