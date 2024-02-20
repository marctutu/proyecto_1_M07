<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Post;
use App\Models\Place;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::all();

        if ($files->count() > 0) {
            return response()->json([
                'success' => true,
                'data'    => $files
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Files not found'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);
        // Desar fitxer al disc i inserir dades a BD
        $upload = $request->file('upload');
        $file = new File();
        $ok = $file->diskSave($upload); // ⚠️ Mètode solució profe!!! ⚠️


        if ($ok) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }


    /**
     * Método puente para actualizar archivos mediante POST debido a limitaciones de PHP.
     */
    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /* Funciona a medias no funciona read notfun */
        $file = File::find((int)$id);

        if ($file) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error: File not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        // Buscar el archivo por su ID
        $file = File::find($id);

        // Verificar si el archivo existe
        if (!$file) {
            return response()->json([
                'success'  => false,
                'message' => 'File not found'
            ], 404);
        }

         // Validar los datos de la solicitud
         $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);

        
        // Obtener el archivo cargado desde la solicitud
        $upload = $request->file('upload');

        // Guardar el archivo en el disco y actualizar la base de datos
        $ok = $file->diskSave($upload);

        // Verificar si la operación de actualización fue exitosa
        if ($ok) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error updating file'
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::find($id);

        if ($file) {
            $file->diskDelete($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'message' => 'File deleted successfully'
                ]
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'File not found'
            ], 404);
        }
    }
}