<?php
include '../koneksi.php';
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
            <a href="data_barang.php">Data Barang<span></span></a>
            <a href="stock_barang.php" class="active">Stock Barang<span></span></a>
            <a href="pembelian.php">Transaksi<span></span></a>
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
                        <form method="post" action="tambah_stock.php" enctype="multipart/form-data">
                            <div class="form-group mb-2">
                                <label for="nama">Name Product:</label>
                                <select class="form-select" name="NamaProduk" class="form-control">
                                    <?php
                                    $ambilsemuadatanya = mysqli_query($koneksi, "select * from produk");
                                    while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                        $namaproduk = $fetcharray['NamaProduk'];
                                        $id = $fetcharray['PelangganID'];
                                    ?>

                                        <option value="<?= $namaproduk; ?>"><?= $namaproduk; ?></option>


                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Stok">Stok:</label>
                                <input type="text" name="Stok" class="form-control">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                            </tr>


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

function showSuccessPopup() {
        $('#myModal').modal('show');
        setTimeout(function() {
            $('#myModal').modal('hide');
        }, 3000); // Menyembunyikan popup setelah 3 detik (3000 milidetik)
    }
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>