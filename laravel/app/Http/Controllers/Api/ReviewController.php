<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\Api\StoreReviewRequest;
use App\Models\Place;
use App\Models\File;
use App\Models\User;
use App\Models\Visibility;
use App\Models\Favorite;
use Illuminate\Http\UploadedFile;


class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::all();
        return ReviewResource::collection($reviews);
    }


    public function store(Request $request)
    {
        // Validar datos del formulario
        $validatedData = $request->validate([
            'content' => 'required|string',
            'place_id' => 'required|exists:places,id', // Asegúrate de que el lugar exista en la base de datos
        ]);
    
        try {
            // Obtener el ID del usuario autenticado
            $userId = auth()->id();
    
            // Crear la reseña con los campos proporcionados
            $review = new Review([
                'content' => $request->input('content'),
                'user_id' => $userId,
                'place_id' => $request->input('place_id'),
            ]);
    
            // Guardar la reseña en la base de datos
            $review->save();
    
            // Devolver una respuesta con el código de estado 201 (creado) y los datos de la reseña creada
            return response()->json([
                'success' => true,
                'data' => $review,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso de almacenamiento de la reseña
            \Log::error('Error storing review: ' . $e->getMessage());
            // Devolver una respuesta con el código de estado 500 (error interno del servidor)
            return response()->json([
                'success' => false,
                'message' => 'Error storing review',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($placeId, $reviewId)
    {
        $review = Review::find($reviewId);
            $review->delete();
            return response()->noContent();
    }
    
}
