<?php
// proses.php
session_start();
require_once 'data/menu.php';
require_once 'includes/fungsi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : '';

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if ($aksi === 'tambah') {
    $kode_menu = isset($_POST['kode_menu']) ? trim($_POST['kode_menu']) : '';
    $jumlah_input = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';

    $menu_ditemukan = null;
    foreach ($menu_kantin as $menu) {
        if ($menu['kode'] === $kode_menu) {
            $menu_ditemukan = $menu;
            break;
        }
    }

    if (!$menu_ditemukan) {
        set_flash("Gagal! Kode produk menu tidak terdaftar di server.", "danger");
        header("Location: index.php");
        exit;
    }

    if ($jumlah_input === '' || !is_numeric($jumlah_input)) {
        set_flash("Gagal! Jumlah item pembelian wajib diisi angka.", "danger");
        header("Location: index.php");
        exit;
    }

    $jumlah = (float) $jumlah_input;
    if ($jumlah != floor($jumlah)) {
        set_flash("Gagal! Jumlah pembelian tidak boleh menggunakan angka pecahan.", "danger");
        header("Location: index.php");
        exit;
    }

    $jumlah = (int) $jumlah;

    if ($jumlah < 1 || $jumlah > 10) {
        set_flash("Gagal! Jumlah input pemesanan per sekali tambah harus berupa bilangan bulat antara 1 s.d. 10.", "danger");
        header("Location: index.php");
        exit;
    }

    $jumlah_sekarang = isset($_SESSION['keranjang'][$kode_menu]) ? $_SESSION['keranjang'][$kode_menu]['jumlah'] : 0;
    
    if (($jumlah_sekarang + $jumlah) > 10) {
        set_flash("Gagal! Total item '{$menu_ditemukan['nama']}' di keranjang melebihi batas maksimal 10 item. (Jumlah sekarang: {$jumlah_sekarang}).", "danger");
        header("Location: index.php");
        exit;
    }

    if (isset($_SESSION['keranjang'][$kode_menu])) {
        $_SESSION['keranjang'][$kode_menu]['jumlah'] += $jumlah;
    } else {
        $_SESSION['keranjang'][$kode_menu] = [
            'nama' => $menu_ditemukan['nama'],
            'harga' => $menu_ditemukan['harga'],
            'jumlah' => $jumlah
        ];
    }

    set_flash("Berhasil menambahkan {$jumlah} porsi {$menu_ditemukan['nama']} ke dalam keranjang belanja!", "success");
    header("Location: index.php");
    exit;
}

if ($aksi === 'hapus_item') {
    $kode_menu = isset($_POST['kode_menu']) ? trim($_POST['kode_menu']) : '';
    
    if (isset($_SESSION['keranjang'][$kode_menu])) {
        $nama_item = $_SESSION['keranjang'][$kode_menu]['nama'];
        unset($_SESSION['keranjang'][$kode_menu]);
        set_flash("Menu '{$nama_item}' telah dikeluarkan dari daftar pesanan.", "success");
    }
    
    header("Location: keranjang.php");
    exit;
}

if ($aksi === 'kosongkan') {
    $_SESSION['keranjang'] = [];
    set_flash("Seluruh isi keranjang belanja Anda telah berhasil dikosongkan.", "success");
    header("Location: keranjang.php");
    exit;
}

header("Location: index.php");
exit;