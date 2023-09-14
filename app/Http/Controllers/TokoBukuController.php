<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class TokoBukuController extends Controller
{
    public function index(){
        $data_buku = Buku::all();

        return view('index', compact('data_buku'));
    }
}
