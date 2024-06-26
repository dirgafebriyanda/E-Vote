@extends('dashboard.layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <a href="{{ route('dashboard') }}" class="m-0 font-weight-bold"><i
                                class="fas fa-fw fa-tachometer-alt"></i>Dashboard </a>/ Create election
                    </div>
                    <div class="card-body">
                        <form action="{{ route('election.store') }}" method="POST">
                            @csrf
                            @method('post')
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Name election :</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Start date :</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">End date :</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark btn-sm my-3 btn-block">Save</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endsection
