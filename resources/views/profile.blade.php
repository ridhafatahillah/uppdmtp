<!DOCTYPE html>
<html lang="en">

<x-head>
    <x-slot:judul>
        {{ $judul }}
    </x-slot:judul>
</x-head>


<body>
    <!-- ======= Header ======= -->
    <x-header></x-header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <x-sidebar></x-sidebar>
    <!-- End Sidebar -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>

        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <h2>{{ auth()->user()->nama_kasir }}</h2>
                            <h3>{{ auth()->user()->nama }}</h3>

                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item ">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Ganti Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="{{ url('profile/edit') }}" method="POST">
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        {{-- <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div> --}}
                                        @if (session('error'))
                                            <script>
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    html: '{{ session('error') }}',
                                                });
                                            </script>
                                        @endif


                                        @if (session('success'))
                                            <script>
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Berhasil',
                                                    text: '{{ session('success') }}',
                                                });
                                            </script>
                                        @endif
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="nama_kasir" class="col-md-4 col-lg-3 col-form-label">Nama
                                                Kasir</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nama_kasir" type="text" class="form-control"
                                                    id="nama_kasir" value="{{ auth()->user()->nama_kasir }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-lg-3 col-form-label">Masukkan
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="password" value="">
                                            </div>
                                        </div>


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    @if ($errors->any())
                                        <script>
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                html: '{!! implode('<br>', $errors->all()) !!}',
                                            });
                                        </script>
                                    @endif

                                    <form action="{{ url('profile/change-password') }}" method="POST">
                                        @csrf
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <input type="text" name="id" value="{{ auth()->user()->id }}" hidden>
                                        <div class="row mb-3">
                                            <label for="currentPassword"
                                                class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password
                                                Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newpassword" type="password" class="form-control"
                                                    id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword"
                                                class="col-md-4 col-lg-3 col-form-label">Konfirmasi Password
                                                Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="renewpassword" type="password" class="form-control"
                                                    id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
</body>
<script src="assets/js/main.js"></script>
<!-- Tambahkan di bagian <head> atau di bagian bawah sebelum </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
