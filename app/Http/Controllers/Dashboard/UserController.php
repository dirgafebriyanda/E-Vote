<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user = User::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.user.index', [
            'title' => 'List User',
            'users' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $user = User::find($id);
        return view('dashboard.user.show', [
            'title' => 'View User',
            'users' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user = User::find($id);
        if ($user) {
            // Hapus gambar mobil dari storage
            $images = explode(',', $user->image);
            foreach ($images as $image) {
                $path = 'storage/user/' . $image;
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Hapus entri mobil dari database
            $user->delete();

            return redirect()
                ->route('user')
                ->with('success', 'Data ' . $user->name . ' berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function role(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role' => 'required|max:5',
        ]);

        $user = User::find($id);

        $user->update($validatedData);

        if ($user) {
            return redirect()->back()->with('error', 'Berhasil');
        }
        return redirect()->back()->with('error', 'Gagal');
    }
}
