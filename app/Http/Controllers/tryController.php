<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tryController extends Controller
{
    //
    public function openHomepage() {
        return view('home');
    }
}
