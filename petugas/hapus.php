<?php
include '../koneksi.php';

if (isset($_POST['hapusakun'])) {
    $id = $_POST['PelangganID'];

    // Delete data from database
    $query = "DELETE FROM pelanggan WHERE PelangganID=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        echo '<script>alert("Data berhasil dihapus!"); window.location.href = "register.php";</script>';
    } else {
        echo '<script>alert("Gagal menghapus data!"); window.location.href = "register.php";</script>';
    }
}
?>
