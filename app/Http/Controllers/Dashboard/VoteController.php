<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {
    $user = User::where('username', $username)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    // Ambil election yang terkait dengan user
    $election = $user->election()->orderBy('id', 'desc')->first();
        $candidates = Candidate::orderBy('id', 'desc')->paginate(5);

        return view('dashboard.vote.index', [
            'title' => 'Tentukan Pilihan',
            'elections' => $election,
            'candidates' => $candidates,
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
        //
    }

   public function vote(Request $request)
{
    $user = Auth::user();
    
    // Validasi request jika diperlukan
    $request->validate([
        'election_id' => 'required|integer|exists:elections,id',
        'candidate_id' => 'required|integer|exists:candidates,id',
    ]);

    // Ambil election_id dan candidate_id dari request
    $electionId = $request->input('election_id');
    $candidateId = $request->input('candidate_id');

    
    // Cek apakah user sudah mencapai batas vote
    $election = Election::where('user_id', $user->id)->first();
    if ($election->vote_1 && $election->vote_2 && $election->vote_3) {
        return back()->with('error', 'Anda telah mencapai batas vote.');
    }
        if ($election->vote_1 == $candidateId || $election->vote_2 == $candidateId || $election->vote_3 == $candidateId) {
        return back()->with('error', 'Anda telah melakukan vote untuk kandidat ini.');
    }

    // Gunakan transaksi untuk memastikan kedua update dilakukan secara atomik
    DB::transaction(function () use ($election, $candidateId) {
        // Update field vote di tabel elections
        if (!$election->vote_1) {
            $election->vote_1 = $candidateId;
        } elseif (!$election->vote_2) {
            $election->vote_2 = $candidateId;
        } elseif (!$election->vote_3) {
            $election->vote_3 = $candidateId;
        }
        $election->save();

        // Update field total_vote di tabel candidates
        $candidate = Candidate::find($candidateId);
        $candidate->total_vote += 1;
        $candidate->save();
    });

    return redirect()->back()->with('success', 'Anda berhasil Memilih');
}

public function cancelVote(Request $request)
{
    $user = Auth::user();

    // Validasi request jika diperlukan
    $request->validate([
        'election_id' => 'required|integer|exists:elections,id',
        'candidate_id' => 'required|integer|exists:candidates,id',
    ]);

    // Ambil election_id dan candidate_id dari request
    $electionId = $request->input('election_id');
    $candidateId = $request->input('candidate_id');

    // Cari pemilihan yang sesuai dengan user dan election_id
    $election = Election::where('user_id', $user->id)
        ->where('id', $electionId)
        ->first();
    if ($election->vote_1 != $candidateId && $election->vote_2 != $candidateId && $election->vote_3 != $candidateId) {
    return back()->with('error', 'Anda belum melakukan vote untuk kandidat ini.');
}

    // Jika pemilihan ditemukan
    if ($election) {
        // Mulai transaksi untuk memastikan kedua update dilakukan secara atomik
        DB::transaction(function () use ($election, $candidateId) {
            // Batalkan pemilihan untuk candidate yang sesuai
            if ($election->vote_1 == $candidateId) {
                $election->vote_1 = null;
            } elseif ($election->vote_2 == $candidateId) {
                $election->vote_2 = null;
            } elseif ($election->vote_3 == $candidateId) {
                $election->vote_3 = null;
            }
            $election->save();

            // Kurangi total_vote di tabel candidates
            $candidate = Candidate::find($candidateId);
            if ($candidate) {
                $candidate->total_vote -= 1;
                $candidate->save();
            }
        });

        return redirect()->back()->with('success', 'Pemilihan berhasil dibatalkan.');
    }

    return redirect()->back()->with('error', 'Pemilihan tidak ditemukan.');
}

}
