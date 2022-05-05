<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Return the about page view
     * 
     * @return string
     * 
     */
    public function about()
    {
        return view('app/about');
    }
}
