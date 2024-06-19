<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index($username)
    {
        $user = Auth::user();
        // Cari user berdasarkan username
        $user = User::where('username', $username)->firstOrFail();
        if (Auth::user()->id !== $user->id) {
            return redirect()->back();
        }
        return view('dashboard.user.profile', [
            'title' => 'Profile',
            'users' => $user
        ]);
    }

    public function update(Request $request, $username)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'username' => 'required|max:250',
            'name' => 'required|max:250',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'jekel' => 'required|max:9',
            'tgl_lahir' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('username', $username)->firstOrFail();

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('user');
        }
        $user->update($validatedData);

        if ($user) {
            return redirect()->route('profile', ['username' => $user->username]);
        }
        return redirect()->back()->with('error', 'Gagal');
    }

    public function delete($username)
    {
        $user = Auth::user();
        $user = User::where('username', $username)->firstOrFail();
        $user->delete();
        if ($user) {
        return redirect()->back();
    } else {
        return redirect()->back();
    }
    }
}