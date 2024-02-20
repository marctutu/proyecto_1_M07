<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Muestra una lista de los comentarios de un post específico.
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->get(); // Asegúrate de que el modelo Post tenga una relación comments()

        return view('comments.index', compact('comments', 'post'));
    }

    /**
     * Almacena un nuevo comentario en la base de datos.
     */
    public function store(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->comment = $validatedData['comment'];
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('posts.show', $post->id)
                         ->with('success', __('Comment added successfully.'));
    }

    /**
     * Elimina un comentario específico.
     */
    public function destroy(Post $post, Comment $comment)
    {
        // Asegurarse de que el usuario pueda eliminar el comentario
        if (Auth::id() === $comment->user_id || Auth::user()->hasRole('admin')) {
            $comment->delete();

            return redirect()->route('posts.show', $post->id)
                             ->with('success', __('Comment removed successfully.'));
        } else {
            return back()->with('error', __('You do not have permission to delete this comment.'));
        }
    }
}
