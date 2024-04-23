<?php

function hitungTotalBayar($koneksi) {
    $query = mysqli_query($koneksi, "SELECT SUM(Subtotal) as tot_bayar FROM detailpenjualan");
    $result = mysqli_fetch_assoc($query);
    
    // Pastikan hasil tidak null
    $tot_bayar = isset($result['tot_bayar']) ? $result['tot_bayar'] : 0;
    
    return array(
        'tot_bayar' => $tot_bayar,
    );
}


?>