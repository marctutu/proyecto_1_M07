<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\File;
use App\Models\User;
use App\Models\Visibility;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


class PlaceController extends Controller
{

    public function __construct()
    {
    $this->middleware('auth:sanctum')->only('store');
    $this->middleware('auth:sanctum')->only('update');
    $this->middleware('auth:sanctum')->only('destroy');
    $this->middleware('auth:sanctum')->only('favorite');
    $this->middleware('auth:sanctum')->only('unfavorite');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $places = Place::all();
        return response()->json([
            'success' => true,
            'data' => $places,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,mp4,png|max:1024',
            'name' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'visibility_id' => 'required',
        ]);
    
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $name = $request->get('name');
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility_id = $request->get('visibility_id');
        \Log::debug("Storing file '{$fileName}' ($fileSize)...");

        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
    
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");

            // Desar dades a BD

            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);

            $place = Place::create([
                'name' => $name,
                'description' => $description,
                'file_id' => $file->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'visibility_id' => $visibility_id,
                'author_id' =>auth()->user()->id,
            ]);

            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 201);


        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return response()->json([
                'success'  => false,
                'message' => 'Error storing place'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::find($id);
        if($place == null){
            return response()->json([
                'success' => false,
                'message'    => 'Error place not found'
            ], 404);
        }
        else{
            return response()->json([
                'success'  => true,
                'data' => $place
            ], 200);

        }

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = Place::find($id);
        if ($place){   
        
            // Validar fitxer
            $validatedData = $request->validate([
                'upload' => 'mimes:gif,jpeg,jpg,mp4,png|max:1024',
            ]);
        
            $file=File::find($place->file_id);

            // Obtenir dades del fitxer

            $upload = $request->file('upload');
            $controlNull = FALSE;
            if(! is_null($upload)){
                $fileName = $upload->getClientOriginalName();
                $fileSize = $upload->getSize();

                \Log::debug("Storing file '{$fileName}' ($fileSize)...");

                // Pujar fitxer al disc dur
                $uploadName = time() . '_' . $fileName;
                $filePath = $upload->storeAs(
                    'uploads',      // Path
                    $uploadName ,   // Filename
                    'public'        // Disk
                );
            }
            else{
                $filePath = $file->filepath;
                $fileSize = $file->filesize;
                $controlNull = TRUE;
            }

            if (\Storage::disk('public')->exists($filePath)) {
                if ($controlNull == FALSE){
                    \Storage::disk('public')->delete($file->filepath);
                    \Log::debug("Local storage OK");
                    $fullPath = \Storage::disk('public')->path($filePath);
                    \Log::debug("File saved at {$fullPath}");

                }

                // Desar dades a BD

                $file->filepath=$filePath;
                $file->filesize=$fileSize;
                $file->save();
                \Log::debug("DB storage OK");
                $place->name=$request->input('name');
                $place->description=$request->input('description');
                $place->latitude=$request->input('latitude');
                $place->longitude=$request->input('longitude');
                $place->visibility_id=$request->input('visibility_id');
                $place->save();

                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 201);


            } else {
                \Log::debug("Local storage FAILS");
                // Patró PRG amb missatge d'error
                return response()->json([
                    'success'  => false,
                    'message' => 'Error uploading place'
                ], 500);
            }
        }
        else{
            return response()->json([
                'success'  => false,
                'message' => 'Error searching place'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::find($id);
        if($place){
        
            if(auth()->user()->id == $place->author_id){

                $file=File::find($place->file_id);

                \Storage::disk('public')->delete($place -> id);
                $place->delete();

                \Storage::disk('public')->delete($file -> filepath);
                $file->delete();
                if (\Storage::disk('public')->exists($place->id)) {
                    \Log::debug("Local storage OK");
                    // Patró PRG amb missatge d'error
                    return response()->json([
                        'success'  => false,
                        'message' => 'Error deleting place'
                    ], 500);
                }
                else{
                    \Log::debug("Place Delete");
                    // Patró PRG amb missatge d'èxit
                    return response()->json([
                        'success' => true,
                        'data'    => $place
                    ], 200);
                } 
                
            }
            else{
                return response()->json([
                    'success'  => false,
                    'message' => 'Error deleting place, its not yours'
                ], 500);
            }
        }
        else{
            return response()->json([
                'success'  => false,
                'message' => 'Place not found'
            ], 404);

        } 

    }

    public function favorite($id)
    {
        $place=Place::find($id);
        if (Favorite::where([
                ['user_id', "=" , auth()->user()->id],
                ['place_id', "=" ,$id],
            ])->exists()) {
            return response()->json([
                'success'  => false,
                'message' => 'The place is already favorite'
            ], 500);
        }else{
            $favorite = Favorite::create([
                'user_id' => auth()->user()->id,
                'place_id' => $place->id,
            ]);
            return response()->json([
                'success' => true,
                'data'    => $favorite
            ], 200);
        }        
    }

    public function unfavorite($id)
    {
        $place=Place::find($id);
        if (Favorite::where([['user_id', "=" ,auth()->user()->id],['place_id', "=" ,$place->id],])->exists()) {
            
            $favorite = Favorite::where([
                ['user_id', "=" ,auth()->user()->id],
                ['place_id', "=" ,$id],
            ]);
            $favorite->first();
    
            $favorite->delete();

            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'The place is not favorite'
            ], 500);
            
        }  
        
    }

}