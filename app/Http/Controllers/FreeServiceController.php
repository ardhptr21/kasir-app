<?php

namespace App\Http\Controllers;

use App\Models\FreeService;
use App\Models\Service;
use Illuminate\Http\Request;

class FreeServiceController extends Controller
{
    public function index()
    {
        $free_services = FreeService::with('service')->get();
        $services = Service::all();
        return view('free_services.index', compact('free_services', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'max_point' => 'required|integer',
        ]);

        $freeService = FreeService::create($validated);

        if ($freeService) {
            return back()->with('free-service_success', 'Free Service baru berhasil ditambahkan');
        }

        return back()->with('free-service_error', 'Free Service baru gagal ditambahkan');
    }

    public function destroy(FreeService $freeService)
    {
        if ($freeService->delete()) {
            return back()->with('free-service_success', 'Free Service berhasil dihapus');
        }

        return back()->with('free-service_error', 'Free Service gagal dihapus');
    }
}
