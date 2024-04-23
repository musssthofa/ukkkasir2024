// Fungsi untuk menambahkan barang ke keranjang
function addToCart(name, price, image) {
    const sidebarCartItems = document.querySelector(".sidebar-cart-items"); // Menggunakan querySelector
    const existingItem = sidebarCartItems.querySelector(`[data-name="${name}"]`);
    const quantity = existingItem ? parseInt(existingItem.getAttribute('data-quantity')) + 1 : 1;
    const totalPrice = price * quantity;
    const sidebarCartItem = `
        <div class="card" style="width: 18rem;" data-name="${name}" data-quantity="${quantity}" data-price="${price}">
            <img src="${image}" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">${name}</p>
                <p class="card-text">Harga: ${price}</p>
                <p class="card-text">Jumlah: ${quantity}</p>
                <p class="card-text">Total: ${totalPrice}</p>
            </div>
        </div>
    `;
    if (existingItem) {
        existingItem.outerHTML = sidebarCartItem;
    } else {
        sidebarCartItems.innerHTML += sidebarCartItem;
    }

    toggleCart(); // Menampilkan sidebar setelah menambahkan item ke keranjang

    // Perbarui subtotal
    const subtotalElement = document.getElementById("subtotal");
    let subtotal = parseFloat(subtotalElement.innerText.split(": ")[1].replace("Rp ", "").replace(",", ""));
    subtotal += price;
    subtotalElement.innerText = `Subtotal: Rp ${subtotal.toLocaleString()}`;
}
