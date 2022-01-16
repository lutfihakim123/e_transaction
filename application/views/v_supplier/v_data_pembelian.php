<?php
if ($_SESSION['level'] != 'supplier') {
    redirect(base_url('login/login_supp'));
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('v_supplier'); ?> ">
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
                <a class="nav-link" href="<?= base_url('v_supplier'); ?>">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span>Data Transaksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('v_supplier/view_cetak_pembelian'); ?>">
                    <i class="fas fa-print"></i>
                    <span>Cetak Transaksi</span>
                </a>
            </li>

            <hr class="sidebar-divider  mb-1 d-none d-md-block">
            <li class="nav-item mb-2">
                <a class="nav-link" href="<?= base_url('login/logout_supp') ?>">
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
                    <div class="row">
                        <div class="col-6">
                            <h4 style="color: black;">Data Transaksi</h4>
                        </div>
                        <div class="col-6 ml-1">
                            <span style="color: black;">
                                Sub Total Harga :
                                <?php
                                $sub_total_harga = 0;
                                foreach ($pembelian as $p) {
                                    $sub_total_harga += $p->total_harga;
                                }
                                echo $sub_total_harga;
                                ?>
                                ||
                                Total Bayar
                                <?php
                                $grand_total_bayar = 0;
                                foreach ($pembelian as $p) {
                                    $grand_total_bayar += $p->total_bayar;
                                }
                                echo $grand_total_bayar;
                                ?>
                                ||
                            </span>
                            <span style="color: red;">
                                Tunggakan :
                                <?php
                                $tunggakan = $sub_total_harga - $grand_total_bayar;
                                echo $tunggakan;
                                ?>
                            </span>
                        </div>
                        <div class="col-12">
                            <table class="table mt-2">
                                <tr>
                                    <th>No</th>
                                    <th>Tgl beli</th>
                                    <th>quantitas</th>
                                    <th>Harga satuan</th>
                                    <th>Total Harga</th>
                                    <th>Total Bayar</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $i = 1;
                                foreach ($pembelian as $p) {
                                ?>
                                    <tr>
                                        <td><?= ++$start; ?></td>
                                        <td><?= $p->tgl_beli; ?></td>
                                        <td><?= $p->quantitas; ?></td>
                                        <td><?= $p->satuan; ?></td>
                                        <td><?= $p->total_harga; ?></td>
                                        <td><?= $p->total_bayar; ?></td>
                                        <td><?= $p->status; ?></td>
                                        <td><a href="<?php echo base_url('v_supplier/nota_pembelian/' . $p->id_pembelian); ?>" class="btn btn-info"> <i class="fas fa-print"></i> Print</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <div class="row">
                                <div class="col-6">

                                </div>
                                <div class="col-6">
                                    <?= $this->pagination->create_links(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
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
                    <a class="btn btn-primary" href="<?= base_url('login/logout_supp'); ?> ">Logout</a>
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