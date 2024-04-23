<?php
include '../koneksi.php';
include 'functions.php';


//session_start();//
//$nama_pelanggan = $_SESSION['NamaPelanggan'];//

$tgl = date("jmYGi");
$huruf = "AD";
$penjualanid = $huruf . $tgl;

$result = hitungTotalBayar($koneksi);
$tot_bayar = $result['tot_bayar'];
$bayar = $result['bayar'];
$kembalian = $result['kembalian'];



?>



<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Petugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="gaya.css">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        h2 {
            text-align: center;
        }
    </style>

    <script>
        var selectedProdukIDArray = []; // Menyimpan ProdukID untuk setiap produk
        var hargaArray = []; // Menyimpan harga untuk setiap produk

        function isiNamaHarga() {
            var selectedProdukID = document.getElementById('ProdukID').value;

            // Menggunakan AJAX untuk mengambil data dari server
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'ambil_data_produk.php?ProdukID=' + selectedProdukID, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);

                    // Menambahkan data ke dalam array
                    selectedProdukIDArray.push(selectedProdukID);
                    hargaArray.push(data.Harga);

                    // Mengisi nilai nama dan harga setelah menerima data dari server
                    document.getElementById('namaproduk').value = data.NamaProduk;
                    document.getElementById('harga').value = data.Harga;

                    // Menampilkan detail pesanan di sebelah kanan
                    updateOrderDetails();
                }
            };

            xhr.send();
        }

        function hitungSubtotal() {
            var jumlah = parseFloat(document.getElementById('jumlah').value);

            if (!isNaN(jumlah) && hargaArray.length > 0) {
                var subtotal = 0;

                // Menghitung subtotal untuk setiap produk
                for (var i = 0; i < hargaArray.length; i++) {
                    subtotal += hargaArray[i] * jumlah;
                }

                // Menampilkan subtotal dengan format rupiah
                document.getElementById('subtotal').value = subtotal;
            }
        }

        function updateOrderDetails() {
            var orderDetails = 'Detail Pesanan:<br>';

            // Menampilkan detail pesanan untuk setiap produk
            for (var i = 0; i < selectedProdukIDArray.length; i++) {
                orderDetails += 'Produk ID: ' + selectedProdukIDArray[i] + '<br>Harga: ' + hargaArray[i] + '<br><br>';
            }

            // Menampilkan detail pesanan di sebelah kanan
            document.getElementById('orderDetails').innerHTML = orderDetails;
        }


        function totalnya() {
            var harga = parseInt(document.getElementById('hargatotal').value);
            var pembayaran = parseInt(document.getElementById('bayarnya').value);
            var kembali = pembayaran - harga;
            if (isNaN(kembali) || kembali < 0) {
                kembali = 0; // Make sure kembali is non-negative and not NaN
            }
            document.getElementById('total1').value = kembali;
        }

        function printContent(print) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(print).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>

</head>

