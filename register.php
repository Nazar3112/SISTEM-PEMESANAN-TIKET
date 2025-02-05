<?php
session_start();

// Jika sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: pendaftaran.php");
    exit();
}

$error = "";

// Proses registrasi ketika form disubmit
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input (tambahkan validasi lain jika diperlukan)
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua field harus diisi.";
    } elseif ($password != $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak cocok.";
    }

    if (empty($error)) { // Jika tidak ada error validasi
        // Koneksi ke database
        $conn = mysqli_connect('localhost', 'root', '', 'konser');
        if (!$conn) {
            die("Koneksi Gagal: " . mysqli_connect_error());
        }
        // Setelah validasi input dan sebelum insert ke database
        $role = isset($_POST['role']) ? $_POST['role'] : 'user'; // Ambil role dari form, defaultnya user

        // Query untuk insert data user baru (termasuk role)
        $insert_query = "INSERT INTO users (username, email, password, role) 
                        VALUES ('$username', '$email', '$hashed_password', '$role')";

        // Query untuk mengecek apakah username atau email sudah ada
        $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username atau email sudah terdaftar.";
        } else {
            // Hash password sebelum disimpan ke database (gunakan password_hash())
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Query untuk insert data user baru
            $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                // Registrasi berhasil, arahkan ke halaman login atau tampilkan pesan sukses
                header("Location: sign-in.php"); // Atau ke halaman sukses lainnya
                exit();
            } else {
                $error = "Terjadi kesalahan saat mendaftar: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style/sign-in.css">
    <title>Register - Aplikasi CRUD</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Create Account</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="register.php">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
                        </form>
                        <br>
                        <a href="sign-in.php" class="btn btn-secondary btn-block">Already have an account? Login</a>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <p>&copy; 2025 ALFIYAN NAZAR. Made with ❤️</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>