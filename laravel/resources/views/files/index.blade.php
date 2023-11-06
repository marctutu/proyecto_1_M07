<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Posts and Files') }}
       </h2>
   </x-slot>

   @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <a href="{{ route('files.create') }}" class="btn btn-primary mb-3">Create New Post</a>

                        <h3 class="text-xl font-bold mb-3">Posts</h3>
                        <table class="table-auto min-w-full mb-6">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2">Author ID</th>
                                    <th class="border px-4 py-2">Body</th>
                                    <th class="border px-4 py-2">File ID</th>
                                    <th class="border px-4 py-2">Filepath</th>
                                    <th class="border px-4 py-2">Photo</th>
                                    <th class="border px-4 py-2">Created At</th>
                                    <th class="border px-4 py-2">Updated At</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $post->id }}</td>
                                        <td class="border px-4 py-2">{{ $post->author_id }}</td>
                                        <td class="border px-4 py-2">{{ $post->body }}</td>
                                        @if ($post->file)
                                            <td class="border px-4 py-2">{{ $post->file->id }}</td>
                                            <td class="border px-4 py-2">{{ $post->file->filepath }}</td>
                                            <td class="border px-4 py-2">
                                                <img src="{{ asset('storage/' . $post->file->filepath) }}" alt="Image" width="100" />
                                            </td>
                                            <td class="border px-4 py-2">{{ $post->file->created_at }}</td>
                                            <td class="border px-4 py-2">{{ $post->file->updated_at }}</td>
                                        @else
                                            <td class="border px-4 py-2" colspan="6">No file associated</td>
                                        @endif
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('files.show', ['file' => $post->file->id]) }}" class="btn btn-warning">Show</a>
                                            <!-- <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button> -->
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>


