<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(File::class, 'file');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("files.index", [
            "files" => File::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("files.create");
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

       // Obtenir dades del fitxer
        $upload = $request->file('upload');
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
        
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Disk storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
           // Desar dades a BD
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('files.show', $file)
                ->with('success', __('File successfully saved'));
        } else {
            \Log::debug("Disk storage FAILS");
           // Patró PRG amb missatge d'error
            return redirect()->route("files.create")
                ->with('error', __('ERROR uploading file'));
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {

        $this->authorize('view', $file); // Verifica la autorización utilizando el objeto File
    
        if (\Storage::disk('public')->exists($file->filepath)) {
            $url = asset("storage/{$file->filepath}");
            return view('files.show', compact('file', 'url'));
        } else {
            return redirect()->route('files.index')
                ->with('error', 'File not found');
        }
    }
    
    



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        return view('files.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        $validatedData = $request->validate([
            'upload' => 'required|mimes:jpg,png,gif|max:2048',
        ]);

        $upload = $request->file('upload');
        $fileName = time() . '_' . $upload->getClientOriginalName();
        $filePath = $upload->storeAs('uploads', $fileName, 'public');

        if (Storage::disk('public')->exists($filePath)) {
            $file->update([
                'filepath' => $filePath,
                'filesize' => $upload->getSize(),
            ]);

            return redirect()->route('files.show', $file)
                ->with('success', '*File successfully updated');
        } else {
            return redirect()->route('files.edit', $file)
                ->with('error', '*Error updating file');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $path = $file->filepath;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $file->delete();

            return redirect()->route('files.index')
                ->with('success', '*File successfully deleted');
        } else {
            return redirect()->route('files.show', $file)
                ->with('error', '*Error deleting file');
        }
    }

}