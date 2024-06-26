@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <a href="{{ route('dashboard') }}" class="m-0 font-weight-bold"><i
                                class="fas fa-fw fa-tachometer-alt"></i>Dashboard </a>/ Create voter
                    </div>
                    <div class="card-body">
                        <form action="{{ route('voter.store') }}" method="POST">
                            @csrf
                            @method('post')
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Voter :</label>
                                    <select name="user_id" id="" class="form-control">
                                        <option value="" selected disabled>Select voter</option>
                                        @foreach ($users as $item)
                                            @if ($item->role != 'Super admin')
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Election :</label>
                                    <select name="election_id" id="" class="form-control">
                                        <option value="" selected disabled>Select election</option>
                                        @foreach ($elections as $item)
                                            @if ($item->role != 'Super admin')
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark btn-sm my-3 btn-block">Save</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
