<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaproduk = $_POST['NamaProduk'];
    $stok = $_POST['Stok'];

     // Periksa apakah stok negatif
     if ($stok < 0) {
        echo '<script>alert("Stok tidak boleh negatif!"); window.location.href = "stock_barang.php";</script>';
        exit();
    }

    // Perbarui stok barang
    $query = "UPDATE produk SET Stok = Stok + ? WHERE NamaProduk = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'is', $stok, $namaproduk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect kembali ke halaman stock_barang.php setelah berhasil menambahkan stok
    header('Location: stock_barang.php');
    exit();
}
?>
