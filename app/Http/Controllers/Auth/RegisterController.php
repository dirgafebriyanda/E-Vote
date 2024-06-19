<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Register
    public function index()
    {
        if (Auth::check()) {
            // If authenticated, redirect to the dashboard or any other page
            return redirect()->redirect('dashboard');
        }
        return view('auth.register', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255|confirmed'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        Auth::login($user);
        if ($user) {
            return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil');
        }
        return redirect()->back()->with('error', 'Pendaftaran gagal');
    }
}
