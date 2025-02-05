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

// Proses pencarian data
$cari = isset($_GET['cari']) ? clean_input($_GET['cari']) : '';
$sql_cari = !empty($cari) ? "WHERE nama_pemesan LIKE '%$cari%' OR email LIKE '%$cari%' OR no_telp LIKE '%$cari%'" : "";

// Pagination
$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($halaman - 1) * $batas;

$sql = "SELECT * FROM tiket $sql_cari LIMIT $mulai, $batas";
$result = mysqli_query($conn, $sql);

// Jumlah total data
$sql_total = "SELECT COUNT(*) AS total FROM tiket $sql_cari";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_data = $row_total['total'];
$total_halaman = ceil($total_data / $batas);

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id_hapus = clean_input($_GET['hapus']);
    $sql_hapus = "DELETE FROM tiket WHERE id = '$id_hapus'";
    if (mysqli_query($conn, $sql_hapus)) {
        header("Location: admin_form.php");
        exit();
    } else {
        echo "Error: " . $sql_hapus . "<br>" . mysqli_error($conn);
    }

}

// Proses edit data (akan dijelaskan di bagian form)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Pendaftaran Tiket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../TUGAS_AKHIR/style/pendaftaran.css">
    <link rel="stylesheet" href="../TUGAS_AKHIR/style/admin.css">

</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Data Pendaftaran Tiket</h2>
        <form class="form-inline mb-4" method="GET">
            <input class="form-control mr-sm-2" type="search" name="cari" placeholder="Cari Nama/Email/No. Telp" value="<?php echo $cari; ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
        </form>
        <div class="table-responsive">
        <div class="d-flex justify-content-end">
            <a class="btn btn-danger btn-lg" href="logout.php" role="button">Logout</a>
        </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Jenis Tiket</th>
                        <th>Jumlah Tiket</th>
                        <th>Metode Pembayaran</th>
                        <th>Bukti Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama_pemesan']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['no_telp']; ?></td>
                            <td><?php echo $row['jenis_tiket']; ?></td>
                            <td><?php echo $row['jumlah_tiket']; ?></td>
                            <td><?php echo $row['metode_pembayaran']; ?></td>
                            <td><img src="uploads/<?php echo $row['bukti_pembayaran']; ?>" alt="Bukti Pembayaran" width="100"></td>
                            <td>
                                <a href="admin_form.php?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                <a href="edit_form.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="approve.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($halaman > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="admin_form.php?halaman=<?php echo $halaman - 1; ?><?php echo !empty($cari) ? "&cari=$cari" : ""; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_halaman; $i++) : ?>
                    <li class="page-item <?php echo $i == $halaman ? 'active' : ''; ?>">
                        <a class="page-link" href="admin_form.php?halaman=<?php echo $i; ?><?php echo !empty($cari) ? "&cari=$cari" : ""; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($halaman < $total_halaman) : ?>
                    <li class="page-item">
                        <a class="page-link" href="admin_form.php?halaman=<?php echo $halaman + 1; ?><?php echo !empty($cari) ? "&cari=$cari" : ""; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>