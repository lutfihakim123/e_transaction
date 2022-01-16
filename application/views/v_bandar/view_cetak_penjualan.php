<?php
if ($_SESSION['level'] != 'bandar') {
    redirect(base_url('login_bandar'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= base_url('assets/');  ?>img/admin.png" />
    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/');  ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/');  ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('v_bandar'); ?> ">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="<?= base_url('assets/img/logo-brand.png'); ?>" alt="">
                </div>
                <div class="sidebar-brand-text mx-3">E-Note</div>
            </a>
            <br>
            <!-- Heading -->
            <div class="sidebar-heading">
                <h6 style="color: rgb(212, 214, 214);"> <b>Data</b> </h6>
            </div>

            <hr class="sidebar-divider mt-1 mb-2">

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('v_bandar'); ?>">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span>Data Transaksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('v_bandar/view_cetak_penjualan'); ?>">
                    <i class="fas fa-print"></i>
                    <span>Cetak Transaksi</span>
                </a>
            </li>

            <hr class="sidebar-divider  mb-1 d-none d-md-block">
            <li class="nav-item mb-2">
                <a class="nav-link" href="<?= base_url('login/logout_bandar') ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 large"><?= $_SESSION['nama']; ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url('assets/'); ?>img/admin.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h5 class="ml-4"> <b>Cetak Penjualan Berdasarkan Range Tgl Beli</b> </h5> <br>
                    <form action="<?= base_url('v_bandar/cetak_penjualan'); ?>" method="post" class="form-inline ml-2 float-left">
                        <h5 class="ml-3">Barang </h5>
                        <select class="custom-select ml-2" name="barang">
                            <option value="" selected>Pilih Barang</option>
                            <option value="jamur tiram">Jamur Tiram</option>
                            <option value="jamur kuping">Jamur Kuping</option>
                        </select>
                        <input type="text" name="id_bandar" value="<?= $_SESSION['id_bandar'];  ?>" hidden>
                        <h5 class="ml-3">Tgl Start </h5>
                        <input type="date" name="start" class="form form-control ml-2" autocomplete="off">
                        <h5 class="ml-3">Tgl End</h5>
                        <input type="date" name="end" class="form form-control ml-3" autocomplete="off">
                        <input type="submit" name="range" class="btn btn-info ml-2" value="Cetak Data" autocomplete="off">
                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="row">
                    <div class="col-10"></div>
                    <div class="col-2">
                        <div class="card mr-3 text-dark border-primary mb-3" style="max-width: 12rem;">
                            <div class="card-header border-primary"> <i class="fas fa-pencil-alt"></i> Note</div>
                            <div class="card-body">
                                <h7 class="card-title">Your ID Bandar : <?= $_SESSION['id_bandar']; ?> </h7>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; M Azla 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Silahkan tekan tombol logout jika anda yakin untuk mengakhiri sesi ini</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('login/logout_bandar'); ?> ">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/');  ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/');  ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/');  ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/');  ?>js/sb-admin-2.min.js"></script>

</body>

</html>