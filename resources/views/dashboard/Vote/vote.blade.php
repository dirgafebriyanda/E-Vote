@extends('dashboard.layouts.app')
@section('content')
    @extends('dashboard.layouts.app')
@section('content')
    <!-- Page Wrapper -->
    {{-- <style>
        .fixed-size-img {
            width: 200px;
            /* Set the desired width */
            height: 200px;
            /* Set the desired height */
            object-fit: cover;
            /* Ensures the image covers the container */
        }
    </style> --}}
    <!-- Begin Page Content -->

    <div class="container-fluid text-dark">
        @if (session()->has('success'))
            <div class="alert alert-success" id="notif" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" id="notif" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-between">
            <div>
                <h5>Pilihlah sesuai hati nurani anda <span class="text-danger">( Maksimal 3 Pilihan
                        )</span>. </h5>
            </div>
            <div>
                @if (Auth::check())
                    @php
                        $voter = optional(Auth::user())->voter;
                        $usedVotes = $voter ? 3 - ($voter->vote_1 + $voter->vote_2 + $voter->vote_3) : 0;
                        $remainingVotes = $voter ? $voter->vote_limit + $usedVotes : 0;
                    @endphp

                    <p>Kesempatan Memilih <br> Tersisa: {{ $remainingVotes }}</p>
                @endif
            </div>
        </div>


        <div class="row d-flex justify-content-center">
            @foreach ($candidates as $item)
                <div class="col-6 col-sm-3 p-2">
                    <div class="card border-left-info shadow my-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Perolehan Suara
                                        {{ $item->user->name }}
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                {{ $item->total_vote }}
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $item->total_vote }}%"
                                                    aria-valuenow="{{ $item->total_vote }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        @if ($item->user->image)
                            <img id="preview" class="card-img-top img-fluid fixed-size-img"
                                src="{{ asset('storage/' . $item->user->image) }}">
                        @else
                            <img id="preview" class="card-img-top img-fluid fixed-size-img"
                                src="{{ $item->user->jekel == 'Laki-laki' ? asset('img/user/man.png') : ($item->user->jekel == 'Perempuan' ? asset('img/user/woman.png') : asset('img/user/user-default.png')) }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->user->name }}</h5>
                            <p class="card-text">Umur : {{ \Carbon\Carbon::parse($item->user->tgl_lahir)->age }} Tahun
                            </p>
                            <div class="row">
                                <div class="col-12 mb-2 col-sm-6">
                                    <form action="{{ route('cancel.vote') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="voter_id" value="{{ optional($voters)->id }}">
                                        <input type="hidden" name="candidate_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-sm btn-info btn-block"
                                            @if ($voters && ($item->id != $voters->vote_1 && $item->id != $voters->vote_2 && $item->id != $voters->vote_3)) disabled @endif>Batal</button>
                                    </form>
                                </div>
                                <div class="col-12 mb-2 col-sm-6">
                                    <form action="{{ route('vote') }}" method="post" class="d-inline">
                                        @csrf
                                        {{-- <select name="voter_id" id="voter_id">
                                    <option value=""selected></option>
                                    @foreach ($voters as $voter)
                                        <option
                                            value="{{ $voter->id }}"{{ $voter->user->id == auth()->user()->id ? 'selected' : '' }}>
                                            {{ $voter->user->username }}_{{ $voter->id }}</option>
                                    @endforeach
                                </select> --}}
                                        <input type="hidden" name="voter_id" id="voter_id"
                                            value="{{ optional($voters)->id }}">
                                        <input type="hidden" name="candidate_id" id="candidate_id"
                                            value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger w-100"
                                            @if ($voters && ($item->id == $voters->vote_1 || $item->id == $voters->vote_2 || $item->id == $voters->vote_3)) disabled @endif>
                                            Pilih
                                        </button>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            document.querySelectorAll('.select-candidate').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var candidateId = this.getAttribute('data-id');
                    document.getElementById('candidate_id').value = candidateId;
                });
            });
        </script>
    @endsection

@endsection
