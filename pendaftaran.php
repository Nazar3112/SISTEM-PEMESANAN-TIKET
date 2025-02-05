<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran Tiket Konser</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../TUGAS_AKHIR/style/pendaftaran.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">PENDAFTARAN TIKET KONSER</h2>
        <div class="d-flex justify-content-end">
            <a href="logout.php"><button class="btn btn-danger btn-lg">LOGOUT</button></a>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <strong>Pesan Tiket Konser</strong>
            </div>
            <div class="card-body">
                <form action="proses_pendaftaran.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_pemesan">Nama Lengkap:</label>
                        <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No. Telepon:</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_tiket">Jenis Tiket:</label>
                        <select name="jenis_tiket" id="jenis_tiket" class="form-control" required>
                            <option value="ULTIMATE EXPERIENCE (CAT 1)">ULTIMATE EXPERIENCE (CAT 1) - IDR 11.000.000</option>
                            <option value="MY UNIVERSE (FESTIVAL)">MY UNIVERSE (FESTIVAL) - IDR 5.700.000</option>
                            <option value="CAT 1 (NUMBERED SEATING)">CAT 1 (NUMBERED SEATING) - IDR 5.000.000</option>
                            <option value="FESTIVAL (FREE STANDING)">FESTIVAL (FREE STANDING) - IDR 3.500.000</option>
                            <option value="CAT 2 (NUMBERED SEATING)">CAT 2 (NUMBERED SEATING) - IDR 4.000.000</option>
                            <option value="CAT 3 (NUMBERED SEATING)">CAT 3 (NUMBERED SEATING) - IDR 3.250.000</option>
                            <option value="CAT 4 (NUMBERED SEATING)">CAT 4 (NUMBERED SEATING) - IDR 2.500.000</option>
                            <option value="CAT 5 (NUMBERED SEATING)">CAT 5 (NUMBERED SEATING) - IDR 1.750.000</option>
                            <option value="CAT 6 (NUMBERED SEATING)">CAT 6 (NUMBERED SEATING) - IDR 1.250.000</option>
                            <option value="CAT 7 (NUMBERED SEATING)">CAT 7 (NUMBERED SEATING) - IDR 1.250.000</option>
                            <option value="CAT 8 (NUMBERED SEATING)">CAT 8 (NUMBERED SEATING) - IDR 800.000</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tiket">Jumlah Tiket:</label>
                        <input type="number" name="jumlah_tiket" id="jumlah_tiket" class="form-control" min="1" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="tanggal_acara">Tanggal Acara:</label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" class="form-control" value="2025-02-08" readonly>
                    </div>
                    <div class="form-group">
                        <label for="waktu_acara">Waktu Acara:</label>
                        <input type="time" name="waktu_acara" id="waktu_acara" class="form-control" value="23:30" readonly>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_acara">Lokasi Acara:</label>
                        <input type="text" name="lokasi_acara" id="lokasi_acara" class="form-control" value="Gelora Bung Karno, Jakarta" readonly>
                    </div> -->
                    <div class="form-group">
                        <label for="metode_pembayaran">Metode Pembayaran:</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran"></label><br>
                        <img src="../TUGAS_AKHIR/assets/qr.png" alt="QRIS Code" width="200"><br>
                        <small>Silakan scan kode QR di atas untuk melakukan pembayaran.</small>
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran (Foto/Screenshot):</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control-file" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Pesan Tiket</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>