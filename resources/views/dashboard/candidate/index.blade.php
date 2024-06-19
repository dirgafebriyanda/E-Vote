@extends('dashboard.layouts.app')
@section('content')
    <!-- Page Wrapper -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="justify-content-between d-flex">
                    <div>
                        <a href="{{ route('dashboard') }}" class="m-0 font-weight-bold"><i
                                class="fas fa-fw fa-tachometer-alt"></i>Menu Utama </a>/ Daftar Kandidat
                    </div>
                    <div>
                        <a href="#" class="btn btn-sm btn-dark shadow-sm"><i class="fas fa-download fa-sm"></i></a>
                        <a href="{{ route('candidate.create') }}" class="btn btn-sm btn-dark"><i
                                class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Perolehan Suara</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($candidates as $key => $item)
                                <tr>
                                    <td>{{ $candidates->firstItem() + $key }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->total_vote }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6 col-sm-4">
                                                <a href="{{ route('show', $item->id) }}" class="btn btn-dark btn-sm"><i
                                                        class="fas fa-eye"></i></a>
                                            </div>
                                            <div class="col-6 col-sm-4">
                                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal"
                                                    data-target="#deleteModal">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <!-- Delete Modal-->
                                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Konfirmasi</h5>
                                                                <button class="close" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">Pilih Ok jika anda ingin
                                                                menghapus
                                                                kandidat.</div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('candidate.destroy', $item->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Ok</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $candidates->links() }}
            </div>
        </div>

    </div>
@endsection
