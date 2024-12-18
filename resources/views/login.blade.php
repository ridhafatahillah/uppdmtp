<!DOCTYPE html>
<!-- saved from url=(0041)https://paspor-gtk.simpkb.id/casgpo/login -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link href="Login _ SIMPKB_files/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="Login _ SIMPKB_files/simpkb.css" />
    <title>Login | SIPSKPD</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-item-center">
            <div class="col-lg-10 col-md-10 col-sm-12 py-md-5">
                <div class="row shadow">
                    <div class="col-lg-6 col-md-6 col-sm-12 card-none-color p-4 p-md-5 order-1 order-md-0">
                        <div class="text-center text-md-start">
                            <img src="Login _ SIMPKB_files/kalsel.png" class="img-fluid mb-3 ml-md-4 ml-sm-5"
                                width="60px" alt="Logo" />

                            <p class="mb-0">Selamat Datang</p>
                            di Aplikasi SIPSKPD
                            </h4>
                            <p
                                style="
                    font-size: small;
                    color: grey;
                  ">
                                SIPSKPD
                                merupakan aplikasi Sistem Informasi Pencatatan
                                Surat Ketetapan Pajak Daerah pada UPPD Martapura
                            </p>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->has('belumLogin'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('belumLogin') }}
                            </div>
                        @endif
                        @error('password')
                            <div class="alert alert-danger" role="alert">
                                Kata Sandi diperlukan
                            </div>
                        @enderror
                        <form id="form1" name="form1" class="mb-3 mt-md-3" action="postlogin" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label" style="font-size: small">
                                    Username
                                    <span style="color: red">*</span>
                                </label>
                                <input id="username" name="name" class="form-control" tabindex="1"
                                    style="font-size: small" placeholder="Masukkan Username" type="text"
                                    value="" autocomplete="false" />
                            </div>

                            <div class="form-group small">
                                <label for="password" class="font-weight-bold" style="font-size: small">Kata Sandi
                                    <span style="color: red">*</span>
                                </label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input id="password" name="password" class="form-control rounded-end"
                                        tabindex="2" style="font-size: small" placeholder="Masukkan kata sandi "
                                        type="password" value="" autocomplete="off" />
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    MASUK
                                </button>
                            </div>


                        </form>

                        <p style="
                  font-size: x-small;
                  color: grey;
                "
                            class="mb-0 mt-5">
                            ©2024 Aplikasi SIPSKPD
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 card-color p-4 p-md-5 order-0 order-md-1">
                        <div id="carouselExampleIndicators" class="carousel slide mt-md-4" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="carousel-img">
                                        <img src="./Login _ SIMPKB_files/login-2.png" alt="..." />
                                    </div>
                                    <div class="carousel-text d-none d-md-block text-center" style="margin-top: 50px">
                                        <h4 class="text-white">
                                            <strong>Masuk Dengan Akun<br /> Kasir

                                            </strong>
                                        </h4>
                                        <p class="text-white">
                                            Anda bisa masuk
                                            menggunakan menggunakan
                                            akun kasir yang ingin dicatat
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script src="Login _ SIMPKB_files/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
            </script>
            <script src="Login _ SIMPKB_files/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
            </script>
            <script src="Login _ SIMPKB_files/bootstrap.min.js"
                integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
            </script>
</body>

</html>
<script src="/Login _ SIMPKB_files/bootstrap.bundle.min.js"></script>
