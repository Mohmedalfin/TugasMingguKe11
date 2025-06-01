<?php
// koneksi ke database
include 'database/conn.php';

// Cek apakah parameter ID dikirimkan via GET
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Query hapus data
    $query = "DELETE FROM buku WHERE id_buku = $id_buku";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    // Jika ID tidak ada di URL
    echo "<script>alert('ID buku tidak ditemukan'); window.location.href='index.php';</script>";
}
?>