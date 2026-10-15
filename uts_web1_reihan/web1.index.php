<?php
// index.php
require_once 'includes/header.php';

// Logic Cookie dan GET Kategori Favorit
$kategori_dipilih = 'Semua';

// 1. Cek dari Cookie terlebih dahulu jika ada
if (isset($_COOKIE['kategori_favorit']) && in_array($_COOKIE['kategori_favorit'], $kategori_valid)) {
    $kategori_dipilih = $_COOKIE['kategori_favorit'];
}

// 2. Jika ada parameter GET, prioritaskan nilai GET & perbarui cookie selama 7 hari
if (isset($_GET['kategori'])) {
    $get_kategori = $_GET['kategori'];
    if (in_array($get_kategori, $kategori_valid)) {
        $kategori_dipilih = $get_kategori;
        setcookie('kategori_favorit', $kategori_dipilih, time() + (7 * 24 * 60 * 60), "/");
    }
}

// Logic Pencarian berbasis GET
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

// Proses Filter Array Menu
$menu_tampil = [];
foreach ($menu_kantin as $item) {
    // Filter Kategori
    if ($kategori_dipilih !== 'Semua' && $item['kategori'] !== $kategori_dipilih) {
        continue;
    }
    // Filter Kata Kunci Pencarian (Case Insensitive)
    if ($keyword !== '' && stripos($item['nama'], $keyword) === false) {
        continue;
    }
    $menu_tampil[] = $item;
}
?>

<h2>Daftar Menu Kantin</h2>

<div class="filter-box">
    <form method="GET" action="index.php">
        <label for="kategori">Kategori Favorit: </label>
        <select name="kategori" id="kategori" onchange="this.form.submit()">
            <?php foreach ($kategori_valid as $kat): ?>
                <option value="<?= esc($kat); ?>" <?= $kategori_dipilih === $kat ? 'selected' : ''; ?>><?= esc($kat); ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="text" name="search" placeholder="Cari nama menu..." value="<?= esc($keyword); ?>" style="padding: 6px; width: 200px; margin-left: 15px;">
        <button type="submit" class="btn btn-warning" style="padding: 6px 12px;">Cari</button>
        <a href="index.php" style="margin-left: 10px; font-size: 14px;">Reset</a>
    </form>
    <p style="font-size: 12px; color: #777; margin-top: 5px;">Preferensi aktif saat ini: <strong><?= esc($kategori_dipilih); ?></strong></p>
</div>

<?php if (empty($menu_tampil)): ?>
    <div class="alert alert-danger">
        Menu dengan pencarian kata kunci "<strong><?= esc($keyword); ?></strong>" di kategori ini tidak ditemukan!
    </div>
<?php else: ?>
    <div class="menu-grid">
        <?php foreach ($menu_tampil as $menu): ?>
            <div class="menu-card">
                <h3><?= esc($menu['nama']); ?></h3>
                <p><span class="badge"><?= esc($menu['kategori']); ?></span></p>
                <p>Harga: <strong>Rp <?= number_format($menu['harga'], 0, ',', '.'); ?></strong></p>
                <hr>
                <form action="proses.php" method="POST">
                    <input type="hidden" name="aksi" value="tambah">
                    <input type="hidden" name="kode_menu" value="<?= esc($menu['kode']); ?>">
                    <label for="jumlah_<?= esc($menu['kode']); ?>">Jumlah:</label>
                    <input type="number" id="jumlah_<?= esc($menu['kode']); ?>" name="jumlah" value="1" min="0" max="15" style="width: 50px; padding: 4px;">
                    <button type="submit" class="btn btn-primary" style="padding: 4px 10px; font-size: 13px;">+ Pesan</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>