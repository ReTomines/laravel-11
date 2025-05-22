<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vereador;

class VideowallController extends Controller
{
    public function index()
    {
        return view('videowall.index');
    }

}
