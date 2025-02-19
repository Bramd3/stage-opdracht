<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home'); // Laadt de view 'home.php' uit de Views-map
    }
}
