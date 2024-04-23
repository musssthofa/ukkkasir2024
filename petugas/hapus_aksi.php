<!-- hapus.php -->
<?php
include '../koneksi.php';

if (isset($_POST['hapusbarang'])) {

    // Ambil nama gambar dari database
    $query_select = "SELECT foto FROM produk WHERE ProdukID='$_POST[idb]'";
    $result_select = mysqli_query($koneksi, $query_select);

    if ($result_select) {
        $row = mysqli_fetch_assoc($result_select);
        $foto = $row['foto'];

        // Hapus gambar dari direktori
        $path = "img/" . $foto;
        if (unlink($path)) {
            // Hapus data dari database jika penghapusan gambar berhasil
            $query_delete = "DELETE FROM produk WHERE ProdukID='$_POST[idb]'";
            $result_delete = mysqli_query($koneksi, $query_delete);

            if ($result_delete) {
                echo '<script>alert("Berhasil menghapus data!"); window.location.href = "data_barang.php";</script>';
            } else {
                echo '<script>alert("Gagal menghapus data!"); window.location.href = "data_barang.php";</script>';
            }
        } else {
            // echo '<script>alert("Gagal Menghapus!"); window.location.href = "PendataanBarang.php";</script>';
        }
    } else {
        echo '<script>alert("Gagal Mengambil Data Barang!"); window.location.href = "data_barang.php";</script>';
    }
} else {
    echo '<script>alert("ID Barang Tidak Valid!"); window.location.href = "data_barang.php";</script>';
}
?>
