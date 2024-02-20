@extends('layouts.box-app')

@section('box-title')
    {{ __('Post') . " " . $post->id }}
@endsection

@section('box-content')
<x-columns columns=2>
    @section('column-1')
        <img class="w-full" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
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

        <div class="mt-8">
            <h4>{{ __('Add a comment') }}</h4>
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <textarea name="comment" class="form-control" rows="3" required></textarea>
                <button type="submit" class="btn btn-primary mt-2">{{ __('Submit') }}</button>
            </form>
        </div>

        @forelse($post->comments as $comment)
            <div class="mb-4">
                <p><strong>{{ $comment->user->name }}</strong> ({{ $comment->created_at->format('d/m/Y H:i') }}):</p>
                <p>{{ $comment->comment }}</p>
                @if(auth()->user()->id === $comment->user_id || auth()->user()->isAdmin())
                    <form action="{{ route('comments.destroy', [$post, $comment]) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                    </form>
                @endif
            </div>
        @empty
            <p>{{ __('No comments yet.') }}</p>
        @endforelse


    @endsection
</x-columns>
@endsection
