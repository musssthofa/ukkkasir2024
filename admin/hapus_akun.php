<?php
include '../koneksi.php';

if(isset($_POST['hapus'])){
    $id = $_POST['id'];

    $query = "DELETE FROM user WHERE id=?";
    $statement = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($statement, 'i', $id); // ikat parameter ke pernyataan
    mysqli_stmt_execute($statement); // eksekusi pernyataan
    mysqli_stmt_close($statement);

    header('Location: register.php');
    exit();
}
?>
