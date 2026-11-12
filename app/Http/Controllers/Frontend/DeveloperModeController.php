<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeveloperModeController extends Controller
{
    public function activar(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:255',
        ]);

        $passwordHash = config('developer.password_hash');

        if (!$passwordHash || !Hash::check($request->password, $passwordHash)) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta.'
            ], 403);
        }

        $duration = (int) config('developer.duration', 60);

        $request->session()->put(
            'developer_mode_until',
            now()->addMinutes($duration)->timestamp
        );

        return response()->json([
            'success' => true,
            'message' => 'Modo desarrollador activado.',
            'duration' => $duration
        ]);
    }

    public function desactivar(Request $request)
    {
        $request->session()->forget('developer_mode_until');

        return response()->json([
            'success' => true,
            'message' => 'Modo desarrollador desactivado.'
        ]);
    }
}
