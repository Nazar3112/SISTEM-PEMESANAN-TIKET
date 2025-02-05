# SISTEM-PEMESANAN-TIKET
# Aplikasi Pemesanan Tiket Konser

Aplikasi web ini memungkinkan pengguna untuk memesan tiket konser secara online. Admin dapat mengelola data pemesanan, menyetujui pemesanan, dan mengirim email konfirmasi kepada pengguna.

## Fitur-fitur

*   **Pemesanan Tiket**: Pengguna dapat melihat daftar konser yang tersedia, memilih jenis tiket, dan memesan tiket.
*   **Manajemen Pemesanan (Admin)**: Admin dapat melihat daftar pemesanan, menyetujui pemesanan, dan menghapus pemesanan yang tidak valid.
*   **Email Konfirmasi**: Pengguna akan menerima email konfirmasi setelah pemesanan mereka disetujui oleh admin. Email berisi detail tiket dan kode unik.
*   **Pencarian Data**: Admin dapat mencari data pemesanan berdasarkan nama pemesan, email, atau nomor telepon.
*   **Pagination**: Data pemesanan ditampilkan dalam halaman-halaman untuk memudahkan navigasi.
*   **Keamanan**: Aplikasi ini dilengkapi dengan fitur keamanan dasar, seperti *sanitasi input* untuk mencegah serangan XSS dan penyimpanan *password* yang di-*hash*.

## Teknologi yang Digunakan

*   **Bahasa Pemrograman**: PHP
*   **Database**: MySQL
*   **Library Email**: PHPMailer
*   **Framework CSS**: Bootstrap
*   **JavaScript**: jQuery (untuk AJAX)

## Cara Instalasi

1.  Clone repositori ini ke *local machine* Anda:

    ```bash
    git clone [https://github.com/Nazar3112/SISTEM-PEMESANAN-TIKET.git](https://www.google.com/search?q=https://github.com/Nazar3112/SISTEM-PEMESANAN-TIKET.git)
    ```

2.  Buat *database* MySQL dengan nama `konser` dan impor *file* SQL yang disertakan (jika ada).

3.  Konfigurasi koneksi *database* di *file* `config.php` (jika ada) atau langsung di *file* yang membutuhkan koneksi ke *database*.

4.  Instal PHPMailer dengan Composer (disarankan) atau secara manual. Jika menggunakan Composer, jalankan perintah berikut di direktori proyek Anda:

    ```bash
    composer require phpmailer/phpmailer
    ```

5.  Jika menginstal PHPMailer secara manual, ekstrak arsip PHPMailer ke direktori proyek Anda dan sesuaikan *path* `require` di *file* `approve.php`.

6.  Konfigurasi pengaturan *SMTP* di *file* `approve.php` sesuai dengan *mail server* yang Anda gunakan.

7.  Buka aplikasi web Anda di *browser*.

## Cara Penggunaan

1.  Akses halaman *login* dan masukkan *username* dan *password* Anda.
2.  Jika Anda adalah admin, Anda akan diarahkan ke halaman admin untuk mengelola data pemesanan.
3.  Jika Anda adalah pengguna, Anda akan diarahkan ke halaman pemesanan untuk memesan tiket.

## Struktur Kode

*   `index.php`: Halaman utama atau *landing page*.
*   `sign-in.php`: Halaman *login*.
*   `register.php`: Halaman pendaftaran pengguna baru.
*   `pendaftaran.php`: Halaman pemesanan tiket (untuk pengguna).
*   `admin_form.php`: Halaman admin untuk mengelola data pemesanan.
*   `approve.php`: *File* yang menangani proses persetujuan pemesanan dan pengiriman email.
*   `config.php`: *File* konfigurasi *database* (jika ada).
*   `style/`: Direktori yang berisi *file-file CSS.
*   `phpmailer/`: Direktori yang berisi *library* PHPMailer (jika diinstal secara manual).

## Kontribusi

Silakan kirim *pull request* jika Anda ingin berkontribusi pada proyek ini.

## Lisensi

[Pilih lisensi yang sesuai]

## Catatan

README ini masih dalam pengembangan dan akan terus diperbarui.
