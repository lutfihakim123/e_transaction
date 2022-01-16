<?php
if ($_SESSION['level'] != 'supplier') {
    redirect(base_url('login/login_supp'));
}
?>
<?php
error_reporting(0);
if (!empty($_GET['download'] == 'doc')) {
    header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_nota_transaksi.doc");
}
if (!empty($_GET['download'] == 'xls')) {
    header("Content-Type: application/force-download");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_nota_transaksi.xls");
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
                    <h4 style="color: black;"> <b>NOTA TRANSAKSI -- <span style="color: red;"><?= $pembelian[0]->tgl_beli; ?></span> </b> </h4>
                    <br>
                    <div class="row">

                        <div class="col-8">
                            <table class="table" style="color: black;">
                                <tr>
                                    <td>Nama Supplier</td>
                                    <td>:</td>
                                    <td><?= $pembelian[0]->nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Barang</td>
                                    <td>:</td>
                                    <td><?= $pembelian[0]->barang; ?></td>
                                </tr>
                                <tr>
                                    <td>Quantitas</td>
                                    <td>:</td>
                                    <td><?= $pembelian[0]->quantitas; ?></td>
                                </tr>
                                <tr>
                                    <td>Satuan</td>
                                    <td>:</td>
                                    <td><?= $pembelian[0]->satuan; ?></td>
                                </tr>
                                <tr>
                                    <td>Total Harga</td>
                                    <td>:</td>
                                    <td><?= $pembelian[0]->total_harga; ?></td>
                                </tr>
                                <tr>
                                    <td>Total Bayar</td>
                                    <td>:</td>
                                    <td><?= $pembelian[0]->total_bayar; ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td><?= $pembelian[0]->status; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br> <br>
            <div class="row" style="color: black;">
                <div class="col-4">
                    <h5 class="text-center">Tanda Terima</h5>
                </div>
                <div class="col-4">
                    <h5 class="text-center">Hormat Kami</h5>
                </div>
                <div class="col-4">
                </div>
                <br><br><br><br><br>
                <div class="col-4">
                    <hr style="background-color:black;">
                </div>
                <div class="col-4">
                    <hr style="background-color:black;">
                </div>
                <div class="col-4">
                </div>
            </div>
            <br>
            <button type='button' class='btn btn-info cetak ml-2' style="float: left;" onclick="printDiv('printableArea')">
                <i class='fa fa-print'> </i> Print
            </button>
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