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
            <a href="register.php" class="active">Registrasi<span></span></a>
            <a href="../logout.php">Keluar<span></span></a>
        </nav>
    </header>

    <div class="container-fluid mt-5">
        <div class="table-responsive">
            <div class="card-body p-0">
                <h2>Data Akun</h2>
                <button type="button" class="btn btn-success mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                    Tambah Data
                </button>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $ambilsemuadatalogin = mysqli_query($koneksi, "SELECT * FROM user");
                        $i = 1;
                        while ($data = mysqli_fetch_array($ambilsemuadatalogin)) {
                            $username = $data['username'];
                            $Password = $data['password'];
                            $nama = $data['nama'];
                            $Level = $data['level'];
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $username; ?></td>
                                <td><?= $Password; ?></td>
                                <td><?= $nama; ?></td>
                                <td><?= $Level; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $i; ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i; ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="edit<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="edit<?= $i; ?>Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit<?= $i; ?>Label">Edit Data Akun</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="edit_akun.php">
                                                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                <div class="form-group mt-2">
                                                    <label for="edit_username">Username:</label>
                                                    <input type="text" name="edit_username" value="<?= $username; ?>" class="form-control" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="edit_password">Password:</label>
                                                    <input type="password" name="edit_password" class="form-control" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="edit_password">Nama:</label>
                                                    <input type="password" name="edit_password" class="form-control" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="edit_level">Level:</label>
                                                    <input type="level" name="edit_level" value="<?= $Level; ?>" class="form-control" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus Data -->
                            <div class="modal fade" id="delete<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="delete<?= $i; ?>Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="delete<?= $i; ?>Label">Hapus Data Akun</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data akun ini?
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="hapus_akun.php">
                                                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
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

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Akun</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="tambah_akun.php">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="password">Nama:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="level">Level:</label>
                            <input type="level" name="level" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

</body>

</html>