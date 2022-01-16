<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Page</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets'); ?>/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('assets/'); ?>img/login.png" />

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <br>
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-5 col-md-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?= base_url('assets'); ?>/img/bandar_login.png" class="img-fluid" style="width: 250px;">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <h1 class="h4 text-gray-900 mb-4"> <b>Login Bandar</b></h1>
                                        <?= $this->session->flashdata('message'); ?>
                                    </div>
                                    <form action="<?= base_url('login/aksi_login_bandar'); ?>" method="POST" class="user">
                                        <div class="form-group">
                                            <input type="text" autocomplete="off" class="form-control form-control-user" id="username" aria-describedby="username" required name="username" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" autocomplete="off" class="form-control  form-control-user" id="password" name="password" required placeholder="Password">
                                        </div>

                                        <input type="submit" name="login" value="Login" class="btn btn-primary btn-user btn-block">
                                        </input>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>

</body>

</html>