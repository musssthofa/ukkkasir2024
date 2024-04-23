<?php
include '../koneksi.php';

if (isset($_POST['edit'])) {
    // Memeriksa apakah ada input yang kosong
    if (empty($_POST['NamaProduk']) || empty($_POST['Harga']) || empty($_POST['Stok'])) {
        echo '<script>alert("Please fill out all fields!"); window.location.href = "data_barang.php";</script>';
        exit();
    }

    $Harga = $_POST['Harga'];

    // Validasi nilai harga tidak negatif
    if ($Harga < 0) {
        echo '<script>alert("Harga tidak boleh negatif!"); window.location.href = "data_barang.php";</script>';
        exit();
    }

    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', '');
    $nama = $_FILES['foto']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['foto']['size'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    $angka_acak = rand(1, 99);
    $nama_gambar_baru = $angka_acak . '-' . $nama;

    if ($nama != "") {
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $get_gambar = "SELECT foto FROM produk WHERE ProdukID = '$_POST[idb]'";
            $data_gambar = mysqli_query($koneksi, $get_gambar);
            $gambar_lama = mysqli_fetch_array($data_gambar);

            unlink("img/" . $gambar_lama['foto']);

            if ($ukuran < 1044070) {
                move_uploaded_file($file_tmp, 'img/' . $nama_gambar_baru);

                $ubah = mysqli_query($koneksi, "UPDATE produk SET
                                                foto = '$nama_gambar_baru',
                                                NamaProduk = '$_POST[NamaProduk]',
                                                Harga = '$_POST[Harga]',
                                                Stok = '$_POST[Stok]'
                                                WHERE ProdukID = '$_POST[idb]'");
                if ($ubah) {
                    echo '<script>alert("Berhasil mengupdate data!"); window.location.href = "data_barang.php";</script>';
                } else {
                    echo '<script>alert("Gagal mengupdate data!"); window.location.href = "data_barang.php";</script>';
                }
            } else {
                echo '<script>alert("Ukuran File Terlalu Besar Max 1MB!"); window.location.href = "data_barang.php";</script>';
            }
        } else {
            echo '<script>alert("Ekstensi File yang di upload tidak diperbolehkan!"); window.location.href = "data_barang.php.";</script>';
        }
    } else {
        $ubah = mysqli_query($koneksi, "UPDATE produk SET
                                        NamaProduk = '$_POST[NamaProduk]',
                                        Harga = '$_POST[Harga]',
                                        Stok = '$_POST[Stok]'
                                        WHERE ProdukID = '$_POST[idb]'");
        if ($ubah) {
            echo '<script>alert("Berhasil mengupdate data!"); window.location.href = "data_barang.php";</script>';
        } else {
            echo '<script>alert("Gagal mengupdate data!"); window.location.href = "data_barang.php";</script>';
        }
    }
}
?>
