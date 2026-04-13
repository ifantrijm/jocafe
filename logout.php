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
// FILE: logout.php
// Fungsi: Menghancurkan session dan redirect ke login
// =============================================

session_start();       // Mulai session agar bisa diakses
session_destroy();     // Hancurkan semua data session (user keluar)

header("Location: login.php");  // Kembali ke halaman login
exit();
?></div>
</body>
</html>sdas