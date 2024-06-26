<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\Voter;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user();
           $voter = Voter::with('vote', 'user', 'election')
                   ->orderBy('id', 'desc')
                   ->paginate(5);
        return view('dashboard.voter.index', [
            'title' => 'Daftar Pemilih',
            'voters' => $voter,
          
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
         $user = User::orderBy('id','desc')->get();
         $election = Election::all();
        return view('dashboard.voter.create', [
            'title' => 'Create Candidate',
            'users' => $user,
            'elections' => $election
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
    $user = Auth::user();

    $validated = $request->validate([
        'user_id' => 'required',
        'election_id' => 'required',
    ]);

    // Create Voter record
    $voter = Voter::create([
        'user_id' => $validated['user_id'],
        'election_id' => $validated['election_id'],
    ]);

    // Check if Voter creation succeeded
    if (!$voter) {
        return redirect()->back()->with('error', 'Gagal membuat voter');
    }

    // Create Vote record associated with the Voter
    $vote = Vote::create([
        'voter_id' => $voter->id,
        'election_id' => $validated['election_id'],
        // Assuming you have other fields to store in Vote table
        // Add them here as needed
    ]);

    // Check if Vote creation succeeded
    if ($vote) {
        return redirect()->route('voter.index')->with('success', 'Berhasil');
    } else {
        // If Vote creation fails, delete the previously created Voter (optional)
        $voter->delete();
        return redirect()->back()->with('error', 'Gagal membuat vote');
    }
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
        $user = Auth::user();
         $voter = voter::find($id);

        $voter->delete();
        if ($voter) {
        return redirect()->route('voter.index')->with('success', 'Berhasil');
    } else {
        return redirect()->back()->with('error', 'Gagal');
    }
    }
}

