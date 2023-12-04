<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; 

class AboutUsController extends Controller
{
    public function index(): View
    {
        return view('about-us.about-us');
    }
}

