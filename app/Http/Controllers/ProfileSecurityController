<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileSecurityController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Pagina Sicurezza & Password
    |--------------------------------------------------------------------------
    | Mostra le impostazioni di sicurezza dell’utente:
    | - Cambio password
    | - Autenticazione a due fattori (2FA)
    | - Codici di recupero
    */
    public function index()
    {
        return view('profile.security', [
            'user' => Auth::user(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Aggiorna la password dell’utente
    |--------------------------------------------------------------------------
    */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'La password attuale non è corretta.');
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password aggiornata con successo!');
    }

    /*
    |--------------------------------------------------------------------------
    | Attiva la 2FA
    |--------------------------------------------------------------------------
    */
    public function enable2FA()
    {
        $user = Auth::user();

        if (!$user->two_factor_secret) {
            $user->forceFill([
                'two_factor_secret' => encrypt(app('pragmarx.google2fa')->generateSecretKey()),
                'two_factor_recovery_codes' => encrypt(json_encode($user->recoveryCodes())),
            ])->save();
        }

        return back()->with('success', 'Autenticazione a due fattori attivata!');
    }

    /*
    |--------------------------------------------------------------------------
    | Disattiva la 2FA
    |--------------------------------------------------------------------------
    */
    public function disable2FA()
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        return back()->with('success', 'Autenticazione a due fattori disattivata.');
    }

    /*
    |--------------------------------------------------------------------------
    | Rigenera i codici di recupero
    |--------------------------------------------------------------------------
    */
    public function regenerateRecoveryCodes()
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode($user->recoveryCodes())),
        ])->save();

        return back()->with('success', 'Nuovi codici di recupero generati!');
    }
}
