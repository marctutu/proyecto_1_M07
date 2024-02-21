<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\Api\StoreCommentRequest;
use App\Models\Post;
use App\Models\File;
use App\Models\User;
use App\Models\Visibility;
use App\Models\Like;
use Illuminate\Http\UploadedFile;


class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::all();
        return CommentResource::collection($comments);
    }


    public function store(Request $request)
    {
        // Validar datos del formulario
        $validatedData = $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|exists:posts,id', // Asegúrate de que el lugar exista en la base de datos
        ]);
    
        try {
            // Obtener el ID del usuario autenticado
            $userId = auth()->id();
    
            // Crear la reseña con los campos proporcionados
            $comment = new Comment([
                'comment' => $request->input('comment'),
                'user_id' => $userId,
                'post_id' => $request->input('post_id'),
            ]);
    
            // Guardar la reseña en la base de datos
            $success = $comment->save();
    
            // Devolver una respuesta con el código de estado 201 (creado) y los datos de la reseña creada
            return response()->json([
                'success' => $success,
                'data' => $comment,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso de almacenamiento de la reseña
            \Log::error('Error storing comment: ' . $e->getMessage());
            // Devolver una respuesta con el código de estado 500 (error interno del servidor)
            return response()->json([
                'success' => false,
                'message' => 'Error storing comment',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($postId, $commentId)
    {
        $comment = Comment::find($commentId);
            $comment->delete();
            return response()->noContent();
    }
    
}