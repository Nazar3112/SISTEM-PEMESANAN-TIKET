<?php
session_start();

// Jika sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['username'])) {
    // Periksa role dan redirect
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_form.php");
    } else {
        header("Location: pendaftaran.php");
    }
    exit();
}

$error = "";

// Proses login ketika form disubmit
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Koneksi ke database
    $conn = mysqli_connect('localhost', 'root', '', 'konser');
    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
    }

    // Query untuk validasi user (ambil semua data user berdasarkan username)
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password_from_db = $row['password']; // Ambil hash password dari database

        // Verifikasi password menggunakan password_verify()
        if (password_verify($password, $hashed_password_from_db)) {
            // Password cocok, user berhasil login
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            $_SESSION['last_activity'] = time(); // Waktu aktivitas terakhir

            // Redirect sesuai role
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin_form.php"); // Redirect ke dashboard admin
            } else {
                header("Location: pendaftaran.php"); // Redirect ke dashboard user
            }
            exit();
        } else {
            $error = "Username atau password salah."; // Password tidak cocok
        }
    } else {
        $error = "Username atau password salah."; // Username tidak ditemukan
    }

    mysqli_close($conn);
}

    // Pengecekan waktu aktivitas (di setiap request)
    if (isset($_SESSION['last_activity'])) {
        $inactive = 300; // 5 menit
        $session_life = time() - $_SESSION['last_activity'];

        if ($session_life > $inactive) {
            session_destroy();
            header("Location: sign-in.php"); // Redirect ke halaman login
            exit();
        }
    }

    $_SESSION['last_activity'] = time(); // Update waktu aktivitas setiap request
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Aplikasi CRUD</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/sign-in.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="sign-in.php">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <br>
                        <a href="register.php" class="btn btn-secondary btn-block">Don't have account? Register</a>
                    </div>
                    <div class="card-footer text-muted text-center">
                    <p">&copy; 2025 ALFIYAN NAZAR. Made with ❤️</p>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    <!-- Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
