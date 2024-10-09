<?php include('includes/db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head >
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan SPP Sekolah</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Pencatatan SPP Sekolah</h1>

    <div class="form-container">
    <h2>Input Pembayaran SPP</h2>
    <form action="process.php" method="POST">
    <label for="nama">Nama Siswa:</label>
    <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama Siswa">

    <script>
        $(function() {
            $("#nama").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "get_nama_siswa.php",
                        method: "GET",
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2 // Menampilkan opsi setelah 2 karakter dimasukkan
            });
        });
    </script>
    <label for="kelas">Kelas:</label>
    <select id="kelas" name="kelas" required>
        <option value="">Pilih Kelas</option>
        <optgroup label="Kelompok A">
            <option value="A1">A1</option>
            <option value="A2">A2</option>
            <option value="A3">A3</option>
            <option value="A4">A4</option>
        </optgroup>
        <optgroup label="Kelompok B">
            <option value="B1">B1</option>
            <option value="B2">B2</option>
            <option value="B3">B3</option>
            <option value="B4">B4</option>
            <option value="B5">B5</option>
        </optgroup>
        <option value="Kelompok Bermain">Kelompok Bermain</option>
    </select>

    <label for="bulan">Bulan:</label>
    <div class="checkbox-container" required>
        <?php
        $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        foreach ($bulan as $b) {
            echo "<label><input type='checkbox' name='bulan[]' value='$b'> $b</label>";
        }
        ?>
    </div>

    <label for="tanggal">Tanggal Pembayaran:</label>
    <input type="date" id="tanggal" name="tanggal" required>

    <label for="keterangan">Keterangan:</label>
    <select id="keterangan" name="keterangan" required>
        <option value="">Pilih Metode Pembayaran</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
    </select>

    <label for="jumlah">Jumlah Bayar:</label>
    <select id="jumlah" name="jumlah" required>
        <option value="">Pilih Jumlah Bayar</option>
        <option value="175000">Rp. 175.000</option>
        <option value="150000">Rp. 150.000</option>
        <option value="200000">Rp. 200.000</option>
    </select>

    <button type="submit">Tambah Pembayaran</button>
</form>

</div>

<div class="table-container">
    <h2>Daftar Pembayaran SPP</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Bulan</th>
                <th>Tanggal Pembayaran</th>
                <th>Keterangan</th>
                <th>Jumlah Bayar</th>
                <th>Aksi</th> <!-- Kolom untuk aksi (hapus) -->
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM pembayaran_spp";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $formatted_date = date('d-m-Y', strtotime($row['tanggal']));
                    $formatted_amount = "Rp." . number_format($row['jumlah'], 0, ',', '.');
                    echo "<tr>
                            <td>{$row['nama_siswa']}</td>
                            <td>{$row['kelas']}</td>
                            <td>{$row['bulan']}</td>
                            <td>{$formatted_date}</td>
                            <td>{$row['keterangan']}</td>
                            <td>{$formatted_amount}</td>
                            <td>
                                <form action='delete.php' method='GET' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' class='btn-hapus'>
                                        <i class='fa fa-trash'></i> Hapus
                                    </button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Belum ada data pembayaran.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>




</div>

</body>
</html>
