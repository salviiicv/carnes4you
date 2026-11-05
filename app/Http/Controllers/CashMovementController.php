<?php

namespace App\Http\Controllers;

use App\Models\CashMovement;
use App\Models\TpvSession;
use Illuminate\Http\Request;

class CashMovementController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tpv_session_id' => 'required|exists:tpv_sessions,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
        ]);

        $session = TpvSession::findOrFail($validated['tpv_session_id']);

        if ($session->closed_at) {
            return response()->json([
                'message' => 'No se pueden registrar movimientos en una sesión de TPV ya cerrada.'
            ], 422);
        }

        $movement = CashMovement::create([
            'tpv_session_id' => $validated['tpv_session_id'],
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'reason' => $validated['reason'],
        ]);

        return response()->json([
            'message' => 'Movimiento de efectivo registrado correctamente.',
            'movement' => $movement
        ], 201);
    }
}