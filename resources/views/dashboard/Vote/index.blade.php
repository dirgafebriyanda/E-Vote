@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid text-dark">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="h3 text-md text-center">{{ $elections->name }} ELECTION CANDIDATE</div>
        <div class="h5 text-md text-center"><span class="text-info">Start : {{ $elections->start_date }}</span> -<span
                class="text-danger"> End : {{ $elections->end_date }}</span></div>
        @auth
            @foreach ($voters as $voter)
                @if (auth()->user()->id == $voter->user_id)
                    <div class="d-flex justify-content-between">
                        <h6 class="text-md">Choose according to your conscience <span class="text-danger">(Maximum 3
                                Options)</span>.</h6>
                    </div>
                    <div class="row d-flex justify-content-center">
                        @foreach ($candidates as $candidate)
                            <div class="col-6 col-sm-3 p-2">
                                <div class="card">
                                    <img class="card-img-top p-3 img-fluid fixed-size-img"
                                        src="{{ $candidate->user->image ? asset('storage/' . $candidate->user->image) : ($candidate->user->gender == 'Man' ? asset('img/user/man.png') : ($candidate->user->gender == 'Woman' ? asset('img/user/woman.png') : asset('img/user/user-default.png'))) }}"
                                        alt="Gambar Kandidat">
                                    <div class="card-body">
                                        <div class="h6 text-md card-title">{{ $candidate->user->name }}</div>
                                        <div class="card-text text-md">Age :
                                            {{ \Carbon\Carbon::parse($candidate->user->date_of_birth)->age }}
                                            Years
                                        </div>
                                        <div class="row no-gutters align-items-center my-2">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Vote
                                                    Acquisition</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-2 font-weight-bold text-gray-800">
                                                            {{ $candidate->total_vote }}</div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="progress progress-sm mr-2">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                style="width: {{ $candidate->total_vote }}%"
                                                                aria-valuenow="{{ $candidate->total_vote }}" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                @php
                                                    // Cari Vote terkait dengan voter saat ini
                                                    $voterVote = $votes->where('voter_id', $voter->id)->first();
                                                @endphp
                                                <form action="{{ route('cancel.vote') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="election_id" value="{{ $elections->id }}">
                                                    <input type="hidden" name="voter_id" value="{{ $voter->id }}">
                                                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                                    <button type="submit" class="btn btn-sm btn-info btn-block"
                                                        @if (
                                                            !$voterVote ||
                                                                ($candidate->id != $voterVote->vote_1 &&
                                                                    $candidate->id != $voterVote->vote_2 &&
                                                                    $candidate->id != $voterVote->vote_3)) style="display: none;" @endif>
                                                        Cancel
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-12">
                                                <form action="{{ route('vote.store') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="election_id" value="{{ $elections->id }}">
                                                    <input type="hidden" name="voter_id" value="{{ $voter->id }}">
                                                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger btn-block"
                                                        {{ $candidate->user_id == auth()->user()->id ? 'disabled' : '' }}
                                                        @if (
                                                            $voterVote &&
                                                                ($candidate->id == $voterVote->vote_1 ||
                                                                    $candidate->id == $voterVote->vote_2 ||
                                                                    $candidate->id == $voterVote->vote_3)) style="display: none;" @endif
                                                        {{ $voterVote->vote_1 && $voterVote->vote_2 && $voterVote->vote_3 ? 'disabled' : '' }}>
                                                        Vote
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        @endauth
    </div>
@endsection
