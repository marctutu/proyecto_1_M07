<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
 
    public function __construct()
    {
        $this->authorizeResource(Place::class, 'place');
    }

    public function index(Request $request)
{
    // Recuperem el valor de cerca de la sol·licitud
    $search = $request->input('search');

    // Consultem els places amb paginació i, si hi ha un terme de cerca, filtrarem per aquest terme
    $places = Place::with('author')
        ->when($search, function ($query) use ($search) {
            return $query->where('description', 'favorite', "%{$search}%");
        })
        ->withCount('favorited')
        ->paginate(5);

    // Passem els places i el terme de cerca actual a la vista
    return view('places.index', compact('places', 'search'));
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
        $place = Place::with(['author', 'favorited'])->findOrFail($id);
    
        if ($place) {
            return view('places.show', compact('place'));
        } else {
            return redirect()->route('places.index')
                ->with('error', 'Place not found');
        }
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

    public function favorite(Place $place)
    {
        // Verifica si el usuario actual ya dio "favorite" a la publicación
        if (!$place->favorited->contains(auth()->user())) {
            // Agrega el "favorite" al usuario actual
            $place->favorited()->attach(auth()->user()->id);
            return back()->with('success', 'You favorited this place');
        }

        return back()->with('error', 'You already favorited this place');
    }

    public function unfavorite(Place $place)
    {
        // Verifica si el usuario actual ya dio "favorite" a la publicación
        if ($place->favorited->contains(auth()->user())) {
            // Quita el "favorite" del usuario actual
            $place->favorited()->detach(auth()->user()->id);
            return back()->with('success', 'You unfavorited this place');
        }

        return back()->with('error', 'You have not favorited this place');
    }

    public function placesm09(Request $request)
    {
        $search = $request->input('search');

        // Consultem els places amb paginació i, si hi ha un terme de cerca, filtrarem per aquest terme
        $places = Place::with('author')
            ->when($search, function ($query) use ($search) {
                return $query->where('description', 'favorite', "%{$search}%");
            })
            ->withCount('favorited')
            ->paginate(5);
    
        // Passem els places i el terme de cerca actual a la vista
        return view('placesm09', compact('places', 'search'));
    }

}

