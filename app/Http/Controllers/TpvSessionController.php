<?php

namespace App\Http\Controllers;

use App\Models\TpvSession;
use Illuminate\Http\Request;

class TpvSessionController extends Controller
{
    public function open(Request $request)
    {
        $validated = $request->validate([
            'starting_cash' => 'required|numeric|min:0',
        ]);

        $userId = $request->user()->id;

        $activeSession = TpvSession::where('user_id', $userId)->whereNull('closed_at')->first();

        if ($activeSession) {
            return back()->withErrors(['message' => 'El empleado ya tiene una sesión de TPV abierta']);
        }

        $session = TpvSession::create([
            'user_id' => $userId,
            'opened_at' => now(),
            'starting_cash' => $validated['starting_cash'],
        ]);

        return redirect()->route('tpv.index');
    }

    public function close(Request $request, $id)
    {
        $tpvSession = TpvSession::findOrFail($id);
        if ($tpvSession->closed_at) {
            return back()->withErrors(['message' => 'Esta sesión de TPV ya se encuentra cerrada.']);
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

        return redirect()->route('tpv.index');
    }

    public function index(Request $request) {
        $activeSession = TpvSession::where('user_id', $request->user()->id)->whereNull('closed_at')->first();
        return view('tpv.index', compact('activeSession'));
    }
}