<?php
include '../koneksi.php';
// Pastikan form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $foto = $_FILES['foto']['name'];
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];

    // Validasi nilai harga tidak mengandung tanda "-"
    if (strpos($Harga, '-') !== false) {
        echo "Harga tidak valid.";
        exit(); // Hentikan eksekusi script
    }

    // Lanjutkan dengan proses penyimpanan data...
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
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

<body>
    <header>
        <a href="#"><img src="logo.png" class="logo"></a>
        <nav class="navigation bg-light">
            <a href="index.php">Home<span></span></a>
            <a href="data_barang.php" class="active">Data Barang<span></span></a>
            <a href="stock_barang.php">Stock Barang<span></span></a>
            <a href="register.php">Registrasi<span></span></a>
            <a href="../logout.php">Keluar<span></span></a>
        </nav>
    </header>

    <div class="container-fluid mt-5">
        <button type="submit" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#myModal">
            Tambah data
        </button>

        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Simpan Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
    <form id="addForm" method="post" action="tambah_aksi.php" enctype="multipart/form-data">
        <div class="form-group mb-2">
            <label for="foto">Foto :</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>
        <div class="form-group mb-2">
            <label for="nama">Name Product:</label>
            <input type="text" name="NamaProduk" id="nama" class="form-control">
        </div>
        <div class="form-group mb-2">
            <label for="Harga">Harga:</label>
            <input type="text" name="Harga" id="harga" class="form-control">
        </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" onclick="validateForm()">Save changes</button>
</div>
</form>

                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Name Product</th>
                            <th>Harga</th>
                            <th>Stock</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $ambilsemuadataproduk = mysqli_query($koneksi, "SELECT * FROM produk");
                        $i = 1;
                        while ($data = mysqli_fetch_array($ambilsemuadataproduk)) {
                            $img = $data['foto']; // Initialize variable for image
                            $NamaProduk = $data['NamaProduk'];
                            $Harga = $data['Harga'];
                            $Stok = $data['Stok'];
                        ?>

                            <tr>
                                <td><?= $i++; ?></td>
                                <td>
                                    <img src="<?= 'img/' . $img ?>" width="100">
                                </td>
                                <td><?= $NamaProduk; ?></td>
                                <td><?= "Rp " . number_format($Harga, 0, ',', '.'); ?></td>
                                <td><?= $Stok; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $i ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i ?>">
                                        Delete
                                    </button>
                                    <!-- Button trigger modal -->

                                </td>
                            </tr>


                            <!-- edit Modal -->
                            <!-- Modal -->
                            <div class="modal fade" id="edit<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="edit_aksi.php" enctype="multipart/form-data">
                                                <input type="hidden" name="idb" value="<?= $data['ProdukID']; ?>">
                                                <div class="form-group mb-2">
                                                    <label for="gambar_tersimpan">Gambar Tersimpan :</label>
                                                    <div>
                                                        <img src="img/<?= $img ?>" alt="" width="200">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="foto">Foto :</label>
                                                    <input type="file" name="foto" class="form-control">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="nama">Name Product:</label>
                                                    <input type="text" name="NamaProduk" class="form-control" value="<?= $NamaProduk ?>">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="Harga">Harga:</label>
                                                    <input type="text" name="Harga" class="form-control" value="<?= $Harga ?>">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- delete Modal -->
                            <div class="modal fade" id="delete<?= $i; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Barang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus barang ini? <strong class="text-danger"><?=$NamaProduk; ?></strong>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="hapus_aksi.php" method="post">
                                                <input type="hidden" name="idb" value="<?= $data['ProdukID']; ?>">
                                                <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                            </form>
                                        </div>
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
    </div>
    <script>
function validateForm() {
    var foto = document.getElementById("foto").value;
    var nama = document.getElementById("nama").value;
    var harga = document.getElementById("harga").value;
    
    if (foto === "" || nama === "" || harga === "") {
        alert("Please fill out all fields");
        return false;
    }

    // Validasi jika harga mengandung nilai "-"
    if (harga.includes("-")) {
        alert("Please ensure the price does not contain '-'");
        return false;
    }
}
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>