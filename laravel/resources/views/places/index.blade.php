@extends('layouts.box-app')

@section('box-title')
    {{ __('Places') }}
@endsection

@php
    $cols = [
        "id",
        "name",
        "file_id",
        "latitude",
        "longitude",
        "author.name",
        "visibility.name",
        "created_at",
        "updated_at"
    ];
@endphp

@section('box-content')
    <!-- Results -->
    <x-table-index :cols=$cols :rows=$places 
        :enableActions=true parentRoute='places'
        :enableSearch=true :search=$search />
    <!-- Pagination -->
    <div class="mt-8">
        {{ $places->links() }}
    </div>
    <!-- Buttons -->
    <div class="mt-8">
        @can('create', App\Models\Place::class)
        <x-primary-button href="{{ route('places.create') }}">
            {{ __('Add new place') }}
        </x-primary-button>
        @endcan
        <x-secondary-button href="{{ route('dashboard') }}">
            {{ __('Back to dashboard') }}
        </x-secondary-button>
    </div>
@endsection