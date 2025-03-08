<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            throw $e; // Tetap melempar error agar validasi tetap berjalan normal
        }
    
        $request->session()->regenerate();
    
        $user = Auth::user(); // Ambil user yang sedang login
    
        // Redirect berdasarkan role user
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        } elseif ($user->role === 'karyawan') {
            return redirect()->route('karyawan.index');
        }
    
        return redirect()->intended(route('dashboard')); // Default jika role tidak dikenali
    }
    
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
