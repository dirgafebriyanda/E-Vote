<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidate = Candidate::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.candidate.index',[
            'title' => 'Candidate',
            'candidates' => $candidate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        return view('dashboard.candidate.create', [
            'title' => 'Create Candidate',
            'users' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user();
        $validated = $request->validate([
            'user_id' => 'required',
        ]);
        $candidate = Candidate::create($validated);

        if ($candidate) {
            return redirect()->route('candidate.index')->with('success', 'Berhasil');
        }
        return redirect()->back()->with('error', 'Gagal');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        Auth::user();
            $candidate = Candidate::find($id);
        $candidate->delete();
        if ($candidate) {
        return redirect()->route('candidate.index')->with('success', 'Candidate berhasil dihapus');
    } else {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }
    }
}
