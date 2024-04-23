<?php
include '../koneksi.php';

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $nomorhp = $_POST['nomorhp'];

    // Insert data into database
    $query = "INSERT INTO pelanggan (NamaPelanggan, Alamat, NomorTelepon) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $username, $alamat, $nomorhp);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        echo '<script>alert("Data berhasil ditambahkan!"); window.location.href = "register.php";</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data!"); window.location.href = "register.php";</script>';
    }
}
?>
