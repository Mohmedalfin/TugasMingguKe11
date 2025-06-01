<?php
// Konfigurasi koneksi ke database
$host = "localhost";
$user = "root";         // default user XAMPP
$password = "";             // password default XAMPP biasanya kosong
$database = "pendataanbuku"; // ganti dengan nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>