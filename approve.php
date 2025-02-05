<?php
// Koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'konser');
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// Fungsi untuk membersihkan input dari potensi serangan XSS
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk membuat kode unik
function generateUniqueCode($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

require 'phpmailer/src/PHPMailer.php'; // Sesuaikan dengan path yang benar
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Ambil data dari database berdasarkan ID
if (isset($_GET['id'])) {
    $id = clean_input($_GET['id']);
    $sql = "SELECT * FROM tiket WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Proses validasi dan pengiriman email
    if ($row['status'] == 'pending') { // Jika statusnya masih 'pending'
        // Update status menjadi 'approved'
        $sql_update = "UPDATE tiket SET status = 'approved' WHERE id = '$id'";
        if (mysqli_query($conn, $sql_update)) {
            // Generate kode unik
            $uniqueCode = generateUniqueCode();

            // Kirim email ke user menggunakan PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Konfigurasi server SMTP (sesuai dengan yang Anda gunakan)
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Ganti dengan server SMTP Anda
                $mail->SMTPAuth = true;
                $mail->Username = 'ucupsucipto6@gmail.com'; // Ganti dengan username Gmail Anda
                $mail->Password = 'oczf zgpr sqjm dkwz'; // Ganti dengan password Gmail Anda
                $mail->SMTPSecure = 'ssl'; // Ganti dengan jenis enkripsi yang sesuai
                $mail->Port = 465; // Ganti dengan port yang sesuai (587 untuk TLS, 465 untuk SSL)

                // Pengirim dan Penerima
                $mail->setFrom('ucupsucipto6@gmail.com', 'Admin Konser'); // Ganti dengan email admin Anda
                $mail->addAddress($row['email'], $row['nama_pemesan']); // Gunakan data dari database

                // Subjek dan Isi
                $mail->Subject = "Pendaftaran Tiket Konser Disetujui";
                $mail->Body = "Selamat, pendaftaran tiket konser Anda telah disetujui!\n\nBerikut adalah detail tiket Anda:\n\nNama: " . $row['nama_pemesan'] . "\nEmail: " . $row['email'] . "\nNo. Telp: " . $row['no_telp'] . "\nJenis Tiket: " . $row['jenis_tiket'] . "\nJumlah Tiket: " . $row['jumlah_tiket'] . "\nMetode Pembayaran: " . $row['metode_pembayaran'] . "\n\nKode Unik Tiket Anda: " . $uniqueCode . "\n\nTerima kasih telah mendaftar!";

                $mail->send();
                echo '<script>alert("Email berhasil dikirim ke ' . $row['email'] . '");
                window.location.href = "admin_form.php"; // Redirect ke admin_form.php
                </script>';
            } catch (Exception $e) {
                echo "Gagal mengirim email. Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
        }
    } else {
        echo '<script>alert("DATA INI SUDAH DI-APPROVE SEBELUMNYA!");
        window.location.href = "admin_form.php"; // Redirect ke admin_form.php
        </script>';
    }
}
?>