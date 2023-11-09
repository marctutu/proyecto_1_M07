<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // app/Http/Controllers/PlaceController.php

    public function index()
    {
        $places = Place::all();
        return view('places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('places.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file_id' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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

        $place = Place::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'author_id' => auth()->user()->id, // Asegúrate de que la autenticación está activa y que los usuarios tienen IDs
            'file_id' => $file_id,
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        return redirect()->route('places.show', $place)
            ->with('success', 'Place successfully created');
    }

    


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $place = Place::find($id); // O Place::findOrFail($id) para lanzar un error 404 si no se encuentra el lugar
    
        if (!$place) {
            // redirigir o manejar el caso de que el lugar no se encuentre
            return redirect()->route('places.index')->with('error', 'Place not found');
        }
    
        // Asegúrate de que la variable 'place' se pasa a la vista con el nombre correcto
        return view('places.show', compact('place'));
    }    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place) // La variable $place se inyecta directamente aquí
{
    return view('places.edit', compact('place')); // Pasa la variable 'place' a la vista
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file_id' => 'sometimes|image|mimes:jpg,jpeg,png,gif',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($request->hasFile('file_id')) {
            // Si hay un archivo existente, podría ser una buena idea eliminarlo
            if ($place->file) {
                Storage::disk('public')->delete($place->file->filepath);
                $place->file->delete(); // Elimina el registro del archivo anterior
            }

            // Sube el nuevo archivo y crea un registro
            $file = $request->file('file_id');
            $path = Storage::disk('public')->putFile('file_ids', $file);
            $fileSize = $file->getSize();

            $fileModel = new File;
            $fileModel->filepath = $path;
            $fileModel->filesize = $fileSize;
            $fileModel->save();

            // Actualiza file_id con el nuevo archivo
            $validatedData['file_id'] = $fileModel->id;
        }

        // Actualiza el lugar con los datos validados
        $place->update($validatedData);

        return redirect()->route('places.index')->with('success', 'Place successfully updated');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $Place)
    {
        $Place->delete();

        return redirect()->route('places.index')
            ->with('success', 'Place successfully deleted');
    }

}

