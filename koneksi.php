<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div><?php
// =============================================
// FILE: koneksi.php
// Fungsi: Menghubungkan ke database MySQL
// =============================================

$host     = "localhost";
$user     = "root";
$password = "";        // kosong jika belum diset password di XAMPP
$database = "db_login"; // sesuaikan nama database kamu

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi GAGAL: " . mysqli_connect_error());
}
// Jika berhasil, tidak ada output apapun (normal)
?></div>
</body>
</html>sdas