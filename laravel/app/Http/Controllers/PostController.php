<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\File;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         $search = $request->input('search');
     
         $posts = Post::with('author')
                      ->when($search, function ($query) use ($search) {
                          return $query->where('body', 'LIKE', "%{$search}%");
                      })
                      ->paginate(5);
     
         // Pasar los posts y el término de búsqueda a la vista
         return view('posts.index', compact('posts', 'search'));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required|string',
            'file_id' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $file_id = null;
        if ($request->hasFile('file_id')) {
            $file = $request->file('file_id');
            $path = $file->store('file_ids', 'public');
            $fileSize = $file->getSize();

            $fileModel = new \App\Models\File;
            $fileModel->filepath = $path;
            $fileModel->filesize = $fileSize;
            $fileModel->save();

            $file_id = $fileModel->id;
        }

        $post = Post::create([
            'body' => $validatedData['body'],
            'author_id' => auth()->user()->id,
            'file_id' => $file_id,
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post successfully created');
    }

    


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        $post = Post::with('author')->findOrFail($id);

        if ($post) {
            return view('posts.show', compact('post'));
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'Post not found');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $file = $post->file;
        return view('posts.edit', compact('post', 'file'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'body' => 'required|string',
            'file_id' => 'sometimes|file',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Verifica si se subió un archivo y actúa en consecuencia.
        if ($request->hasFile('file_id')) {
            $file = $request->file('file_id');
            $filename = $file->store('files', 'public'); // Esto carga el archivo a `storage/app/public/files`
        
            // Recupera o crea un registro de archivo, luego obtén el ID
            $fileModel = $post->file ?? new File();
            $fileModel->filepath = $filename;
            $fileModel->save();
        
            // Establece el file_id con el ID del registro del archivo
            $validatedData['file_id'] = $fileModel->id;
        }
        
        // Actualiza el post con los datos validados
        $post->update($validatedData);
        
    
        // Actualiza el cuerpo del post.
        $post->update($validatedData);
    
        // Redirige con un mensaje de éxito.
        return redirect()->route('posts.index')->with('success', 'Post and file successfully updated');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post successfully deleted');
    }

}
