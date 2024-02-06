@extends('layouts.box-app')

@section('box-title')
    {{ __('File') . " " . $file->id }}
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
<x-columns columns=2>
    @section('column-1')
        <img class="w-full" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    @endsection
    @section('column-2')
        <table class="table">
            <tbody>
                <tr>
                    <td><strong>ID<strong></td>
                    <td>{{ $file->id }}</td>
                </tr>
                <tr>
                    <td><strong>Filepath</strong></td>
                    <td>{{ $file->filepath }}</td>
                </tr>
                <tr>
                    <td><strong>Filesize</strong></td>
                    <td>{{ $file->filesize }}</td>
                </tr>
                <tr>
                    <td><strong>Created</strong></td>
                    <td>{{ $file->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Updated</strong></td>
                    <td>{{ $file->updated_at }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mt-8">
            @can('update', $file)
            <x-primary-button href="{{ route('files.edit', $file) }}">
                {{ __('Edit') }}
            </x-danger-button>
            @endcan
            @can('delete', $file)
            <x-danger-button href="{{ route('files.delete', $file) }}">
                {{ __('Delete') }}
            </x-danger-button>
            @endcan
            @can('viewAny', App\Models\File::class)
            <x-secondary-button href="{{ route('files.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
            @endcan
        </div>
    @endsection
</x-columns>
@endsection
