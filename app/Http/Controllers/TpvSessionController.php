<?php

namespace App\Http\Controllers;

use App\Models\TpvSession;
use Illuminate\Http\Request;

class TpvSessionController extends Controller
{
    public function open(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'starting_cash' => 'required|numeric|min:0',
        ]);

        $activeSession = TpvSession::where('user_id', $validated['user_id'])->whereNull('closed_at')->first();

        if ($activeSession) {
            return response()->json([
                'message' => 'El empleado ya tiene una sesión de TPV abierta.',
                'session' => $activeSession
            ], 422);
        }

        $session = TpvSession::create([
            'user_id' => $validated['user_id'],
            'opened_at' => now(),
            'starting_cash' => $validated['starting_cash'],
        ]);

        return response()->json([
            'message' => 'Sesión de TPV abierta correctamente.',
            'session' => $session
        ], 201);
    }

    public function close(Request $request, TpvSession $tpvSession)
    {
        if ($tpvSession->closed_at) {
            return response()->json([
                'message' => 'Esta sesión de TPV ya se encuentra cerrada.'
            ], 422);
        }

        $validated = $request->validate([
            'closing_cash' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $tpvSession->update([
            'closed_at' => now(),
            'closing_cash' => $validated['closing_cash'],
            'notes' => $validated['notes'] ?? $tpvSession->notes,
        ]);

        return response()->json([
            'message' => 'Sesión de TPV cerrada con éxito.',
            'session' => $tpvSession
        ]);
    }

    public function index(Request $request) {
        $activeSession = TpvSession::whereNull('closed_at')->first();
        return view('tpv.index', compact('activeSession'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'starting_cash' => 'required|numeric|min:0',
        ]);

        TpvSession::create([
            'user_id' => $request->user()->id,
            'starting_cash' => $request->starting_cash,
            'opened_at' => now(),
        ]);

        return redirect()->route('tpv.index');
    }
}