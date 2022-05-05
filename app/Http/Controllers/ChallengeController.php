<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;

class ChallengeController extends Controller
{   
    /**
     * Return the challenge page view
     * 
     * @return string
     * 
     */
    public function challenge()
    {   
        return view('app.challenge');
    }
}
