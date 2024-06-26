<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Voter;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function test($electionId)
    {
        // Menggunakan findOrFail untuk mencari Election berdasarkan ID
        $election = Election::findOrFail($electionId);

        // Mengambil data Voter dan Candidate terkait dengan Election
        $voters = $election->voter;
        $candidates = $election->candidate;

        return view('dashboard.vote.vote', [
            'elections' => $election,
            'voters' => $voters,
            'candidates' => $candidates,
            'title' => 'test',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($electionId)
    {
        $election = Election::findOrFail($electionId);
        $voters = $election->voter;
        $candidates = $election->candidate;

        // Misalnya, jika setiap voter hanya memiliki satu objek Vote
        $votes = Vote::whereIn('voter_id', $voters->pluck('id'))->get();

        return view('dashboard.vote.index', [
            'elections' => $election,
            'voters' => $voters,
            'votes' => $votes,
            'candidates' => $candidates,
            'title' => 'Daftar Voter',
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
            'voter_id' => 'required|integer|exists:voters,id',
            'candidate_id' => 'required|integer|exists:candidates,id',
            'election_id' => 'required|integer|exists:elections,id',
        ]);

        // Ambil voter_id dan candidate_id dari request
        $voterId = $request->input('voter_id');
        $candidateId = $request->input('candidate_id');
        $electionId = $request->input('election_id');

        // Cek apakah user_id dari candidate sama dengan user_id dari voter
        $candidateUserId = Candidate::where('id', $candidateId)->value('user_id');
        $voterUserId = Voter::where('id', $voterId)->value('user_id');

        if ($candidateUserId == $voterUserId) {
            return back()->with('error', 'Anda tidak bisa memilih diri sendiri.');
        }

        // Cek apakah user sudah mencapai batas vote
        $vote = vote::where('voter_id', $voterId)->where('election_id', $electionId)->first();
        if ($vote->vote_1 && $vote->vote_2 && $vote->vote_3) {
            return back()->with('error', 'Anda telah mencapai batas vote.');
        }

        if ($vote->vote_1 == $candidateId || $vote->vote_2 == $candidateId || $vote->vote_3 == $candidateId) {
            return back()->with('error', 'Anda telah melakukan vote untuk kandidat ini.');
        }

        // Gunakan transaksi untuk memastikan kedua update dilakukan secara atomik
        DB::transaction(function () use ($vote, $candidateId) {
            // Update field vote di tabel votes
            if (!$vote->vote_1) {
                $vote->vote_1 = $candidateId;
            } elseif (!$vote->vote_2) {
                $vote->vote_2 = $candidateId;
            } elseif (!$vote->vote_3) {
                $vote->vote_3 = $candidateId;
            }
            $vote->save();

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
            'voter_id' => 'required|integer|exists:voters,id',
            'candidate_id' => 'required|integer|exists:candidates,id',
            'election_id' => 'required|integer|exists:elections,id',
        ]);

        // Ambil voter_id dan candidate_id dari request
        $voterId = $request->input('voter_id');
        $candidateId = $request->input('candidate_id');
        $electionId = $request->input('election_id');

        // Cari pemilihan yang sesuai dengan user dan voter_id
        $vote = vote::where('voter_id', $voterId)->where('election_id', $electionId)->first();
        if ($vote->vote_1 != $candidateId && $vote->vote_2 != $candidateId && $vote->vote_3 != $candidateId) {
            return back()->with('error', 'Anda belum melakukan vote untuk kandidat ini.');
        }

        // Jika pemilihan ditemukan
        if ($vote) {
            // Mulai transaksi untuk memastikan kedua update dilakukan secara atomik
            DB::transaction(function () use ($vote, $candidateId) {
                // Batalkan pemilihan untuk candidate yang sesuai
                if ($vote->vote_1 == $candidateId) {
                    $vote->vote_1 = null;
                } elseif ($vote->vote_2 == $candidateId) {
                    $vote->vote_2 = null;
                } elseif ($vote->vote_3 == $candidateId) {
                    $vote->vote_3 = null;
                }
                $vote->save();

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

    // public function testVote(Request $request)
    // {
    //     $user = Auth::user();

    //     // Validasi request jika diperlukan
    //     $request->validate([
    //         'voter_id' => 'required|integer|exists:voters,id',
    //         'candidate_id' => 'required|integer|exists:candidates,id',
    //         'election_id' => 'required|integer|exists:elections,id',
    //     ]);

    //     // Ambil voter_id dan candidate_id dari request
    //     $voterId = $request->input('voter_id');
    //     $candidateId = $request->input('candidate_id');
    //     $electionId = $request->input('election_id');

    //     if ($voterId == $candidateId) {
    //        return back()->with('error', 'Anda tidak bisa vote diri sendiri.');
    //     }

    //     // Cek apakah user sudah mencapai batas vote
    //     $vote = vote::where('voter_id', $voterId)->where('election_id', $electionId)->first();
    //     if ($vote->vote_1 && $vote->vote_2 && $vote->vote_3) {
    //         return back()->with('error', 'Anda telah mencapai batas vote.');
    //     }

    //     if ($vote->vote_1 == $candidateId || $vote->vote_2 == $candidateId || $vote->vote_3 == $candidateId) {
    //         return back()->with('error', 'Anda telah melakukan vote untuk kandidat ini.');
    //     }

    //     // Gunakan transaksi untuk memastikan kedua update dilakukan secara atomik
    //     DB::transaction(function () use ($vote, $candidateId) {
    //         // Update field vote di tabel votes
    //         if (!$vote->vote_1) {
    //             $vote->vote_1 = $candidateId;
    //         } elseif (!$vote->vote_2) {
    //             $vote->vote_2 = $candidateId;
    //         } elseif (!$vote->vote_3) {
    //             $vote->vote_3 = $candidateId;
    //         }
    //         $vote->save();

    //         // Update field total_vote di tabel candidates
    //         $candidate = Candidate::find($candidateId);
    //         $candidate->total_vote += 1;
    //         $candidate->save();
    //     });

    //     return redirect()->back()->with('success', 'Anda berhasil Memilih');
    // }
}
