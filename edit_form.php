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

// Ambil data dari database berdasarkan ID
if (isset($_GET['id'])) {
    $id = clean_input($_GET['id']);
    $sql = "SELECT * FROM tiket WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

// Proses update data jika form di-submit
if (isset($_POST['submit'])) {
    $id = clean_input($_POST['id']);
    $nama_pemesan = clean_input($_POST['nama_pemesan']);
    $email = clean_input($_POST['email']);
    $no_telp = clean_input($_POST['no_telp']);
    $jenis_tiket = clean_input($_POST['jenis_tiket']);
    $jumlah_tiket = clean_input($_POST['jumlah_tiket']);
    $metode_pembayaran = clean_input($_POST['metode_pembayaran']);

    $sql_update = "UPDATE tiket SET 
                    nama_pemesan = '$nama_pemesan',
                    email = '$email',
                    no_telp = '$no_telp',
                    jenis_tiket = '$jenis_tiket',
                    jumlah_tiket = '$jumlah_tiket',
                    metode_pembayaran = '$metode_pembayaran'
                    WHERE id = '$id'";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: admin_form.php"); // Redirect kembali ke admin_form.php
        exit();
    } else {
        echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Tiket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #36393F;
            color: #E8E8E8;
        }
        .card {
            background-color: #40444B;
            color: #E8E8E8;
        }
        .btn-primary {
            background-color: #007BFF;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Data Tiket</h2>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="nama_pemesan">Nama Lengkap:</label>
                        <input type="text" class="form-control" name="nama_pemesan" value="<?php echo $row['nama_pemesan']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No. Telp:</label>
                        <input type="text" class="form-control" name="no_telp" value="<?php echo $row['no_telp']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_tiket">Jenis Tiket:</label>
                        <input type="text" class="form-control" name="jenis_tiket" value="<?php echo $row['jenis_tiket']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tiket">Jumlah Tiket:</label>
                        <input type="number" class="form-control" name="jumlah_tiket" value="<?php echo $row['jumlah_tiket']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="metode_pembayaran">Metode Pembayaran:</label>
                        <input type="text" class="form-control" name="metode_pembayaran" value="<?php echo $row['metode_pembayaran']; ?>" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>