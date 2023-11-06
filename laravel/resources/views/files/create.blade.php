<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Create Post') }}
       </h2>
   </x-slot>

   @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                           <ul>
                               @foreach ($errors->all() as $error)
                               <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                        </div>
                        @endif
                        <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="body">Body:</label>
                                <textarea class="form-control" name="body" required></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="file_id">File:</label>
                                <input type="file" class="form-control" name="file_id"/>
                            </div>
                            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}" />
                            <button type="submit" class="btn btn-primary">Create</button>
                            <!-- ... otros botones ... -->
                            <button type="reset" class="btn btn-secondary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Reset</button>
                            <a href="{{ url('/files') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-4">
                                Back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>

