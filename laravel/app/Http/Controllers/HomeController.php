<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class HomeController extends Controller
{
    public function index()
{
    $imagen = File::findOrFail(4);
    return view('home', compact('imagen'));
}

}
