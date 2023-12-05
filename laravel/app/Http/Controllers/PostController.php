<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\File;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }
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
                    ->withCount('liked')
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
            ->with('success', __('Post successfully created'));
    }

    public function show(Post $post)
    {
        // No necesitas buscar el post, ya que se inyecta automáticamente.
        if ($post) {
            return view('posts.show', compact('post'));
        } else {
            return redirect()->route('posts.index')
                ->with('error', __('Post not found'));
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
        return redirect()->route('posts.index')->with('success', __('Post and file successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', __('Post successfully deleted'));
    }

    public function like(Post $post)
    {
        $this->authorize('like', $post);
        // Verifica si el usuario actual ya dio "like" a la publicación
        if (!$post->liked->contains(auth()->user())) {
            // Agrega el "like" al usuario actual
            $post->liked()->attach(auth()->user()->id);
            return back()->with('success', __('You liked this post'));
        }

        return back()->with('error', __('You already liked this post'));
    }

    public function unlike(Post $post)
    {
        $this->authorize('unlike', $post);
        // Verifica si el usuario actual ya dio "like" a la publicación
        if ($post->liked->contains(auth()->user())) {
            // Quita el "like" del usuario actual
            $post->liked()->detach(auth()->user()->id);
            return back()->with('success', __('You unliked this post'));
        }

        return back()->with('error', __('You have not liked this post'));
    }

    public function postsm09(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::with('author')
            ->when($search, function ($query) use ($search) {
                return $query->where('description', 'favorite', "%{$search}%");
            })
            ->withCount('liked')
            ->paginate(5);
            return view('postsm09', compact('posts', 'search'));
        }
}
