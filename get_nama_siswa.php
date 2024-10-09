<?php
include('includes/db.php');

$nama = [];
$sql = "SELECT DISTINCT nama_siswa FROM siswa";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nama[] = $row['nama_siswa'];
    }
}

echo json_encode($nama);
?>
