<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FHIRAuth
{
    /**
     * Handle FHIR API authentication
     * 
     * For production, you should implement proper OAuth2 or API Key auth
     */
    public function handle(Request $request, Closure $next)
    {
        // Option 1: API Key Authentication (Simple)
        $apiKey = $request->header('X-API-Key');
        $validKeys = ['your-secret-api-key-here']; // Store in .env
        
        if (!in_array($apiKey, $validKeys)) {
            return response()->json([
                'resourceType' => 'OperationOutcome',
                'issue' => [
                    [
                        'severity' => 'error',
                        'code' => 'security',
                        'diagnostics' => 'Invalid or missing API key'
                    ]
                ]
            ], 401);
        }

        // Option 2: Token-based (Uncomment if you want to use)
        // $token = $request->bearerToken();
        // if (!$token || !$this->validateToken($token)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        return $next($request);
    }

    // private function validateToken($token)
    // {
    //     // Implement your token validation logic
    //     return true;
    // }
}
