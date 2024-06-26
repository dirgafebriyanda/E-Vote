@extends('dashboard.layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h1 class="text-xxl text-center text-dark">ELECTION LIST {{ date('Y') }}</h1>
        <div class="row">
            <!-- Election list -->
            @foreach ($elections as $item)
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-decoration-none" href="{{ route('vote.index', $item->id) }}">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="text-lg font-weight-bold text-dark text-uppercase mb-1">
                                            {{ $item->name }}</div>
                                        <div class="text-md text-dark font-weight-bold"> Total candidates :
                                            {{ $item->candidate_count }}
                                            <div class="text-xs text-info font-weight-bold">Start : {{ $item->start_date }}
                                            </div>
                                            <div class="text-xs text-danger font-weight-bold"> End : {{ $item->end_date }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
