<?php
// includes/fungsi.php

function hitung_pembayaran($keranjang) {
    $subtotal = 0;
    foreach ($keranjang as $item) {
        $subtotal += $item['harga'] * $item['jumlah'];
    }
    
    $diskon = 0;
    if ($subtotal >= 50000) {
        $diskon = 0.10 * $subtotal;
    }
    
    $total_akhir = $subtotal - $diskon;
    
    return [
        'subtotal' => $subtotal,
        'diskon' => $diskon,
        'total_akhir' => $total_akhir
    ];
}

function esc($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function set_flash($pesan, $tipe = 'success') {
    $_SESSION['flash'] = [
        'pesan' => $pesan,
        'tipe' => $tipe
    ];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}