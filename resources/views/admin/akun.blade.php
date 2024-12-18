<x-head>
    <x-slot:judul>
        Kelola Akun | SIPSKD
    </x-slot:judul>
</x-head>

<body>

    <x-header></x-header>
    {{-- buat x-sidebar dan kirimkan $users --}}
    <x-sidebar :users="$users" />
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Akun</h1>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Akun
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $all }} Akun</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card pajak-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Kasir
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $kasirCount }} Kasir</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card rusak-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Admin
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $adminCount }} Admin</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <h5 class="card-title
                                        ">Akun</h5>
                                        </div>
                                        <div class="col-4 d-flex justify-content-center align-items-center mt-2 ">
                                        </div>
                                        <div class="col-4 d-flex justify-content-end align-items-center ">
                                            <a class="float-end text-warning ms-2 fs-4" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modaltambah"><i
                                                    class="bi bi-plus-square-fill"></i></a>
                                        </div>
                                        <table class="table table-borderless datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col"> Username</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Nama Kasir</th>
                                                    {{-- <th scope="col">Role</th> --}}
                                                    <th scope="col" class="text-center">Password</th>
                                                    <th scope="col" class="text-center">Edit</th>
                                                    <th scope="col" class="text-center">Hapus</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center" id="tableBody">
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->nama }}</td>
                                                        <td>{{ $user->nama_kasir }}</td>
                                                        {{-- <td>{{ $user->role == 0 ? 'Kasir' : 'Admin' }}</td> --}}
                                                        <td class="text-center">
                                                            <a href="#" class="change-password-link"
                                                                data-user-id="{{ $user->id }}"
                                                                data-user-name="{{ $user->nama }}">
                                                                <i class="bi bi-key"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="/" type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalEdit"
                                                                data-user-id="{{ $user->id }}"
                                                                data-user-nama="{{ $user->nama }}"
                                                                data-user-username="{{ $user->name }}"
                                                                data-user-namakasir="{{ $user->nama_kasir }}"
                                                                data-user-role="{{ $user->role }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a id="delete"
                                                                href="{{ url('admin/akun/hapus/' . $user->id) }}">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel4"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel2">Tambah Akun</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <div class="container-fluid" id="alert-container"></div>
                                                <form action="{{ url('admin/akun/tambah') }}" method="post"
                                                    id="formNotice">
                                                    @csrf
                                                    <div class="mb-3 row align-items-end">
                                                        <div class="col-12">
                                                            <label for="username" class="form-label">Username</label>
                                                            <input type="text" class="form-control" id="username"
                                                                name="username" value="">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nama" class="form-label">Nama Akun</label>
                                                        <input type="text" class="form-control" id="nama"
                                                            name="nama" value="">
                                                    </div>
                                                    <div class="mb-3" id="nama-kasir-container">
                                                        <label for="nama_kasir" class="form-label">Nama Kasir</label>
                                                        <input type="text" class="form-control" id="nama_kasir"
                                                            name="nama_kasir" value="">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password">
                                                    </div>
                                                    {{-- <div class="mb-3">
                                                        <label for="role" class="form-label">Role</label>
                                                        <select class="form-select" id="role" name="role">
                                                            <option value="0">Kasir</option>
                                                            <option value="1">Admin</option>
                                                        </select>
                                                    </div> --}}
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalEdit" tabindex="-1"
                                aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel2">Edit Akun</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <div class="container-fluid" id="alert-container"></div>
                                                <form action="{{ url('admin/akun/edit') }}" method="post"
                                                    id="formNotice">
                                                    @csrf
                                                    <input type="hidden" class="form-control" id="idEdit"
                                                        name="idEdit" value="">
                                                    <div class="mb-3 row align-items-end">
                                                        <div class="col-12">
                                                            <label for="username" class="form-label">Username</label>
                                                            <input type="text" class="form-control"
                                                                id="usernameEdit" name="usernameEdit" value="">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="namaEdit" class="form-label">Nama Akun</label>
                                                        <input type="text" class="form-control" id="namaEdit"
                                                            name="namaEdit" value="">
                                                    </div>
                                                    <div class="mb-3" id="nama-kasir-containerEdit">
                                                        <label for="nama_kasirEdit" class="form-label">Nama
                                                            Kasir</label>
                                                        <input type="text" class="form-control"
                                                            id="nama_kasirEdit" name="nama_kasirEdit" value="">
                                                    </div>
                                                    {{-- <div class="mb-3">
                                                        <label for="role" class="form-label">Role</label>
                                                        <select class="form-select" id="roleEdit" name="roleEdit">
                                                            <option value="0">Kasir</option>
                                                            <option value="1">Admin</option>
                                                        </select>
                                                    </div> --}}
                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

