<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function notFound()
    {
        return '<h1>Awesome Page Not Found!</h1>';
    }
}
