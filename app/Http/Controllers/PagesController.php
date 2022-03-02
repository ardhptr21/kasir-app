<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function toko()
    {
        return view('toko');
    }

    public function produk()
    {
        return view('produk');
    }

    public function kategori()
    {
        return view('kategori');
    }

    public function user()
    {
        return view('user');
    }

    public function users()
    {
        return view('users');
    }
}
