@extends('dashboard.layouts.app')

@section('content')
    <section style="background-color: #f4f5f7;">
        <div class="container py-4 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 bg-dark text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                alt="Avatar" class="img-fluid my-5" style="width: 80px;" /> --}}
                                @if ($users->image)
                                    <img id="preview" class="rounded-circle img-fluid my-5" width="80px"
                                        src="{{ asset('storage/' . $users->image) }}">
                                @else
                                    <img id="preview" class="rounded-circle img-fluid my-5" width="80px"
                                        src="{{ $users->gender == 'Man' ? asset('img/user/man.png') : ($users->gender == 'Woman' ? asset('img/user/woman.png') : asset('img/user/user-default.png')) }}">
                                @endif
                                <h6>{{ $users->username }}</h6>
                                <p>Web Designer</p>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12">
                                            <h6>Name :</h6>
                                            <p class="text-muted">{{ $users->name }}</p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-12">
                                            <h6>Email :</h6>
                                            <p class="text-muted">{{ $users->email }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('role', $users->id) }}" method="post">
                                        @csrf
                                        <div class="row pt-1">
                                            <div class="col-12">
                                                <h6>Role :</h6>
                                                <select name="role" id="role" class="form-control"
                                                    {{ $users->role == 'Super admin' ? 'disabled' : '' }}>
                                                    <option value="" disabled selected>Pilih Peran</option>
                                                    <option value="Admin" {{ $users->role == 'Admin' ? 'selected' : '' }}>
                                                        Admin</option>
                                                    <option value="User" {{ $users->role == 'User' ? 'selected' : '' }}>
                                                        User
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-dark my-3 btn-block">Save</button>
                                    </form>
                                    {{-- <h6>Projects</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Recent</h6>
                                            <p class="text-muted">Lorem ipsum</p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Most Viewed</h6>
                                            <p class="text-muted">Dolor sit amet</p>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex justify-content-start">
                                        {{-- <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                  <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                  <a href="#!"><i class="fab fa-instagram fa-lg"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
