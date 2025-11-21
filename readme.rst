# 🚗 Sistem Rental Mobil dengan Metode SERVQUAL

Proyek ini merupakan aplikasi **Rental Mobil** yang dilengkapi dengan **metode SERVQUAL**, **notifikasi WhatsApp**, dan fitur manajemen lengkap. Sistem ini dibangun untuk membantu pemilik usaha rental meningkatkan kualitas layanan, mengelola transaksi, dan memudahkan pelanggan dalam melakukan pemesanan.

---

## 🔧 Teknologi yang Digunakan

* **Backend**: CodeIgniter 3
* **Database**: MySQL
* **Frontend**: HTML, CSS, JavaScript, Bootstrap
* **Notifikasi**: WhatsApp Gateway / API
* **Metode Analisis**: SERVQUAL (Service Quality)
* **UI/UX**: Landing Page modern & responsif

---

## 👥 Role Pengguna

Sistem mendukung beberapa role dengan hak akses masing-masing:

* **Pemilik**

  * Melihat laporan pendapatan
  * Melihat grafik performa layanan berdasarkan SERVQUAL
  * Monitoring aktivitas admin & karyawan

* **Admin**

  * Kelola data mobil
  * Kelola transaksi
  * Kelola pelanggan
  * Mengirim notifikasi WhatsApp
  * Kelola jadwal peminjaman

* **Karyawan**

  * Input transaksi
  * Cek ketersediaan mobil
  * Proses pengembalian

* **Pelanggan**

  * Registrasi & login
  * Pesan mobil
  * Menerima notifikasi WA untuk status pemesanan

---

## ⭐ Fitur Utama

### 🔹 1. **Landing Page Keren & Responsif**

* Menampilkan informasi layanan rental
* Menampilkan daftar mobil tersedia
* Formulir pemesanan cepat

### 🔹 2. **Manajemen Data Mobil**

* Tambah, ubah, hapus data unit mobil
* Upload foto mobil
* Status ketersediaan secara realtime

### 🔹 3. **Transaksi Rental Lengkap**

* Pemesanan mobil oleh pelanggan
* Konfirmasi admin
* Pengembalian mobil
* Hitung total biaya otomatis

### 🔹 4. **Notifikasi WhatsApp**

* Notifikasi pemesanan berhasil
* Notifikasi pengingat pengembalian
* Notifikasi konfirmasi / penolakan pemesanan

### 🔹 5. **Metode SERVQUAL**

Dipakai untuk mengukur kualitas layanan dari aspek:

* **Tangibles** (bukti fisik)
* **Reliability** (keandalan)
* **Responsiveness** (ketanggapan)
* **Assurance** (jaminan)
* **Empathy** (empati)

Hasil analisis ditampilkan dalam bentuk grafik & laporan.

### 🔹 6. **Manajemen Pengguna & Role**

* Akses fitur berdasarkan role
* Log aktivitas

### 🔹 7. **Laporan & Statistik**

* Laporan transaksi
* Laporan pendapatan
* Grafik kualitas layanan berbasis SERVQUAL

---

## 🗄️ Struktur Database (Ringkas)

* `users` — Data pengguna
* `mobil` — Data kendaraan
* `pelanggan` — Data pelanggan
* `pemesanan` — Transaksi pemesanan
* `pengembalian` — Data pengembalian
* `servqual` — Penilaian kualitas layanan
* `notifikasi` — Riwayat notifikasi WA

---

## 📦 Cara Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/username/rental-mobil-servqual.git
   ```
2. Import database dari folder `database/`.
3. Atur konfigurasi database di:

   ```
   application/config/database.php
   ```
4. Atur base URL di:

   ```
   application/config/config.php
   ```
5. Jalankan project melalui localhost:

   ```
   http://localhost/rental-mobil
   ```

---

## 📞 Kontak

Jika ingin menggunakan, memodifikasi, atau membutuhkan versi custom, silakan menghubungi:
**Nama Developer**: *(diisi sesuai kebutuhan)*

---

## 📜 Lisensi

Project ini menggunakan lisensi bebas sesuai kebutuhan pengguna.

---
