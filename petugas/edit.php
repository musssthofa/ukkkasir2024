<?php
include '../koneksi.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomorhp = $_POST['NomorTelepon'];

    // Update data into database
    $query = "UPDATE pelanggan SET NamaPelanggan=?, Alamat=?, NomorTelepon=? WHERE PelangganID=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $nama, $alamat, $nomorhp, $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        echo '<script>alert("Data berhasil diupdate!"); window.location.href = "register.php";</script>';
    } else {
        echo '<script>alert("Gagal mengupdate data!"); window.location.href = "register.php";</script>';
    }
}
?>
