<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FHIRExplorerController extends Controller
{
    /**
     * Show FHIR Explorer page
     */
    public function index()
    {
        return view('fhir.explorer');
    }

    /**
     * Proxy FHIR requests (to avoid CORS issues)
     */
    public function proxy(Request $request)
    {
        $endpoint = $request->input('endpoint');
        $baseUrl = url('/api/fhir');
        
        try {
            $response = Http::get($baseUrl . '/' . $endpoint);
            
            return response()->json([
                'success' => true,
                'data' => $response->json(),
                'status' => $response->status()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
