<?php
$host = 'localhost'; // Ganti dengan host database Anda
$db = 'berita_gempa'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

try {
    // Membuat koneksi
    $conn = new mysqli($host, $user, $pass, $db);

    // Cek koneksi
    if ($conn->connect_error) {
        throw new Exception("Koneksi gagal: " . $conn->connect_error);
    }

} catch (Exception $e) {
    // Menangani kesalahan
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>