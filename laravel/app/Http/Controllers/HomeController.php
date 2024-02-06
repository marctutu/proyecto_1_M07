<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('home');
    }

    public function language($locale) 
    {  
        $default = config('app.locale', 'en');
        $locales = config('app.available_locales', ['en' => 'English']);
        
        if (!array_key_exists($locale, $locales)) {
            Log::error("Locale '{$locale}' not exists");
            abort(400);
        }

        // Session storage
        $current = Session::get('locale', $default);
        Log::debug("Change locale '{$current}' to '{$locale}'");
        Session::put('locale', $locale);
        
        // Set locale
        App::setLocale($locale);

        // Go to previous page
        return redirect()->back();
    }
}
