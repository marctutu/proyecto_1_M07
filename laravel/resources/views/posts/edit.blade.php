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
        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div>
                <x-input-label for="body" :value="__('Body')" />
                <x-textarea name="body" id="body" class="block mt-1 w-full" :value="$post->body" />
            </div>
            <div>
                <x-input-label for="upload" :value="__('Upload')" />
                <x-text-input type="file" name="upload" id="upload" class="block mt-1 w-full" />
            </div>
            <div>
                <x-input-label for="latitude" :value="__('Latitude')" />
                <x-text-input type="text" name="latitude" id="latitude" class="block mt-1 w-full" :value="$post->latitude" />
            </div>
            <div>
                <x-input-label for="longitude" :value="__('Longitude')" />
                <x-text-input type="text" name="longitude" id="longitude" class="block mt-1 w-full" :value="$post->longitude" />
            </div>
            <div class="mt-8">
                <x-primary-button>
                    {{ __('Update') }}
                </x-primary-button>
                <x-secondary-button type="reset">
                    {{ __('Reset') }}
                </x-secondary-button>
                <x-secondary-button href="{{ route('posts.index') }}">
                    {{ __('Back to list') }}
                </x-secondary-button>
            </div>
        </form>
    @endsection
</x-columns>
@endsection