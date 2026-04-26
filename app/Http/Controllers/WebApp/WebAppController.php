<?php

namespace App\Http\Controllers\WebApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebAppController extends Controller
{
    public function index()
    {
        return view('webapp.index');
    }
}
