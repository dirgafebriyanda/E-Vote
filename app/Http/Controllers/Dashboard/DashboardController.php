<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $election = Election::all();
        $candidate = Candidate::orderBy('id','desc')->get();
        return view('dashboard.index', [
            'title' => 'Menu Utama',
            'candidates' => $candidate,
            'elections' => $election,
           
        ]);
    }
}
