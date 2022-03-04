<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function produk()
    {
        return view('produk');
    }

    public function user()
    {
        return view('user');
    }
}
