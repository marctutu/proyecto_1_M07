@extends('layouts.box-app')

@section('box-title')
    {{ __('Post') . " " . $post->id }}
@endsection

@section('box-content')
<x-columns columns=2>
    @section('column-1')
        <img class="w-full" src="{{ asset('storage/'.$file->filepath) }}" title="Image pcomment"/>
    @endsection
    @section('column-2')
        <table class="table">
            <tbody>                
                <tr>
                    <td><strong>ID<strong></td>
                    <td>{{ $post->id }}</td>
                </tr>
                <tr>
                    <td><strong>Body</strong></td>
                    <td>{{ $post->body }}</td>
                </tr>
                <tr>
                    <td><strong>Lat</strong></td>
                    <td>{{ $post->latitude }}</td>
                </tr>
                <tr>
                    <td><strong>Lng</strong></td>
                    <td>{{ $post->longitude }}</td>
                </tr>
                <tr>
                    <td><strong>Author</strong></td>
                    <td>{{ $author->name }}</td>
                </tr>
                <tr>
                    <td><strong>Visibility</strong></td>
                    <td>{{ $post->visibility->name }}</td>
                </tr>
                <tr>
                    <td><strong>Created</strong></td>
                    <td>{{ $post->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Updated</strong></td>
                    <td>{{ $post->updated_at }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mt-8">
            @can('update', $post)
            <x-primary-button href="{{ route('posts.edit', $post) }}">
                {{ __('Edit') }}
            </x-danger-button>
            @endcan
            @can('delete', $post)
            <x-danger-button href="{{ route('posts.delete', $post) }}">
                {{ __('Delete') }}
            </x-danger-button>
            @endcan
            @can('viewAny', App\Models\Post::class)
            <x-secondary-button href="{{ route('posts.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
            @endcan
        </div>
        <div class="mt-8">
            <p>{{ $numLikes . " " . __('likes') }}</p>
            @include('partials.buttons-likes')
        </div>

        <!-- Mostrar formulario de creación de comentarios -->
        <h2>Crear Comentario</h2>
        <form method="POST" action="{{ route('comments.store', $post) }}">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div>
                <label for="comment">Contenido del comentario:</label>
                <textarea name="comment" id="comment"></textarea>
            </div>
            <button type="submit">Enviar comentario</button>
        </form>

        <!-- Mostrar comentarios -->
        @if($comments->count() > 0)
            <h2>Comentarios</h2>
            <ul>
                @foreach($comments as $comment)
                    <li>
                        {{ $comment->comment }}
                        <!-- Mostrar botón de eliminar solo si el usuario autenticado es el autor de la reseña -->
                        @if(auth()->check() && $comment->user_id === auth()->id())
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif


    @endsection
</x-columns>
@endsection
