<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="gaya.css">

    <style>
        body {
            background: none;
        }

        .navigation {
            background-color: #f8f9fa;
            /* Ganti warna latar belakang sesuai kebutuhan */
            border-radius: 20px;
            /* Atur nilai border-radius sesuai keinginan */
            padding: 10px 20px;
            /* Atur padding sesuai kebutuhan */
        }
    </style>
</head>

<body>
    <header>
    <a href="#"><img src="logo.png" class="logo"></a>
    <nav class="navigation">
        <a href="index.php" class="active">Home<span></span></a>
        <a href="data_barang.php">Data Barang<span></span></a>
        <a href="stock_barang.php">Stock Barang<span></span></a>
        <a href="register.php">Registrasi<span></span></a>
        <a href="../logout.php">Keluar<span></span></a>
    </nav>
    </header>

    <div class="container">
    <div class="content">
            <div class="textBox">
                <h2>It's not just Coffee <br>It's <span>Starbucks</span></h2>
                <p></p>
            </div>
    </div>
    

    <script src="script.js"></script>
</body>

</html>


