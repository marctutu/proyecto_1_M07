<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
     
         $posts = Post::with('author')
                      ->when($search, function ($query) use ($search) {
                          return $query->where('body', 'LIKE', "%{$search}%");
                      })
                      ->paginate(5);
     
         // Pasar los posts y el término de búsqueda a la vista
         return view('home', compact('posts', 'search'));
}
}