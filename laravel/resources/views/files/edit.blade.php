@extends('layouts.box-app')

@section('box-title')
    {{ __('File') . " " . $file->id }}
@endsection

@section('box-content')
<x-columns columns=2>
    @section('column-1')
        <img class="w-full" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    @endsection
    @section('column-2')
        <form method="POST" action="{{ route('files.update', $file) }}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div>
                <x-input-label for="upload" :value="__('Upload')" />
                <x-text-input type="file" name="upload" id="upload" class="block mt-1 w-full" />
                <div class="block mt-1 w-full">{{ __('Size') }}: <span id="filesize">{{ $file->filesize/1000 }}</span> KB</div>
            </div>
            <div class="mt-8">
                <x-primary-button>
                    {{ __('Update') }}
                </x-primary-button>
                <x-secondary-button type="reset">
                    {{ __('Reset') }}
                </x-secondary-button>
                <x-secondary-button href="{{ route('files.index') }}">
                    {{ __('Back to list') }}
                </x-secondary-button>
            </div>
        </form>

        <script>
        document.getElementById("upload").addEventListener("change", (event) => {
            let size = event.target.files[0].size
            document.getElementById("filesize").innerHTML = Math.floor(size/1000)
        })
        </script>
    @endsection
</x-columns>
@endsection