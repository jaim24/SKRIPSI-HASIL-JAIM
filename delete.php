<?php
include('includes/db.php');

// Mengecek apakah ID ada di URL
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM pembayaran_spp WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman index setelah berhasil menghapus
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Jika ID tidak ditemukan, redirect ke halaman index
    header('Location: index.php');
}
?>
