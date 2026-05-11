<?php

namespace App\Http\Controllers;

use App\Models\Restro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RestroController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Restro $restro)
    {
        //
    }

    public function edit(Restro $restro)
    {
        //
    }

    public function update(Request $request, Restro $restro)
    {
        $restro->update($request->all());
        return redirect()->route('main');
    }

    /**
     * Semak password untuk operasi counter (padam resit / diskaun).
     */
    public function verifyCredential(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $restro = Restro::first();
        if (! $restro || ! $restro->cred_password || ! Hash::check($request->password, $restro->cred_password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata laluan tidak sah.',
            ], 422);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Tukar password credential (wajib semak password lama; password baru ikut syarat kuat).
     */
    public function saveCredential(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'same:new_password_confirmation',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $restro = Restro::first();
        if (! $restro || ! $restro->cred_password || ! Hash::check($validated['old_password'], $restro->cred_password)) {
            throw ValidationException::withMessages([
                'old_password' => ['Password lama tidak sah.'],
            ]);
        }

        $restro->cred_password = Hash::make($validated['new_password']);
        $restro->save();

        return response()->json([
            'success' => true,
            'message' => 'Password credential telah dikemas kini.',
        ]);
    }

    public function destroy(Restro $restro)
    {
        //
    }
}
