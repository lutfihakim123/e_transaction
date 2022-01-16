<?php
if ($_SESSION['level'] != 'admin') {
    redirect(base_url('login'));
}
?>
<?php
error_reporting(0);
if (!empty($_GET['download'] == 'doc')) {
    header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_pembelian.doc");
}
if (!empty($_GET['download'] == 'xls')) {
    header("Content-Type: application/force-download");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_pembelian.xls");
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="<?= base_url('assets/');  ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/');  ?>css/sb-admin-2.min.css" rel="stylesheet">
    <title><?= $title; ?></title>
    <style>
        body {
            background: rgba(0, 0, 0, 0.2);
        }

        page[size="A4"] {
            background: white;
            width: 21cm;
            height: 29.7cm;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5pc;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            padding-left: 2.54cm;
            padding-right: 2.54cm;
            padding-top: 1.54cm;
            padding-bottom: 1.54cm;
        }

        @media print {

            body,
            page[size="A4"] {
                margin: 0;
                box-shadow: 0;
            }


            .cetak {
                display: none;
            }
        }
    </style>
</head>

<body>
    <br>
    <div id="printableArea">
        <page size="A4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-9">
                            <h4 style="color: black;"> <b>LAPORAN DATA PEMBELIAN</b> </h4>
                        </div>
                        <div class="col-2">
                            <button type='button' class='btn btn-info cetak ml-5' style="float: left;" onclick="printDiv('printableArea')">
                                <i class='fa fa-print'> </i> Print
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <table class="table" style="color: black;">
                                <tr style="background-color: whitesmoke;">
                                    <td> <small>ID Supp</small> </td>
                                    <td> <small>Barang</small> </td>
                                    <td> <small>Tgl Beli</small> </td>
                                    <td> <small>Quantitas</small></td>
                                    <td> <small>Satuan</small></td>
                                    <td> <small>Total Harga</small></td>
                                    <td> <small>Total Bayar</small></td>
                                    <td> <small>Status</small></td>
                                </tr>
                                <?php
                                foreach ($pembelian as $p) {
                                ?>
                                    <tr>
                                        <td> <small><?= $p->id_supplier; ?></small> </td>
                                        <td> <small><?= $p->barang; ?></small> </td>
                                        <td> <small><?= $p->tgl_beli; ?></small> </td>
                                        <td><small> <?= $p->quantitas; ?></small></td>
                                        <td><small><?= $p->satuan; ?></small> </td>
                                        <td><small><?= $p->total_harga; ?></small> </td>
                                        <td><small> <?= $p->total_bayar; ?></small></td>
                                        <td><small><?= $p->status; ?></small> </td>
                                    <?php
                                }
                                    ?>
                            </table>
                            <?= $this->session->flashdata('message');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <table style="color: black;">
                        <tr>
                            <td> <b>Sub Total Harga</b> </td>
                            <td>:</td>
                            <td>
                                <b>
                                    <?php
                                    foreach ($pembelian as $p) {
                                        $sub_total_harga += $p->total_harga;
                                    }
                                    echo $sub_total_harga;
                                    ?>
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td><b> Total Bayar</b></td>
                            <td>:</td>
                            <td>
                                <b>
                                    <?php
                                    foreach ($pembelian as $p) {
                                        $grand_total_bayar += $p->total_bayar;
                                    }
                                    echo $grand_total_bayar;
                                    ?></b>
                            </td>
                        </tr>
                        <tr style="color: red;">
                            <td> <b>Tunggakan</b> </td>
                            <td>:</td>
                            <td>
                                <b>
                                    <?php
                                    $tunggakan = $sub_total_harga - $grand_total_bayar;
                                    echo $tunggakan;
                                    ?>
                                </b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </page>
    </div>
</body>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<script src="<?= base_url('assets/');  ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/');  ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/');  ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/');  ?>js/sb-admin-2.min.js"></script>

</html>