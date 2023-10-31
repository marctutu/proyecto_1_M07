<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Upload File') }}
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
                        <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
                           @csrf
                           <div class="form-group">
                               <label for="upload">File:</label>
                               <input type="file" class="form-control" name="upload"/>
                           </div>
                           <button type="submit" class="btn btn-primary">Create</button>
                           <button type="reset" class="btn btn-secondary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
