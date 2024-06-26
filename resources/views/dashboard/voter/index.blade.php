@extends('dashboard.layouts.app')
@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="justify-content-between d-flex">
                        <div>
                            <a href="{{ route('dashboard') }}" class="m-0 font-weight-bold"><i
                                    class="fas fa-fw fa-tachometer-alt"></i> Dashboard </a>/ Voters list
                        </div>
                        <div>
                            <a href="#" class="btn btn-sm btn-info shadow-sm"><i class="fas fa-download fa-sm"></i></a>
                            <a href="{{ route('voter.create') }}" class="btn btn-sm btn-danger"><i
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
                                    <th>Name voter</th>
                                    <th>Election</th>
                                    <th>Vote 1</th>
                                    <th>Vote 2</th>
                                    <th>Vote 3</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voters as $key => $item)
                                    <tr>
                                        <td>{{ $voters->firstItem() + $key }}</td>
                                        <td>{{ $item->user->username }}</td>
                                        <td>{{ $item->election->name }}</td>
                                        <td>
                                            @foreach ($item->vote as $vote)
                                                {{ $vote->vote_1 ? 'Already' : 'Not yet' }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($item->vote as $vote)
                                                {{ $vote->vote_2 ? 'Already' : 'Not yet' }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($item->vote as $vote)
                                                {{ $vote->vote_3 ? 'Already' : 'Not yet' }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="row">
                                                {{-- <div class="col-6 col-sm-4">
                                                    <a href="{{ route('voter.show', $item->id) }}"
                                                        class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                </div> --}}
                                                <div class="col-6 col-sm-4">
                                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal"
                                                        data-target="#deleteVoterModal{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <!-- Delete Modal-->
                                                    <div class="modal fade" id="deleteVoterModal{{ $item->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Confirmation</h5>
                                                                    <button class="close" type="button"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">Select '<span
                                                                        class="text-danger">OK</span>' if you want to delete
                                                                    the data {{ $item->name }}.</div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-info" type="button"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('voter.destroy', $item->id) }}"
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
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
@endsection
