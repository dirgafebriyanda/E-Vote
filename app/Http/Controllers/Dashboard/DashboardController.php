<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Voter;

class DashboardController extends Controller
{
    public function index()
    {
       
        $election = Election::withCount('candidate')->get();
        return view('dashboard.index', [
            'title' => 'Menu Utama',
            'elections' => $election,
            
        ]);
    }
}
