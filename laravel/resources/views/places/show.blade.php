@extends('layouts.box-app')

@section('box-title')
    {{ __('Place') . " " . $place->id }}
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
                    <td>{{ $place->id }}</td>
                </tr>
                <tr>
                    <td><strong>Name</strong></td>
                    <td>{{ $place->name }}</td>
                </tr>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>{{ $place->description }}</td>
                </tr>
                <tr>
                    <td><strong>Lat</strong></td>
                    <td>{{ $place->latitude }}</td>
                </tr>
                <tr>
                    <td><strong>Lng</strong></td>
                    <td>{{ $place->longitude }}</td>
                </tr>
                <tr>
                    <td><strong>Author</strong></td>
                    <td>{{ $author->name }}</td>
                </tr>
                <tr>
                    <td><strong>Visibility</strong></td>
                    <td>{{ $place->visibility->name }}</td>
                </tr>
                <tr>
                    <td><strong>Created</strong></td>
                    <td>{{ $place->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Updated</strong></td>
                    <td>{{ $place->updated_at }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mt-8">
            @can('update', $place)
            <x-primary-button href="{{ route('places.edit', $place) }}">
                {{ __('Edit') }}
            </x-danger-button>
            @endcan
            @can('delete', $place)
            <x-danger-button href="{{ route('places.delete', $place) }}">
                {{ __('Delete') }}
            </x-danger-button>
            @endcan
            @can('viewAny', App\Models\Place::class)
            <x-secondary-button href="{{ route('places.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
            @endcan
        </div>
        <div class="mt-8">
            <p>{{ $numFavs . " " . __('favorites') }}</p>
            @include('partials.buttons-favs')
        </div>
    @endsection
</x-columns>
@endsection