</body>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
{{-- sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- jquery --}}
<!-- Tambahkan di bagian <head> atau di bagian bawah sebelum </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '{!! implode('<br>', $errors->all()) !!}',
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
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('click', function(e) {
        // Periksa apakah yang diklik adalah tombol "Ganti Password"
        if (e.target.closest('.change-password-link')) {
            e.preventDefault(); // Mencegah navigasi default

            // Ambil data user dari atribut data
            const userId = e.target.closest('.change-password-link').getAttribute('data-user-id');
            const userName = e.target.closest('.change-password-link').getAttribute('data-user-name');

            // Menampilkan SweetAlert untuk memasukkan password baru
            Swal.fire({
                title: `Ganti Password untuk ${userName}`,
                text: 'Masukkan password baru:',
                input: 'password', // Set input menjadi password
                inputAttributes: {
                    autocapitalize: 'off',
                    placeholder: 'Password baru',
                    required: true
                },
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('Password tidak boleh kosong');
                        return;
                    }

                    // Kirim password ke server
                    return fetch(`akun/ganti-password/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            password: password
                        })
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    }).catch(error => {
                        Swal.showValidationMessage(`Request gagal: ${error}`);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `Password untuk ${userName} berhasil diperbarui.`,
                    });
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEdit = document.getElementById('modalEdit');
        modalEdit.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-user-id');
            var userName = button.getAttribute('data-user-username');
            var userNama = button.getAttribute('data-user-nama');
            var userNamaKasir = button.getAttribute('data-user-namakasir');
            var userRole = button.getAttribute('data-user-role');

            console.log(userId, userName, userNama, userNamaKasir, userRole);

            var formId = document.getElementById('idEdit');
            var formUsername = document.getElementById('usernameEdit');
            var formNama = document.getElementById('namaEdit');
            var formNamaKasir = document.getElementById('nama_kasirEdit');
            var formRole = document.getElementById('roleEdit');

            formId.value = userId;
            formUsername.value = userName;
            formNama.value = userNama;
            formNamaKasir.value = userNamaKasir;
            formRole.value = userRole;
        });
    });
</script>

{{-- buat swal konfirmasi hapus akun --}}
<script>
    // buat sweet alert ketika tombol id=delete ditekan 
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        })
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const roleDropdownEdit = document.getElementById("roleEdit");
        const namaKasirContainerEdit = document.getElementById("nama-kasir-containerEdit");

        roleDropdown.addEventListener("change", function() {
            if (this.value == "1") { // Jika "Admin" dipilih
                namaKasirContainerEdit.style.display = "none";
            } else { // Jika "Kasir" dipilih
                namaKasirContainerEdit.style.display = "block";
            }
        });

        // Inisialisasi kondisi awal
        if (roleDropdownEdit.value == "1") {
            namaKasirContainerEdit.style.display = "none";
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const roleEditDropdown = document.getElementById("roleEdit");
        const namaKasirEditContainer = document.getElementById("nama-kasir-containerEdit");

        roleEditDropdown.addEventListener("change", function() {
            if (this.value == "1") { // Jika "Admin" dipilih
                namaKasirEditContainer.style.display = "none";
            } else { // Jika "Kasir" dipilih
                namaKasirEditContainer.style.display = "block";
            }
        });

        // Inisialisasi kondisi awal
        if (roleEditDropdown.value == "1") {
            namaKasirEditContainer.style.display = "none";
        }
    });
</script>
