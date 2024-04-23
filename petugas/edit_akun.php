<?php
include '../koneksi.php';

if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $username = $_POST['edit_username'];
    $password = $_POST['edit_password'];
    $level = $_POST['edit_level'];

    $query = "UPDATE user SET username='$username', password='$password', level='$level' WHERE id='$id'";
    $statement = mysqli_query($koneksi, $query);

    header('Location: register.php');
    exit();
}
?>
