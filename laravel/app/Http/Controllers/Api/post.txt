<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\File;
use App\Models\User;
use App\Models\Like;
use App\Models\Visibility;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth:sanctum')->only('store');
    $this->middleware('auth:sanctum')->only('update');
    $this->middleware('auth:sanctum')->only('destroy');
    $this->middleware('auth:sanctum')->only('like');
    $this->middleware('auth:sanctum')->only('unlike');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'success' => true,
            'data' => $posts,
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
            'body' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'visibility_id' => 'required',
        ]);
    
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $body = $request->get('body');
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

            $post = Post::create([
                'body' => $body,
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
                'data'    => $post
            ], 201);


        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading post'
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
        $post = Post::find($id);
        if($post == null){
            return response()->json([
                'success' => false,
                'message'    => 'Error post not found'
            ], 404);
        }
        else{
            return response()->json([
                'success'  => true,
                'data' => $post
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
        
        $post = Post::find($id);
        if ($post){   

            // Validar fitxer
            $validatedData = $request->validate([
                'upload' => 'mimes:gif,jpeg,jpg,mp4,png|max:1024',
            ]);
        
            $file=File::find($post->file_id);

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
                $post->body=$request->input('body');
                $post->latitude=$request->input('latitude');
                $post->longitude=$request->input('longitude');
                $post->visibility_id=$request->input('visibility_id');
                $post->save();

                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $post
                ], 201);


            } else {
                \Log::debug("Local storage FAILS");
                // Patró PRG amb missatge d'error
                return response()->json([
                    'success'  => false,
                    'message' => 'Error uploading post'
                ], 500);
            }
        }
        else{
            return response()->json([
                'success'  => false,
                'message' => 'Error searching post'
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

        $post = Post::find($id);
        if($post){

            if(auth()->user()->id == $post->author_id){

                $file=File::find($post->file_id);

                \Storage::disk('public')->delete($post -> id);
                $post->delete();

                \Storage::disk('public')->delete($file -> filepath);
                $file->delete();
                if (\Storage::disk('public')->exists($post->id)) {
                    \Log::debug("Local storage OK");
                    // Patró PRG amb missatge d'error
                    return response()->json([
                        'success'  => false,
                        'message' => 'Error deleting post'
                    ], 500);
                }
                else{
                    \Log::debug("Post Delete");
                    // Patró PRG amb missatge d'èxit
                    return response()->json([
                        'success' => true,
                        'data'    => $post
                    ], 200);
                } 
            }
            else{
                return response()->json([
                    'success'  => false,
                    'message' => 'Error deleting post, its not yours'
                ], 500);
            }
        }
        else{
            return response()->json([
                'success'  => false,
                'message' => 'Post not found'
            ], 404);

        } 
    }

    public function like($id)
    {
        $post=Post::find($id);
        if (Like::where([
                ['user_id', "=" , auth()->user()->id],
                ['post_id', "=" ,$id],
            ])->exists()) {
            return response()->json([
                'success'  => false,
                'message' => 'The post is already like'
            ], 500);
        }else{
            $like = Like::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
            ]);
            return response()->json([
                'success' => true,
                'data'    => $like
            ], 200);
        }        
    }

    public function unlike($id)
    {
        $post=Post::find($id);
        if (Like::where([['user_id', "=" ,auth()->user()->id],['post_id', "=" ,$post->id],])->exists()) {
            
            $like = Like::where([
                ['user_id', "=" ,auth()->user()->id],
                ['post_id', "=" ,$id],
            ]);
            $like->first();
    
            $like->delete();

            return response()->json([
                'success' => true,
                'data'    => $post
            ], 200);
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'The post is not like'
            ], 500);
            
        }  
        
    }

}