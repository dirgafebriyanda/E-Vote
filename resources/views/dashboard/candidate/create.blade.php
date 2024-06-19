@extends('dashboard.layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <a href="{{ route('dashboard') }}" class="m-0 font-weight-bold"><i
                                class="fas fa-fw fa-tachometer-alt"></i>Menu Utama </a>/ Tambah Kandidat
                    </div>
                    <div class="card-body">
                        <form action="{{ route('candidate.store') }}" method="POST">
                            @csrf
                            @method('post')
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Nama :</label>
                                    <select name="user_id" id="" class="form-control">
                                        <option value="" selected disabled>Pilih Kandidat</option>
                                        @foreach ($users as $item)
                                            @if ($item->role != 'Super admin')
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark btn-sm my-3 btn-block">Simpan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endsection
