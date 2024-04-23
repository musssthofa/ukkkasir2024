<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NamaProduk = $_POST['NamaProduk'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];

     // Validasi nilai harga tidak negatif
     if ($Harga < 0) {
        echo '<script>alert("Harga tidak boleh negatif!"); window.location.href = "data_barang.php";</script>';
        exit();
    }

    // Proses validasi file
    $allowed_types = array('image/png', 'image/jpeg', 'image/jpg');
    $max_size = 1024 * 1024 * 1.5; // 1.5 MB

    if ($_FILES['foto']['size'] > $max_size) {
        echo '<script>alert("File terlalu besar. Maksimum 1.5 MB."); window.location.href = "data_barang.php";</script>';
        exit();
    } elseif (!in_array($_FILES['foto']['type'], $allowed_types)) {
        echo '<script>alert("Tipe file tidak diizinkan. Hanya PNG, JPG, dan JPEG yang diperbolehkan."); window.location.href = "data_barang.php";</script>';
        exit();
    } else {
        // Proses upload gambar
        $foto = $_FILES["foto"]["name"];
        $temp = $_FILES["foto"]["tmp_name"];
        $folder = "img/" . $foto;

        move_uploaded_file($temp, $folder);

        // Simpan data ke database
        $query = "INSERT INTO produk (foto, NamaProduk, Harga, Stok) VALUES ('$foto', '$NamaProduk', '$Harga', '$Stok')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo '<script>alert("Berhasil menyimpan data!"); window.location.href = "data_barang.php";</script>';
        } else {
            echo '<script>alert("Gagal menyimpan data!"); window.location.href = "data_barang.php";</script>';
        }
    }
}
?>
