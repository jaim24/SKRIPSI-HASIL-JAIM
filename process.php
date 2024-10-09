<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input apakah ada yang kosong
    if (empty($_POST['nama']) || empty($_POST['kelas']) || empty($_POST['bulan']) || empty($_POST['tanggal']) || empty($_POST['keterangan']) || empty($_POST['jumlah'])) {
        // Redirect kembali ke form jika ada input yang kosong dengan pesan error
        echo "<script>alert('Semua input harus diisi!'); window.location.href='index.php';</script>";
        exit();
    }

    // Ambil data dari form
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    $bulan = isset($_POST['bulan']) ? $_POST['bulan'] : [];
    $jumlah_per_bulan = $conn->real_escape_string($_POST['jumlah']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $keterangan = $conn->real_escape_string($_POST['keterangan']);

    // Menghitung jumlah bulan yang dipilih
    $jumlah_bulan = count($bulan);

    // Mengalikan jumlah bayar per bulan dengan jumlah bulan yang dipilih
    $total_bayar = $jumlah_per_bulan * $jumlah_bulan;

    // Gabungkan semua bulan yang dipilih menjadi satu string dipisahkan dengan koma
    $bulan_dibayar = implode(", ", $bulan);

    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO pembayaran_spp (nama_siswa, kelas, bulan, tanggal, keterangan, jumlah) 
            VALUES ('$nama', '$kelas', '$bulan_dibayar', '$tanggal', '$keterangan', '$total_bayar')";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php'); // Redirect ke halaman utama setelah pembayaran sukses
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
