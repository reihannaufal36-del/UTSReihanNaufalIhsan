<?php
// keranjang.php
require_once 'includes/header.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$perhitungan = hitung_pembayaran($keranjang);
?>

<h2>Keranjang Belanja Anda</h2>

<?php if (empty($keranjang)): ?>
    <div class="alert alert-danger">Keranjang kosong. Anda belum memilih menu makanan atau minuman apapun!</div>
    <p><a href="index.php" class="btn btn-warning">&larr; Kembali Lihat Menu</a></p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Menu</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($keranjang as $kode => $item): ?>
                <tr>
                    <td><?= esc($kode); ?></td>
                    <td><?= esc($item['nama']); ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td><?= esc($item['jumlah']); ?></td>
                    <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                    <td>
                        <form action="proses.php" method="POST" style="display:inline;">
                            <input type="hidden" name="aksi" value="hapus_item">
                            <input type="hidden" name="kode_menu" value="<?= esc($kode); ?>">
                            <button type="submit" class="btn btn-danger" style="padding: 3px 8px; font-size: 12px;">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            
            <tr style="background: #fdfdfd; font-weight: bold;">
                <td colspan="4" style="text-align: right;">Total Sebelum Diskon:</td>
                <td colspan="2">Rp <?= number_format($perhitungan['subtotal'], 0, ',', '.'); ?></td>
            </tr>
            <tr style="color: #c0392b; font-weight: bold;">
                <td colspan="4" style="text-align: right;">Diskon Potongan Harga (10% Min Rp 50.000):</td>
                <td colspan="2">- Rp <?= number_format($perhitungan['diskon'], 0, ',', '.'); ?></td>
            </tr>
            <tr style="background: #e1f5fe; font-size: 18px; font-weight: bold; color: #0277bd;">
                <td colspan="4" style="text-align: right;">Total Pembayaran Akhir:</td>
                <td colspan="2">Rp <?= number_format($perhitungan['total_akhir'], 0, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="index.php" class="btn btn-warning">&larr; Tambah Menu Lagi</a>
        
        <form action="proses.php" method="POST" style="display: inline; margin-left: 10px;">
            <input type="hidden" name="aksi" value="kosongkan">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin mengosongkan semua keranjang belanja ini?')">Kosongkan Keranjang</button>
        </form>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>