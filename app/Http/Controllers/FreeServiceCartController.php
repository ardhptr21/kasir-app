<?php

namespace App\Http\Controllers;

use App\Models\FreeServiceCart;
use Illuminate\Http\Request;

class FreeServiceCartController extends Controller
{
    public function store(Request $request,)
    {
        $validated = $request->validate([
            'free_service_id' => 'required|exists:free_services,id',
        ]);

        FreeServiceCart::create($validated);

        return back();
    }

    public function destroy(FreeServiceCart $freeServiceCart)
    {
        $freeServiceCart->delete();
        return back();
    }
}
