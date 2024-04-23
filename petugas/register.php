<?php
include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Data Akun</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="gaya.css">

    <style>
        body {
            background: none;
        }

        .navigation {
            background-color: #f8f9fa;
            /* Ganti warna latar belakang sesuai kebutuhan */
            border-radius: 20px;
            /* Atur nilai border-radius sesuai keinginan */
            padding: 10px 20px;
            /* Atur padding sesuai kebutuhan */
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <header>
        <a href="#"><img src="logo.png" class="logo"></a>
        <nav class="navigation">
            <a href="index.php">Home<span></span></a>
            <a href="data_barang.php">Data Barang<span></span></a>
            <a href="stock_barang.php">Stock Barang<span></span></a>
            <a href="pembelian.php">Transaksi<span></span></a>
            <a href="register.php" class="active">Registrasi<span></span></a>
            <a href="../logout.php">Keluar<span></span></a>
        </nav>
    </header>

    <!-- awal isi content-->

    <div class="container-fluid">


        <!-- Data Akun -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Tambah Akun
                </button>

                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data</h4>
                                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form method="post" action="tambah.php">
                                    <div class="form-group">
                                        <label for="nama">Nama :</label>
                                        <input type="text" name="username" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat :</label>
                                        <input type="text" name="alamat" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="nomorhp">No Telepon:</label>
                                        <input type="text" name="nomorhp" class="form-control">
                                    </div>
                                    <div class="form-group mt-2">
                                    <button type="submit" value="Tambahkan" class="btn btn-primary" name=" tambah" data-bs-dismiss="modal">Submit</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Telepon </th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $ambilsemuadatapelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                $i = 1;
                                while ($data = mysqli_fetch_array($ambilsemuadatapelanggan)) {
                                    $id = $data['PelangganID']; // 
                                    $nama = $data['NamaPelanggan'];
                                    $alamat = $data['Alamat'];
                                    $nohp = $data['NomorTelepon'];


                                ?>

                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $nama; ?></td>
                                        <td><?= $alamat; ?></td>
                                        <td><?= $nohp; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $i; ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i; ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>


                                    <!-- edit Modal -->


                                    <div class="modal" id="edit<?= $i; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">EDIT AKUN</h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form method="post" action="edit.php?id=<?= $id; ?>">
                                                        <input type="hidden" name="id" value="<?= $data['PelangganID']; ?>">
                                                        <div class="form-group">
                                                            <label for="nama">Nama :</label>
                                                            <input type="text" name="nama" class="form-control" value="<?= $nama ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="alamat">Alamat :</label>
                                                            <input type="text" name="alamat" class="form-control" value="<?= $alamat ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nomorhp">No Telepon:</label>
                                                            <input type="number" name="NomorTelepon" class="form-control" value="<?= $nohp ?>">
                                                        </div>
                                                        <div class="form-group">
                                                        <button type="submit" class="btn btn-primary" name="edit" data-bs-dismiss="modal">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete Modal -->
                                    <div class="modal" id="delete<?= $i; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Konfirmasi Hapus Akun</h4>
                                                </div>
                                                <!-- Modal body -->
                                                <form action="hapus.php" method="post">
                                                    <input type="hidden" name="PelangganID" value="<?= $id; ?>"> <!-- Gunakan ProdukID di sini -->
                                                    <div class="modal-body">
                                                        Apakah anda yakin menghapus data akun ini?

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" name="hapusakun">Hapus</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                    </div>

                <?php
                                }
                ?>


                </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>








    <!-- akhir isi content-->


    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
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


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

</body>

</html>