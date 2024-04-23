<?php
session_start(); // Mulai session

// Definisikan atau set $_SESSION['cart'] jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // Misalnya, inisialisasi sebagai array kosong
}

// Definisi array $items dengan data produk
$items = array(
    array('name' => 'Produk 1', 'image' => 'img/img1.png', 'price' => 10000),
    array('name' => 'Produk 2', 'image' => 'img/img2.png', 'price' => 15000),
    array('name' => 'Produk 3', 'image' => 'img/img3.png', 'price' => 20000)
);

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pelanggan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-BGBi0EH8Rvzsd3bXUw7mrT6ZsCxN4zXdp+H7ZSOhj49/zwPrIBNHzWzHGXabH/Jq42lSh2RSepOO32Qc0VYfCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('../img/bg2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: absolute;
        }

        .content {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 10px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 15px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }

        .card-img-top {
            max-height: 200px;
            object-fit: contain;
        }

        .cart-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 24px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .order-button {
            position: fixed;
            bottom: 20px;
            right: 90px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .sidebar.show {
            right: 0;
        }

        .sidebar-close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-close-btn" onclick="toggleCart()">
            <i class="fas fa-times"></i>
        </div>
        <h2>Order</h2>
        <div id="sidebar-cart-items">
            <!-- Isi keranjang belanja ditampilkan di sini -->
        </div>
        <div class="sidebar-checkout">
            <button onclick="checkout()" class="btn btn-success">
                <a href="pembelian.php" style="text-decoration: none; color: white;">Pesan Sekarang</a>
            </button>
            <div id="subtotal">Subtotal: Rp 0</div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="payment" name="payment" placeholder="Masukkan jumlah bayar" oninput="this.value = formatRupiah(this.value)">
            </div>
            <div id="change">Kembalian: Rp 0</div>
        </div>
    </div>
    <div class="content">
        <div class="textBox">
            <h2 style="font-size: 2em;">Iced beverages</h2>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row" id="item-list">
            <!-- List item ditampilkan di sini -->
            <?php foreach ($items as $index => $item) : ?>
                <!-- Perulangan untuk menampilkan item -->
                <div class="card col-md-4 mb-3" style="width: 18rem; margin-right: 20px;">
                    <img src="<?= $item['image']; ?>" class="card-img-top" alt="<?= $item['name']; ?>">
                    <div class="card-body">
                        <p class="card-text"><?= $item['name']; ?></p>
                        <p class="card-text">Harga: <?= number_format($item['price'], 0, ',', '.'); ?></p>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="quantity<?= $index; ?>" value="1" min="1">
                        </div>
                        <button onclick="addToCart('<?= $item['name']; ?>', <?= $item['price']; ?>, <?= $index; ?>)" class="btn btn-success">Order</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="content">
        <div class="textBox">
            <h2 style="font-size: 2em;">Food</h2>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row" id="item-list">
            <!-- List item ditampilkan di sini -->
            <?php foreach ($items as $index => $item) : ?>
                <div class="card col-md-4 mb-3" style="width: 18rem; margin-right: 20px;">
                    <img src="<?= $item['image']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text"><?= $item['name']; ?></p>
                        <p class="card-text">Harga: <?= number_format($item['price'], 0, ',', '.'); ?></p>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="quantity<?= $index; ?>" value="1" min="1">
                        </div>
                        <button onclick="addToCart('<?= $item['name']; ?>', <?= $item['price']; ?>, <?= $index; ?>)" class="btn btn-success">Order</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="row" id="cart">
            <!-- Keranjang belanja ditampilkan di sini -->
        </div>
    </div>

    <script>
        // Array untuk menyimpan barang yang dipilih beserta quantity
        let selectedItems = [];

        // Fungsi untuk menambahkan barang ke keranjang
        function addToCart(name, price, index) {
            const quantity = document.getElementById("quantity" + index).value;
            const cart = document.getElementById("cart");
            const cartItem = `
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <p class="card-text">${name} (x${quantity})</p>
                        <p class="card-text">Harga: ${price * quantity}</p>
                        <button onclick="removeItem(${index})" class="btn btn-danger">Batalkan</button>
                    </div>
                </div>
            `;
            cart.innerHTML += cartItem;

            // Menambah barang yang dipilih ke dalam array
            selectedItems.push({ name: name, price: price, quantity: quantity });

            updateSubtotal(); // Memperbarui subtotal setelah menambah barang ke keranjang
            toggleCart(); // Menampilkan sidebar setelah menambahkan item ke keranjang
        }

        // Fungsi untuk membatalkan produk yang akan dipesan
        function removeItem(index) {
            selectedItems.splice(index, 1); // Menghapus item dari array
            const cart = document.getElementById("cart");
            cart.removeChild(cart.childNodes[index]); // Menghapus tampilan item dari keranjang
            updateSubtotal(); // Memperbarui subtotal setelah menghapus item

            // Memastikan sidebar tetap ditampilkan setelah menghapus item
            const sidebar = document.querySelector(".sidebar");
            sidebar.classList.add("show");
        }

        // Fungsi untuk memperbarui subtotal
        function updateSubtotal() {
            const subtotalElement = document.getElementById("subtotal");
            let subtotal = 0;
            selectedItems.forEach(item => {
                subtotal += item.price * item.quantity;
            });
            subtotalElement.innerText = "Subtotal: " + formatRupiah(subtotal);
        }

        // Fungsi untuk menampilkan atau menyembunyikan keranjang belanja
        function toggleCart() {
            const sidebar = document.querySelector(".sidebar");
            sidebar.classList.add("show"); // Menambah kelas .show ke sidebar
        }

        // Fungsi untuk checkout
        function checkout() {
            const subtotalElement = document.getElementById("subtotal");
            const paymentElement = document.getElementById("payment");
            const subtotal = parseFloat(subtotalElement.innerText.replace("Subtotal: Rp ", "").replace(".", "").replace(",", ""));
            const payment = parseFloat(paymentElement.value.replace(".", "").replace(",", ""));
            let change = payment - subtotal;
            if (change >= 0) {
                alert(`Total pesanan Anda: ${subtotalElement.innerText}\nKembalian Anda: Rp ${formatRupiah(change)}`);
            } else {
                // alert("Jumlah bayar tidak mencukupi!");
            }

            // Reset selected items
            selectedItems = [];
            const cart = document.getElementById("cart");
            cart.innerHTML = ''; // Menghapus semua isi keranjang
            updateSubtotal(); // Memperbarui subtotal setelah reset

            // Reset jumlah bayar
            paymentElement.value = "";

            // Reset kembalian
            document.getElementById("change").innerText = "Kembalian: Rp 0";
        }

        // Fungsi untuk menambahkan event listener pada input pembayaran
        document.getElementById("payment").addEventListener("input", function () {
            const payment = parseFloat(this.value.replace(".", "").replace(",", ""));
            const subtotalElement = document.getElementById("subtotal");
            const subtotal = parseFloat(subtotalElement.innerText.replace("Subtotal: Rp ", "").replace(".", "").replace(",", ""));
            const change = payment - subtotal;
            if (change >= 0) {
                document.getElementById("change").innerText = "Kembalian: Rp " + formatRupiah(change);
            } else {
                document.getElementById("change").innerText = "Kembalian: Rp 0";
            }
        });

        // Fungsi untuk memformat harga dalam mata uang Rupiah
        function formatRupiah(angka) {
            var number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
