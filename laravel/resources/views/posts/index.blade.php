@extends('layouts.app')

@section('content')
<body class="bg-purple-300 ">
    <!-- Fija la barra de navegación en la parte superior -->
    <nav class="fixed top-5 inset-x-0 bg-purple-300 text-black p-4 z-50">
        <div class="flex justify-between items-center">
            <!-- Enlaces de navegación -->
            <div class="flex space-x-8">
                <a href="#" class="text-white hover:text-purple-300">Home</a>
                <a href="#" class="text-white hover:text-purple-300">Explore</a>
                <a href="#" class="text-white hover:text-purple-300">Chat</a>
                <a href="#" class="text-white hover:text-purple-300">New Post</a>
            </div>

            <!-- Centrar el logotipo en la barra de navegación -->
            <div>
                <a href="#" class="text-white hover:text-purple-300">
                    <!-- Inserta aquí tu logotipo -->
                </a>
            </div>

            <!-- Lado derecho vacío para centrar el logo -->
            <div></div>
        </div>
    </nav>

    <!-- Nombre del autor bajo la barra de navegación
    @if(isset($posts) && $posts->isNotEmpty())
    <div class="fixed top-16 inset-x-0 bg-purple-300 p-2 z-40 text-black text-center">
        {{ $posts->first()->author->name ?? 'Autor desconocido' }}
    </div>
    @endif -->

    <!-- Agregar un padding-top para compensar la barra de navegación fija y el nombre del autor -->
    <div class="pt-32 bg-gray-100 py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Estilo de la cuadrícula de posts -->
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($posts as $post)
                        <div class="border rounded-lg overflow-hidden bg-white">
                            <p class="text-xs text-gray-600">Por {{ $post->author->name ?? 'Autor desconocido' }}</p>
                            <img src="{{ asset("storage/{$post->file->filepath}") }}" alt="Imagen del post" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <p class="text-sm truncate">{{ $post->body }}</p>
                                <p class="text-xs text-gray-600">Por {{ $post->author->name ?? 'Autor desconocido' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Estilos de la paginación -->
                <div class="py-6">
                    {{ $posts->appends(['search' => request()->query('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

