<?php
session_start(); // Mulai session

// Definisikan atau set $_SESSION['cart'] jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // Misalnya, inisialisasi sebagai array kosong
}

// Fungsi untuk memformat harga dalam mata uang Rupiah
function formatRupiah($angka) {
    $number_string = (string) $angka;
    $sisa = strlen($number_string) % 3;
    $rupiah = substr($number_string, 0, $sisa);
    $ribuan = substr($number_string, $sisa);

    if ($ribuan) {
        $separator = $sisa ? '.' : '';
        $rupiah .= $separator . join('.', str_split($ribuan, 3));
    }

    return 'Rp ' . $rupiah;
}

// Tambahkan item ke keranjang belanja
if(isset($_POST['addToCart'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Konversi price dan quantity ke tipe data numerik
    $price = floatval($price);
    $quantity = intval($quantity);

    $item = array(
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    );

    array_push($_SESSION['cart'], $item);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .item {
            margin-bottom: 10px;
        }
        .item-name {
            font-weight: bold;
        }
        .item-price {
            float: right;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn {
            display: block;
            margin-top: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="header">
            <h1>Struk Pembelian</h1>
        </div>
        <div class="items">
            <?php
            $total = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    echo '<div class="item">';
                    echo '<span class="item-name">' . $item['name'] . '</span>';
                    echo '<span class="item-price">' . formatRupiah($item['price']) . '</span>';
                    echo '<br>';
                    echo 'Quantity: ' . $item['quantity'];
                    echo '</div>';
                }
            } else {
                echo '<div class="item">Keranjang belanja kosong.</div>';
            }
            ?>
        </div>
        <div class="total">
            Total: <?= formatRupiah($total); ?>
        </div>
        <form action="pembelian.php" method="post">
            <button type="submit" name="pay" class="btn">Bayar</button>
            <button type="button" onclick="window.print()" class="btn">Print</button>
        </form>
    </div>
</body>
</html>
