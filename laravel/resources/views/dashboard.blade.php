@extends('layouts.box-app')

@section('box-title')
    {{ __('Dashboard') }}
@endsection

@section('box-content')
    <p class="mb-4">{{ __("You're logged in!") }}</p>
    <h2 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">{{ __('Resources') }}</h2>
    @can('viewAny', App\Models\File::class)
    <x-primary-button href="{{ url('/files') }}">
        🗄️ {{ __('Files') }}
    </x-primary-button>
    @endcan
    @can('viewAny', App\Models\Post::class)
    <x-primary-button href="{{ url('/posts') }}">
        📑 {{ __('Posts') }}        
    </x-primary-button>
    @endcan
    @can('viewAny', App\Models\Place::class)
    <x-primary-button href="{{ url('/places') }}">
        📍 {{ __('Places') }}
    </x-primary-button>
    @endcan
@endsection