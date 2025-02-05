<?php
// proses_pendaftaran.php

if (isset($_POST['submit'])) {
    // Koneksi ke database
    $conn = mysqli_connect('localhost', 'root', '', 'konser');
    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
    }

    // Fungsi untuk membersihkan input dari potensi serangan XSS
    function clean_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Ambil data dari form dan bersihkan
    $nama_pemesan = clean_input($_POST['nama_pemesan']);
    $email = clean_input($_POST['email']);
    $no_telp = clean_input($_POST['no_telp']);
    $jenis_tiket = clean_input($_POST['jenis_tiket']);
    $jumlah_tiket = clean_input($_POST['jumlah_tiket']);
    $metode_pembayaran = clean_input($_POST['metode_pembayaran']);

    // Validasi data (tambahkan validasi lain jika diperlukan)
    $errors = [];
    if (empty($nama_pemesan) || empty($email) || empty($no_telp) || empty($jenis_tiket) || empty($jumlah_tiket) || empty($metode_pembayaran)) {
        $errors[] = "Semua field harus diisi.";
    }

    $uploadOk = 1; // Inisialisasi $uploadOk

    // Proses upload bukti pembayaran jika ada
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
        $target_dir = "uploads/"; // Direktori penyimpanan file

        // Buat direktori uploads jika belum ada
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) { // 0777 untuk izin penuh, ganti dengan yang lebih spesifik setelah dicoba
                $errors[] = "Gagal membuat direktori uploads. Pastikan web server memiliki izin untuk menulis ke direktori ini.";
                $uploadOk = 0;
            }
        }

        if ($uploadOk == 1) {
            $file_name = uniqid() . "_" . basename($_FILES["bukti_pembayaran"]["name"]); // Nama file unik
            $target_file = $target_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validasi file
            $image_type = exif_imagetype($_FILES["bukti_pembayaran"]["tmp_name"]);
            if ($image_type === false) {
                $errors[] = "File bukan gambar.";
                $uploadOk = 0;
            }

            // Cek ukuran file
            if ($_FILES["bukti_pembayaran"]["size"] > 500000) {
                $errors[] = "Ukuran file terlalu besar.";
                $uploadOk = 0;
            }

            // Hanya izinkan beberapa tipe file
            $allowed_types = ["jpg", "png", "jpeg", "gif"];
            if (!in_array($imageFileType, $allowed_types)) {
                $errors[] = "Hanya file JPG, PNG, JPEG, dan GIF yang diizinkan.";
                $uploadOk = 0;
            }

            // Jika validasi file gagal
            if ($uploadOk == 0) {
                $errors[] = "Maaf, file Anda tidak dapat diupload.";
            } else {
                // Jika semua validasi berhasil, coba upload file
                if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
                    $bukti_pembayaran = $file_name;
                } else {
                    $errors[] = "Gagal mengupload file. Pastikan direktori uploads memiliki izin yang benar.";
                    $uploadOk = 0; // Set $uploadOk ke 0 jika upload gagal
                }
            }
        }
    } else {
        $errors[] = "Bukti pembayaran harus diupload.";
        $uploadOk = 0; // Set $uploadOk ke 0 jika tidak ada file yang diupload
    }

    // Jika tidak ada error dan file berhasil diupload, masukkan data ke database
    if (empty($errors) && $uploadOk == 1) { // Tambahkan pengecekan $uploadOk
        // Gunakan prepared statements untuk mencegah SQL injection
        $stmt = $conn->prepare("INSERT INTO tiket (nama_pemesan, email, no_telp, jenis_tiket, jumlah_tiket, metode_pembayaran, bukti_pembayaran)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $nama_pemesan, $email, $no_telp, $jenis_tiket, $jumlah_tiket, $metode_pembayaran, $bukti_pembayaran);

        if ($stmt->execute()) {
            // Redirect ke halaman sukses atau tampilkan pesan sukses
            header("Location: sukses.php"); // Ganti sukses.php dengan halaman yang sesuai
            exit();
        } else {
            $errors[] = "Terjadi kesalahan saat menyimpan data ke database: " . $stmt->error;
        }

        $stmt->close();
    }

    // Tutup koneksi database
    $conn->close();
}
?>