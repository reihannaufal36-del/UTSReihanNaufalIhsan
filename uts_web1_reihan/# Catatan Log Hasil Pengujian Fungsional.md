# Catatan Log Hasil Pengujian Fungsional Sistem Aplikasi

Dokumentasi ini mencatat hasil evaluasi validasi sistem pemesanan berdasarkan 11 daftar skenario wajib.

| ID | Skenario Uji dan Variasi Input | Hasil yang Diharapkan | Hasil Aktual | Status | Tautan Bukti Screenshot |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **U01** | Buka halaman utama daftar menu awal | Menampilkan minimal 5 data menu lengkap harga & kategori | Sesuai ekspektasi, data tampil teratur | **Lulus** | `[Buka Gambar](01-daftar-menu.png)` |
| **U02a** | Cari menu yang valid ("Ayam") | Menu Ayam Geprek muncul di layar | Berhasil memfilter data menu | **Lulus** | `[Buka Gambar](02a-cari-ada.png)` |
| **U02b** | Cari menu tidak dikenal ("Pizza") | Muncul notifikasi pesan kesalahan merah pencarian kosong | Pesan kesalahan tampil rapi | **Lulus** | `[Buka Gambar](02b-cari-kosong.png)` |
| **U03a** | Kirim jumlah input bernilai kosong | Ditolak sistem, memunculkan flash message kesalahan | Berhasil diblokir sistem | **Lulus** | `[Buka Gambar](03a-jumlah-kosong.png)` |
| **U03b** | Kirim jumlah berangka negatif (`-2`) | Ditolak sistem, keranjang tidak berubah nilainya | Berhasil diblokir sistem | **Lulus** | `[Buka Gambar](03b-jumlah-negatif.png)` |
| **U03c** | Kirim jumlah angka pecahan (`1.5`) | Sistem menolak input pecahan | Berhasil diblokir sistem | **Lulus** | `[Buka Gambar](03c-jumlah-pecahan.png)` |
| **U03d** | Kirim jumlah pesanan bernilai angka 0 | Mengeluarkan peringatan minimal pemesanan 1 item | Berhasil diblokir sistem | **Lulus** | `[Buka Gambar](03d-jumlah-nol.png)` |
| **U03e** | Kirim jumlah pesanan melebihi batas (`11`) | Mengeluarkan peringatan kuantitas maksimal sekali pesan 10 | Berhasil diblokir sistem | **Lulus** | `[Buka Gambar](03e-jumlah-lebih-10.png)` |
| **U04** | Ubah value kode menu lewat DevTools (`M99`) | Sistem menolak karena kode tidak terdaftar di server | Error tertangani dengan baik | **Lulus** | `[Buka Gambar](04-kode-palsu.png)` |
| **U05a** | Tambah item yang sama 2x hingga jumlah pas 10 | Kuantitas terakumulasi sempurna menjadi angka 10 | Nilai berhasil digabung | **Lulus** | `[Buka Gambar](05a-gabung-pas-10.png)` |
| **U05b** | Tambah lagi item saat jumlah sudah mencapai 10 | Sistem memblokir dan mempertahankan isi jumlah bernilai 10 | Penambahan digagalkan otomatis | **Lulus** | `[Buka Gambar](05b-tolak-lewat-10.png)` |
| **U06** | Pindah halaman utama ke keranjang & refresh | Data keranjang tetap presisten aman tersimpan di session | Session tersimpan konstan | **Lulus** | `[Buka Gambar](06-persistensi-session.png)` |
| **U07** | Lakukan pemesanan makanan via POST, lalu refresh | Sukses redirect halaman, pesan sukses tampil, refresh aman | Tidak terjadi duplikasi data | **Lulus** | `[Buka Gambar](07-prg-redirect.png)` |
| **U08a** | Uji total belanja senilai Rp49.000 | Nominal potongan diskon tertulis Rp0, total bayar Rp49.000 | Nilai hitung akurat | **Lulus** | `[Buka Gambar](08a-subtotal-49k.png)` |
| **U08b** | Uji total belanja senilai Rp50.000 | Diskon 10% aktif (Rp5.000), total bayar akhir menjadi Rp45.000 | Perhitungan matematika tepat | **Lulus** | `[Buka Gambar](08b-subtotal-50k.png)` |
| **U09a** | Klik tombol hapus pada satu item tertentu | Item keluar dari daftar, kalkulasi harga otomatis berkurang | Item terhapus sukses | **Lulus** | `[Buka Gambar](09a-hapus-satu.png)` |
| **U09b** | Tekan opsi hapus seluruh isi kosongkan keranjang | Keranjang bersih, muncul info bahwa keranjang masih kosong | Seluruh data session terhapus | **Lulus** | `[Buka Gambar](09b-kosongkan-semua.png)` |
| **U10a** | Pilih kategori favorit "Minuman" (Tanpa GET) | Preferensi kategori tersimpan dalam cookie selama 7 hari | Cookie tercatat di browser | **Lulus** | `[Buka Gambar](10a-cookie-kategori.png)` |
| **U10b** | Mengirimkan parameter kategori via link URL GET | Sistem mendahulukan memuat kategori GET dibanding cookie | GET sukses diprioritaskan | **Lulus** | `[Buka Gambar](10b-get-kategori.png)` |
| **U11** | Memasukkan kode HTML script `<b>uji</b>` di pencarian | Kata kunci tercetak murni teks string biasa (ter-escaping) | Aman dari serangan injeksi XSS | **Lulus** | `[Buka Gambar](11-escaping-xss.png)` |