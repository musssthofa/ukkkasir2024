<?php
include '../koneksi.php';

if(isset($_POST['tambah'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // Hash password


    $query = "INSERT INTO user (username, password, level) VALUES ('$username','$password','$level')";
    $statement = mysqli_query($koneksi, $query);

    header('Location: register.php');
    exit();
}
?>
