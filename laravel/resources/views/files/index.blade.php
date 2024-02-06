@extends('layouts.box-app')

@section('box-title')
    {{ __('Files') }}
@endsection

@php
    $cols = [
        "id",
        "filepath",
        "filesize",
        "created_at",
        "updated_at"
    ];
@endphp

@section('box-content')
    <!-- Results -->
    <x-table-index :cols=$cols :rows=$files 
        :enableActions=true parentRoute='files' />
    <!-- Buttons -->
    <div class="mt-8">
        @can('create', App\Models\File::class)
        <x-primary-button href="{{ route('files.create') }}">
            {{ __('Add new file') }}
        </x-primary-button>
        @endcan
        <x-secondary-button href="{{ route('dashboard') }}">
            {{ __('Back to dashboard') }}
        </x-secondary-button>
    </div>
@endsection