<?php
// includes/header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../data/menu.php';
require_once __DIR__ . '/fungsi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Kampus - Politeknik Ganesha Medan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🏪 Kantin Kampus Ganesha</h1>
            <nav>
                <a href="index.php">Daftar Menu</a> | 
                <a href="keranjang.php">Keranjang (<?= isset($_SESSION['keranjang']) ? array_sum(array_column($_SESSION['keranjang'], 'jumlah')) : 0; ?>)</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php 
        $flash = get_flash();
        if ($flash): 
        ?>
            <div class="alert alert-<?= esc($flash['tipe']); ?>">
                <?= esc($flash['pesan']); ?>
            </div>
        <?php endif; ?>