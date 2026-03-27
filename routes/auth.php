<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('web')->group(function () {
    // Login Routes
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login')->middleware('guest');

    Route::post('/login', function () {
        $credentials = request()->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']])) {
            request()->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['username' => 'Невалидни креденцијали'])->onlyInput('username');
    })->middleware('guest');

    // Logout Route
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout')->middleware('auth');
});
