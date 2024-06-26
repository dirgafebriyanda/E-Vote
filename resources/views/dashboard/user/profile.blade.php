@extends('dashboard.layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                @auth
                    <h6 class="m-0 font-weight-bold text-dark"><a href="{{ route('dashboard') }}" id="open" readonly> <i
                                class="fas fa-fw fa-tachometer-alt"></i>
                            Dashboard</a> / Profile
                    </h6>
                @endauth
            </div>
            @auth
                @if (auth()->user()->id == $users->id)
                    <div class="dropdown mb-4">
                        <a href="#" class="tex-decoration-none text-dark" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#gantipassword">
                                <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                Change Password
                            </a>
                            @auth
                                @if (auth()->user()->role != 'Super admin')
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#hapusAkun">
                                        <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Delete acount
                                    </a>
                                @endif
                            @endauth

                        </div>
                    </div>
                @endif
            @endauth

        </div>
        <div class="card-body">
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
            <form action="{{ route('update', $users->username) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3 border-right">
                        @auth
                            @if (auth()->user()->id == $users->id)
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" value="" id="editcheck">
                                    <label class="form-check-label text-dark" for="editcheck">
                                        Edit Profile
                                    </label>
                                </div>
                            @endif
                        @endauth

                        <div class="d-flex mt-4 flex-column align-items-center text-center">
                            @if ($users->image)
                                <img id="preview" class="rounded-circle" width="150px"
                                    src="{{ asset('storage/' . $users->image) }}">
                            @else
                                <img id="preview" class="rounded-circle" width="150px"
                                    src="{{ $users->gender == 'Man' ? asset('img/user/man.png') : ($users->gender == 'Woman' ? asset('img/user/woman.png') : asset('img/user/user-default.png')) }}">
                            @endif
                            <span class="font-weight-bold">{{ $users->name }}</span>
                            <span class="text-black-50">{{ $users->email }}</span>
                        </div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Image<sup class="text-danger fw-bold">*</sup> :</label>
                                    <input type="hidden" name="oldImage" value="{{ $users->image }}">
                                    <div class="custom-file">
                                        <input id="image" type="file"
                                            class="custom-file-input @error('image') is-invalid @enderror" name="image"
                                            onchange="previewImage(event)" disabled>
                                        <label class="custom-file-label" for="image" id="fileLabel">Select file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Username<sup class="text-danger fw-bold">*</sup> :</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        placeholder="Username" name="username"
                                        value="{{ old('username', $users->username) }}" id="username" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Name<sup class="text-danger fw-bold">*</sup> :</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="nama lengkap" name="name" value="{{ old('name', $users->name) }}"
                                        id="name" readonly>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Gender<sup class="text-danger fw-bold">*</sup>
                                        :</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('gender') is-invalid @enderror"
                                            type="radio" name="gender" id="laki" value="Man"
                                            {{ $users->gender == 'Man' ? 'checked' : '' }} disabled>
                                        <label class="form-check-label" for="inlineRadio1">Man</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('gender') is-invalid @enderror"
                                            type="radio" name="gender" id="woman" value="woman"
                                            {{ $users->gender == 'woman' ? 'checked' : '' }} disabled>
                                        <label class="form-check-label" for="inlineRadio2">Women</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Date of birth<sup class="text-danger fw-bold">*</sup> :</label>
                                    <input type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        placeholder="Date of birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $users->date_of_birth) }}" id="date_of_birth"
                                        readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Email<sup class="text-danger fw-bold">*</sup> :</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" value="{{ old('email', $users->email) }}"
                                        id="email" readonly>
                                </div>
                            </div>

                            {{-- <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Alamat :</label>
                                    <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat"
                                        name="alamat" id="alamat" readonly>{{ old('alamat', $users->alamat) }}</textarea>
                                </div>
                            </div> --}}
                            @auth
                                @if (auth()->user()->id == $users->id)
                                    <div class="mt-4">
                                        <button class="btn btn-dark w-100 disabled" id="tombolPerbarui"
                                            type="submit">Update</button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="modal fade" id="gantipassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ubah-password', $users->id) }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user" placeholder="Password"
                                    name="password" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                    placeholder="Repeat Password" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Ganti</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Delete Modal-->
    <div class="modal fade" id="hapusAkun" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Konfirmasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih Ok jika anda ingin
                    menghapus
                    akun Anda.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('hapus.akun', auth()->user()->username) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">Ok</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editcheck = document.getElementById('editcheck');
        const name = document.getElementById('name');
        const driver_license_number = document.getElementById('username');
        const date_of_birth = document.getElementById('date_of_birth');
        const email = document.getElementById('email');
        // const alamat = document.getElementById('alamat');
        const tombolPerbarui = document.getElementById('tombolPerbarui');
        const laki = document.getElementById('laki');
        const woman = document.getElementById('woman');
        const image = document.getElementById('image');

        editcheck.addEventListener('change', function() {
            name.readOnly = !this.checked;
            driver_license_number.readOnly = !this.checked;
            date_of_birth.readOnly = !this.checked;
            email.readOnly = !this.checked;
            // alamat.readOnly = !this.checked;
            laki.disabled = !this.checked;
            woman.disabled = !this.checked;
            image.disabled = !this.checked;

            if (editcheck.checked) {
                tombolPerbarui.classList.remove('disabled');
            } else {
                tombolPerbarui.classList.add('disabled');
            }
        });
    </script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);

            // Menampilkan nama file
            var input = event.target;
            var fileName = input.files[0].name;
            var label = document.getElementById('fileLabel');
            label.innerHTML = fileName;
        }
    </script>
@endsection
