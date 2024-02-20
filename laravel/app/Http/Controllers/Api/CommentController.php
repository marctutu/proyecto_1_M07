<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // Mostrar todos los comentarios de un post
    public function index(Post $post)
    {
        $comments = $post->comments; // Asumiendo que tienes una relación 'comments' en tu modelo Post
        return response()->json($comments);
    }

    // Guardar un nuevo comentario para un post
    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:255', // Ajusta las reglas según tus necesidades
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comment = new Comment();
        $comment->comment = $request->comment;
        // Asegúrate de tener una columna user_id en tu tabla comments para guardar el autor del comentario
        $comment->user_id = auth()->user()->id; 
        $post->comments()->save($comment);

        return response()->json($comment, 201);
    }

    // Eliminar un comentario
    public function destroy(Post $post, Comment $comment)
    {
        if ($comment->user_id != auth()->user()->id && !auth()->user()->can('delete comments')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