<body id="page-top">
<header>
        <a href="#"><img src="logo.png" class="logo"></a>
        <nav class="navigation bg-light">
            <a href="index.php">Home<span></span></a>
            <a href="data_barang.php">Data Barang<span></span></a>
            <a href="stock_barang.php">Stock Barang<span></span></a>
            <a href="pembelian.php"class="active">Transaksi<span></span></a>
            <a href="register.php">Registrasi<span></span></a>
            <a href="../logout.php">Keluar<span></span></a>
        </nav>
    </header>
    



           
                <!-- End of Topbar -->
                <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['save'])) {
            // Proses tambah ke keranjang
            $id = $_POST['ProdukID'];
            $penjualanid = $_POST['PenjualanID'];
            $qty = $_POST['JumlahProduk'];
            $total = $_POST['Subtotal'];

            $sql = "INSERT INTO keranjang (ProdukID,PenjualanID, JumlahProduk, Subtotal) VALUES('$id','$penjualanid', '$qty', '$total')";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

            if ($query) {
                echo '<script>window.location=""</script>';
            } else {
                echo "Error :" . $sql . "<br>" . mysqli_error($koneksi);
            }
        } elseif (isset($_POST['save1'])) {
            // Proses bayar dan kembalian
            $penjualanid = $_POST['PenjualanID'];
            $bayar = $_POST['bayar'];
            $kembalian = $bayar - $tot_bayar;

            $sql = "UPDATE detailpenjualan SET bayar='$bayar', kembalian='$kembalian' WHERE PenjualanID='$penjualanid'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        } elseif (isset($_POST['selesai'])) {
            // Proses menyimpan ke penjualan dan menghapus dari detailpenjualan
            $ambildata = mysqli_query($koneksi, "
                INSERT INTO penjualan ( PenjualanID, TanggalPenjualan, TotalHarga, bayar, kembalian)
                SELECT PenjualanID, NOW(), Subtotal AS TotalHarga, bayar, kembalian
                FROM detailpenjualan WHERE PenjualanID='$penjualanid'
            ") or die(mysqli_error($koneksi));

            $hapusdata = mysqli_query($koneksi, "DELETE FROM detailpenjualan WHERE PenjualanID='$penjualanid'");
            echo '<script>window.location="pembelian.php"</script>';
        }
    }
    ?>


                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <form method="post" action="simpan.php">
                                <label for="col-sm-4 col-form-label col-form-label-sm">Produk ID:</label>
                                <div class="col-sm-8">
                                    <select name="ProdukID" id="ProdukID" class="form-control" onchange="isiNamaHarga()" required>
                                        <option value="">Silahkan Pilih</option>
                                        <?php
                                        $ambilsemuadatanya = mysqli_query($koneksi, "select * from produk");
                                        while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                            $produkid = $fetcharray['ProdukID'];
                                        ?>
                                            <option value="<?= $produkid; ?>"><?= $produkid; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <label for="col-sm-4 col-form-label col-form-label-sm">Nama Produk :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="namaproduk" name="namaproduk" readonly>
                                </div>

                                <label for="col-sm-4 col-form-label col-form-label-sm">Harga :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="harga" name="Harga" readonly>
                                </div>

                                <label for="col-sm-4 col-form-label col-form-label-sm">Jumlah:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="jumlah" name="JumlahProduk" oninput="hitungSubtotal()" required>
                                </div>

                                <label for="col-sm-4 col-form-label col-form-label-sm"><b>Sub-Total</b></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="subtotal" name="Subtotal" name="Subtotal" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-purple btn-sm" name="save" value="simpan" type="submit">
                                                <i class="fa fa-plus mr-2"></i>Tambah </button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <?php
                            function format_ribuan($nilai)
                            {
                                $nilai = is_numeric($nilai) ? $nilai : 0;
                                return number_format($nilai, 0, ',', '.');
                            }

                            ?>

                            <form method="POST">
                                <div class="form-group row mb-0">
                                    <input type="hidden" class="form-control" name="PenjualanID" value="<?php echo $penjualanid ?>" readonly>
                                    <input type="hidden" class="form-control" value="<?php echo $tot_bayar; ?>" id="hargatotal" readonly>
                                    <label class="col-sm-4 col-form-label col-form-label-sm"><b>Bayar</b></label>
                                    <div class="col-sm-8 mb-2">
                                        <input type="number" class="form-control form-control-sm" name="bayar" id="bayarnya" onchange="totalnya()">
                                    </div>
                                    <label class="col-sm-4 col-form-label col-form-label-sm"><b>Kembali</b></label>
                                    <div class="col-sm-8 mb-2">
                                        <input type="number" class="form-control form-control-sm" name="kembalian" id="total1" readonly>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-purple btn-sm" name="save1" value="simpan" type="submit">
                                        <i class="fa fa-shopping-cart mr-2"></i>Bayar </button>
                                </div>
                            </form>



                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card" id="print">
                                <div class="card-header bg-white border-0 pb-0 pt-4">
                                    <form>
                                        <h2>YOUR ORDER</h2>
                                    </form>
                                    <div class="col-4 col-sm-3 pl-0">
                                        <ul class="pl-0 small" style="list-style: none;">
                                            <li>TGL : <?php echo  date("j-m-Y"); ?></li>
                                            <li>JAM : <?php echo  date("G:i:s"); ?></li>
                                            <li>ID: <?php echo  $penjualanid; ?></li>
                                        
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-body small pt-0">
                                    <hr class="mt-0">
                                    <div class="row">

                                        <div class="col-2 pr-0 text-center">
                                            <span><b>Kode</b></span>
                                        </div>

                                        <div class="col-3 pr-0 text-center">
                                            <span><b>Nama Barang</b></span>
                                        </div>

                                        <div class="col-1 px-0 text-center">
                                            <span><b>Qty</b></span>
                                        </div>

                                        <div class="col-2 px-0 text-center">
                                            <span><b>Harga</b></span>
                                        </div>

                                        <div class="col-2 pl-0 text-center">
                                            <span><b>Subtotal</b></span>
                                        </div>

                                        <div class="col-1 pr-0 text-center">
                                            <span><b>Aksi</b></span>
                                        </div>

                                        <div class="col-12">
                                            <hr class="mt-2">
                                        </div>
                                        <?php
                                        $data_barang = mysqli_query($koneksi, "SELECT produk.NamaProduk, detailpenjualan.PenjualanID, detailpenjualan.JumlahProduk, produk.Harga, detailpenjualan.Subtotal, detailpenjualan.DetailID
                                                        FROM detailpenjualan
                                                        JOIN produk ON detailpenjualan.ProdukID = produk.ProdukID");
                                        while ($d = mysqli_fetch_array($data_barang)) {
                                        ?>

                                            <div class="col-2 pr-0 text-center">
                                                <span><?php echo $penjualanid; ?></span>
                                            </div>

                                            <div class="col-3 pr-0 text-center">
                                                <span><?php echo $d['NamaProduk']; ?></span>
                                            </div>

                                            <div class="col-1 px-0 text-center">
                                                <span><?php echo $d['JumlahProduk']; ?></span>
                                            </div>
                                            <div class="col-2 px-0 text-center">
                                                <span>Rp. <?php echo format_ribuan($d['Harga']); ?></span>
                                            </div>
                                            <div class="col-2 pl-0 text-center">
                                                <span>Rp. <?php echo format_ribuan($d['Subtotal']); ?></span>
                                            </div>
                                            <div class="col-1 pr-0 text-center">
                                                <a href="?id=<?php echo $d['DetailID']; ?>" onclick="javascript:return confirm('Hapus Data Barang ?');" style="text-decoration:none;">
                                                    <i class="fa fa-times fa-xs text-danger mr-1"></i>
                                                </a>
                                            </div>
                                            <?php
                                            if (isset($_GET['id'])) {
                                                $detailID = $_GET['id'];
                                                $hapus_data = mysqli_query($koneksi, "DELETE FROM detailpenjualan WHERE DetailID = '$detailID'");
                                                if ($hapus_data) {
                                                    echo '<script>alert("Data Barang berhasil dihapus"); window.location.href="pembelian.php";</script>';
                                                } else {
                                                    echo "Error: " . mysqli_error($koneksi);
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                        <div class="col-12">
                                            <hr class="mt-2">
                                            <ul class="list-group border-0">

                                                <li class="list-group-item p-0 border-0 d-flex justify-content-between align-items-center">
                                                    <b>Total</b>
                                                    <span><b>Rp. <?php echo format_ribuan($tot_bayar); ?></b></span>
                                                </li>
                                                <li class="list-group-item p-0 border-0 d-flex justify-content-between align-items-center">
                                                    <b>Bayar</b>
                                                    <span>Rp. <b><?php echo format_ribuan($bayar); ?></b></span>
                                                </li>
                                                <li class="list-group-item p-0 border-0 d-flex justify-content-between align-items-center">
                                                    <b>Kembalian</b>
                                                    <span>Rp. <b><?php echo format_ribuan($kembalian); ?></b></span>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 mt-3 text-center">
                                        <p>* TERIMA KASIH TELAH BERBELANJA*</p>
                                    </div>
                                    <div class="text-right mt-3">
                                    </div>
                                </div>
                            </div>

                            <form method="POST" class="">
                                <button class="btn btn-purple-light btn-sm mr-2" onclick="printContent('print')"><i class="fa fa-print mr-1"></i> Print</button>
                                <button class="btn btn-purple btn-sm" name="selesai" type="submit"><i class="fa fa-check mr-1"></i> Selesai</button>

                            </form>
                        </div>



                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
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
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Apakah anda yakin akan "Logout".</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="../index.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>





</body>

</html>