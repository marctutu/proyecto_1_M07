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
    // app/Http/Controllers/PostController.php

    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
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
            'file_id' => 'nullable|image|mimes:jpg,jpeg,png,gif', // Asegúrate de validar como imagen
        ]);

        $file_id = null;
        if ($request->hasFile('file_id')) {
            $file = $request->file('file_id');
            $path = $file->store('file_ids', 'public');
            $fileSize = $file->getSize();

            $fileModel = new \App\Models\File; // Asegúrate de usar el namespace correcto
            $fileModel->filepath = $path;
            $fileModel->filesize = $fileSize;
            $fileModel->save();

            $file_id = $fileModel->id;
        }

        $post = Post::create([
            'body' => $validatedData['body'],
            'author_id' => auth()->user()->id,
            'file_id' => $file_id,
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
        $file = $post->file; // Assuming there's a file relation defined in your Post model
        return view('posts.edit', compact('post', 'file'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'body' => 'required|string',
            'file_id' => 'sometimes|file', // Asegúrate de que el nombre del campo coincida con tu formulario.
        ]);
    
        // Verifica si se subió un archivo y actúa en consecuencia.
        if ($request->hasFile('file_id')) {
            $file = $request->file('file_id');
            $filename = $file->store('files', 'public'); // Esto carga el archivo a `storage/app/public/files`
    
            // Actualiza la ruta del archivo asociado en la base de datos
            // Si el post ya tiene un archivo, actualízalo. Si no, crea uno nuevo.
            if ($post->file) {
                $post->file->update(['filepath' => $filename]);
            } else {
                $fileModel = new File(['filepath' => $filename]);
                $post->file()->save($fileModel);
            }
        }
    
        // Actualiza el cuerpo del post.
        $post->update(['body' => $validatedData['body']]);
    
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
