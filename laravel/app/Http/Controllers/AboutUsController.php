<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AboutUsController extends Controller
{
    public function index(): View
    {
        // Datos inventados para los miembros del equipo
        $teamMembers = [
            [
                'name' => 'Marc Tutusaus',
                'role' => 'CEO',
                'hobby' => 'Mountain Biking',
                'image' => '/home/marc/Escritorio/M06_M07_projecte/proyecto_1_M07/laravel/public/img/perosona1.jpg', // Asegúrate de reemplazar esto con la ruta real de la imagen
                'hobbyImage' => '/public/img/hobby1.jpg', // Asegúrate de reemplazar esto con la ruta real de la imagen de hobby
            ],
            [
                'name' => 'Axel Vidal',
                'role' => 'Project Manager',
                'hobby' => 'Reading Historical Novels',
                'image' => '/home/marc/Escritorio/M06_M07_projecte/proyecto_1_M07/laravel/public/img/perosona2.jpg', // Ruta de la imagen de Helena
                'hobbyImage' => '/public/img/hobby2.jpg', // Ruta de la imagen del hobby de Helena
            ],
        ];

        // Pasar los datos de los miembros del equipo a la vista
        return view('about-us.about-us', compact('teamMembers'));
    }
}
