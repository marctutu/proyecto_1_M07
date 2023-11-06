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
            $path = $file->store('uploads', 'public');
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
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'body' => 'required|string',
            'upload' => 'sometimes|file', // Add validation for the file
        ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = $file->store('files', 'public'); // This uploads the file to `storage/app/public/files`

            // Update the associated file's path in the database
            $post->file()->update([
                'filepath' => $filename,
                // 'filesize' => $file->getSize(), // Add this if you want to store file size
            ]);
        }

        // Update the post's body
        $post->update(['body' => $validatedData['body']]);

        return redirect()->route('posts.index', $post)->with('success', 'Post and file successfully updated');
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
