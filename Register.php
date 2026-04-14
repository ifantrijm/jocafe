<?php
// =============================================
// FILE: register.php
// Fungsi: Halaman pendaftaran akun baru
// =============================================

session_start();
include "koneksi.php";

$pesan       = "";
$jenis_pesan = ""; // "sukses" atau "error"

// ---- PROSES REGISTER ----
if (isset($_POST['btn_register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $konfirm  = trim($_POST['konfirmasi']);
    $role     = $_POST['role'];  // 'Manajer' atau 'Admin'

    // --- Validasi ---
    if (empty($username) || empty($password) || empty($konfirm)) {
        $pesan       = "Semua field wajib diisi!";
        $jenis_pesan = "error";

    } elseif (strlen($username) < 4) {
        $pesan       = "Username minimal 4 karakter!";
        $jenis_pesan = "error";

    } elseif (strlen($password) < 6) {
        $pesan       = "Password minimal 6 karakter!";
        $jenis_pesan = "error";

    } elseif ($password !== $konfirm) {
        $pesan       = "Password dan konfirmasi password tidak cocok!";
        $jenis_pesan = "error";

    } else {
        // Cek apakah username sudah dipakai
        $cek   = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE username = '$username'");
        $exist = mysqli_num_rows($cek);

        if ($exist > 0) {
            $pesan       = "Username '$username' sudah digunakan. Pilih username lain!";
            $jenis_pesan = "error";
        } else {
            // Simpan ke database
            // Password di-hash dengan MD5 (sama dengan saat login)
            $password_hash = MD5($password);

            $query  = "INSERT INTO tb_login (username, password, role) 
                       VALUES ('$username', '$password_hash', '$role')";
            $simpan = mysqli_query($koneksi, $query);

            if ($simpan) {
                $pesan       = "Akun berhasil dibuat! Silakan login.";
                $jenis_pesan = "sukses";
            } else {
                $pesan       = "Gagal menyimpan data: " . mysqli_error($koneksi);
                $jenis_pesan = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jo Caffe-Register</title>

    <style>
:root {
    --bg: #0f121a;
    --card: #1a1f2b;
    --accent: #f39c12;
    --white: #ffffff;
    --gray: #bdc3c7;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: Arial, sans-serif;
    background-color: var(--bg);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* CARD */
.card {
    background: var(--card);
    padding: 35px 40px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    width: 100%;
    max-width: 400px;
    color: var(--white);
}

/* JUDUL */
.card h2 {
    text-align: center;
    margin-bottom: 8px;
    color: var(--accent);
}

/* SUBTITLE */
.card p.subtitle {
    text-align: center;
    color: var(--gray);
    font-size: 13px;
    margin-bottom: 25px;
}

/* LABEL */
label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
    color: var(--gray);
}

/* INPUT */
input[type="text"],
input[type="password"],
select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #2c3445;
    border-radius: 5px;
    font-size: 14px;
    margin-bottom: 16px;
    background-color: #11151f;
    color: var(--white);
}

input:focus, select:focus {
    border-color: var(--accent);
    outline: none;
}

/* BUTTON */
button {
    width: 100%;
    padding: 11px;
    background-color: var(--accent);
    color: black;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
}

button:hover {
    background-color: #d68910;
}

/* PESAN */
.pesan-error {
    background-color: #2c1f1f;
    color: #e74c3c;
    border: 1px solid #e74c3c;
    padding: 10px;
    border-radius: 5px;
    font-size: 13px;
    margin-bottom: 15px;
}

.pesan-sukses {
    background-color: #1f2c22;
    color: #2ecc71;
    border: 1px solid #27ae60;
    padding: 10px;
    border-radius: 5px;
    font-size: 13px;
    margin-bottom: 15px;
}

/* LINK */
.link-login {
    text-align: center;
    margin-top: 15px;
    font-size: 13px;
}

.link-login a {
    color: var(--accent);
    text-decoration: none;
}

.link-login a:hover {
    text-decoration: underline;
}

/* HINT */
.hint {
    font-size: 11px;
    color: var(--gray);
    margin-top: -12px;
    margin-bottom: 14px;
}
    </style>

</head>

<body>

<div class="card">
    <h2>📝 Jo Caffe</h2>
    <p class="subtitle">Daftar & nikmati menu terbaik kami</p>

    <?php if ($pesan != "") : ?>
        <div class="pesan-<?= $jenis_pesan ?>">
            <?= ($jenis_pesan == 'sukses') ? '✅' : '⚠️' ?> <?= $pesan ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Nama Pengguna</label>
        <input type="text" name="username"
        value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        <p class="hint">Minimal 4 karakter</p>

        <label>Kata Sandi</label>
        <input type="password" name="password">
        <p class="hint">Minimal 6 karakter</p>

        <label>Konfirmasi Kata Sandi</label>
        <input type="password" name="konfirmasi">

        <label>Daftar Sebagai</label>
        <select name="role">
            <option value="Manager">Manager</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" name="btn_register">Daftar Sekarang</button>
    </form>

    <div class="link-login">
        Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
</div>

</body>
</html>
