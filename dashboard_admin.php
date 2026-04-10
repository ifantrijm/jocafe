<?php
// =============================================
// FILE: dashboard_admin.php
// Fungsi: Halaman khusus untuk role ADMIN
// =============================================

session_start();
include "koneksi.php";

// ---- PROTEKSI HALAMAN ----
// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah role-nya admin
// Kalau bukan admin, tendang ke halaman mahasiswa
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_mahasiswa.php");
    exit();
}

// Ambil semua data user untuk ditampilkan
$query_user = "SELECT * FROM tb_login ORDER BY id_user ASC";
$hasil_user = mysqli_query($koneksi, $query_user);

// ---- PROSES HAPUS USER ----
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];  // cast ke integer untuk keamanan

    // Jangan izinkan admin hapus akunnya sendiri
    if ($id_hapus == $_SESSION['id_user']) {
        $notif = "Tidak bisa menghapus akun sendiri!";
    } else {
        mysqli_query($koneksi, "DELETE FROM tb_login WHERE id_user = $id_hapus");
        header("Location: dashboard_admin.php?notif=hapus");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
        }

        /* ---- NAVBAR ---- */
        .navbar {
            background-color: #2c3e50;
            color: white;
            padding: 14px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .judul { font-size: 18px; font-weight: bold; }

        .navbar .info-user { font-size: 13px; }

        .navbar a.btn-logout {
            background-color: #e74c3c;
            color: white;
            padding: 7px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            margin-left: 12px;
        }

        .navbar a.btn-logout:hover { background-color: #c0392b; }

        /* ---- KONTEN ---- */
        .konten {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 15px;
        }

        /* ---- KARTU SELAMAT DATANG ---- */
        .kartu-welcome {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 22px 25px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .kartu-welcome h2 { margin-bottom: 5px; }
        .kartu-welcome p  { font-size: 14px; opacity: 0.85; }

        /* ---- TABEL ---- */
        .kartu-tabel {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .kartu-tabel .header-tabel {
            padding: 15px 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        .kartu-tabel .header-tabel h3 { color: #2c3e50; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: #34495e;
            color: white;
            padding: 11px 15px;
            text-align: left;
            font-size: 13px;
        }

        table td {
            padding: 11px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #2c3e50;
        }

        table tr:last-child td { border-bottom: none; }
        table tr:hover td { background-color: #f8f9fa; }

        /* Badge role */
        .badge {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-admin {
            background-color: #fdecea;
            color: #e74c3c;
        }

        .badge-mahasiswa {
            background-color: #eafaf1;
            color: #27ae60;
        }

        /* Tombol hapus */
        .btn-hapus {
            background-color: #e74c3c;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
        }

        .btn-hapus:hover { background-color: #c0392b; }

        /* Notifikasi */
        .notif {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .notif-sukses { background: #eafaf1; color: #1e8449; border: 1px solid #27ae60; }
        .notif-error  { background: #fdecea; color: #c0392b; border: 1px solid #e74c3c; }
    </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="judul">⚙️ Sistem Login PHP</div>
    <div>
        <span class="info-user">
            Login sebagai: <strong><?= $_SESSION['username'] ?></strong>
            | Role: <strong>Admin</strong>
        </span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<!-- KONTEN -->
<div class="konten">

    <!-- Kartu sambutan -->
    <div class="kartu-welcome">
        <h2>Selamat datang, <?= $_SESSION['username'] ?>! 👋</h2>
        <p>Anda login sebagai <strong>Admin</strong>. Anda bisa melihat dan mengelola semua akun pengguna.</p>
    </div>

    <!-- Notifikasi -->
    <?php if (isset($_GET['notif']) && $_GET['notif'] == 'hapus') : ?>
        <div class="notif notif-sukses">✅ User berhasil dihapus.</div>
    <?php endif; ?>

    <?php if (isset($notif)) : ?>
        <div class="notif notif-error">⚠️ <?= $notif ?></div>
    <?php endif; ?>

    
    <div class="container-fluid alert alert-info">
        <div class="card">
            <div class="card-body">
            <div class="card-text text-center">
                <h1>Data</h1>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3 mb-sm-0 g-2">
                    <div class="card text-white bg-primary" onclick="showForm('menu')">
                    <div class="card-body text-center">
                        <h5 class="card-title">Menu</h5>
                        <p class="card-text fw-bold">25 <i class="bi bi-fork-knife"></i></p>                        
                    </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-sm-0 g-2">
                    <div class="card text-white bg-success" onclick="showForm('galeri')">
                    <div class="card-body text-center">
                        <h5 class="card-title">Galeri</h5>
                        <p class="card-text fw-bold">15 <i class="bi bi-image"></i></p>                        
                    </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-sm-0 g-2">
                    <div class="card text-white bg-warning" onclick="showForm('ulasan')">
                    <div class="card-body text-center">
                        <h5 class="card-title">Ulasan</h5>
                        <p class="card-text fw-bold">10 <i class="bi bi-image"></i></p>                        
                    </div>
                    </div>
                </div>
            </div> 
            </div>   
            
            
            <!-- form menu -->
             <div class="row d-none" id="formMenu">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-text text-primary">Tambah Menu</h2>
                            <form action="">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" placeholder="Nama Menu">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <select name="" id="" class="form-control">
                                            <option value="">Coffee</option>
                                            <option value="">Food</option>
                                            <option value="">Snack</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control" type="number" name="" id="" placeholder="Harga">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <textarea name="" id="" rows="3" class="form-control">

                                        </textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input class="form-control" type="file" name="" id="">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <button class="form-control btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-text text-primary">Data Menu</h2>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><img src="" alt="Steak.png"></th>
                                        <th>Food</th>
                                        <th>Rp.25.000</th>
                                        <th><button type="reset" class="btn btn-danger">Delete</button></th>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>
            
            <!-- form galeri -->
             <div class="row d-none" id="formGaleri">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-text text-primary">Tambah galeri</h2>
                            <form action="">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" placeholder="Nama galeri">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <select name="" id="" class="form-control">
                                            <option value="">Coffee</option>
                                            <option value="">Food</option>
                                            <option value="">Snack</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control" type="number" name="" id="" placeholder="Harga">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <textarea name="" id="" rows="3" class="form-control">

                                        </textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input class="form-control" type="file" name="" id="">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <button class="form-control btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-text text-primary">Data galeri</h2>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><img src="" alt="Steak.png"></th>
                                        <th>Food</th>
                                        <th>Rp.25.000</th>
                                        <th><button type="reset" class="btn btn-danger">Delete</button></th>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>
            
            <!-- form ulasan -->
             <div class="row d-none" id="formUlasan">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-text text-primary">Tambah ulasan</h2>
                            <form action="">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" placeholder="Nama ulasan">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <select name="" id="" class="form-control">
                                            <option value="">Coffee</option>
                                            <option value="">Food</option>
                                            <option value="">Snack</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control" type="number" name="" id="" placeholder="Harga">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <textarea name="" id="" rows="3" class="form-control">

                                        </textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input class="form-control" type="file" name="" id="">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <button class="form-control btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-text text-primary">Data ulasan</h2>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><img src="" alt="Steak.png"></th>
                                        <th>Food</th>
                                        <th>Rp.25.000</th>
                                        <th><button type="reset" class="btn btn-danger">Delete</button></th>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>


        </div>
    </div>



    <!-- Tabel Daftar User -->
    <div class="kartu-tabel d-none">
        <div class="header-tabel">
            <h3>📋 Daftar Semua Pengguna</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Password (MD5)</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($hasil_user)) :
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['id_user'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td style="font-size:11px; color:#7f8c8d;">
                        <?= substr($row['password'], 0, 20) ?>...
                    </td>
                    <td>
                        <span class="badge badge-<?= $row['role'] ?>">
                            <?= ucfirst($row['role']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['id_user'] != $_SESSION['id_user']) : ?>
                            <a href="?hapus=<?= $row['id_user'] ?>" 
                               class="btn-hapus"
                               onclick="return confirm('Yakin ingin menghapus user <?= $row['username'] ?>?')">
                                Hapus
                            </a>
                        <?php else : ?>
                            <span style="color:#bdc3c7; font-size:12px;">(Anda)</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function showForm(type){
            //menyembunyikan semua
            document.getElementById("formMenu").classList.add("d-none");
            document.getElementById("formGaleri").classList.add("d-none");
            document.getElementById("formUlasan").classList.add("d-none");

            // menampilkan sesuai klik
            if(type === 'menu'){
                document.getElementById("formMenu").classList.remove("d-none");
            }
            else if(type === 'galeri'){
                document.getElementById("formGaleri").classList.remove("d-none");
            }
            else if(type === 'ulasan'){
                document.getElementById("formUlasan").classList.remove("d-none");
            }
        }
    </script>
</div>
</body>
</html>