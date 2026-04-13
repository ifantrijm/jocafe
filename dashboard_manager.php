<?php
//kita pakai session_start agar  username tetap muncul kalau habis login
session_start();

//Data contoh (karena ini cuma tampilan,di tulis manual disini)
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Satrio';
$role     = isset($_SESSION['role']) ? strtoupper($_SESSION['role']) : "MANAGER";
$id_user  = isset($_SESSION['id_user']) ? $_SESSION['id_user'] :"12345";

//Angka statisitik contoh biar ga kosong
$total_reservasi = 120;
$hari_ini        =15;
$pending         =3;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager - Jo Cafe (Preview Mode)</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #0f121a;
            --card: #1a1f2b; 
            --accent: #f39c12;
            --white: #ffffff;
            --gray: #bdc3c7;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: var(--bg); color: var(--white); overflow-x: hidden; }

        /*Navbar*/
        .navbar {
            background-color: var(--card);
            border-bottom: 2px solid var(--accent);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .logo { font-family: 'Dancing Script', cursive; font-size: 26px; color: var(--accent); }
        .btn-logout {
            color: var(--accent);
            text-decoration: none;
            border: 1px solid var(--accent);
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 13px;
            transition: 0.3s;
        }
        .btn-logout:hover { background-color: var(--accent); color: #000; }

        .container { max-width: 850px; margin: 40px auto; padding: 0 20px; }

        /*Bannee*/
        .welcome-banner {
            background: linear-gradient( rgba(0,0,0,0.7), rgba(0,0,0,0,.7)),
                        url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1000') center/cover;
            padding: 50px 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
            border: 1px solid #333;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .welcome-banner h2 { font-family: 'Dancing Script', cursive; font-size: 42px; color: var(--accent); }

        /*Info Cards*/
        .info-card {
            background-color: var(--card);
            padding: 25pc;
            border-radius: 12px;
            margin-bottom: 35px;
            border-left: 5px solid var(--accent);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .info-card h3 { font-family: 'Dancing Script', cursive; color: var(--accent); margin-bottom: 15px; font-size: 26px; }

        table { width: 100%; border-collapse: collapse; }
        td { padding: 12px 0; font-size: 14px; border-bottom: 1px solid #2c3e50; }
        .label { color: var(--gray); width: 40%; }
        .badge { background: var(--accent); color: #000; padding: 3px 10px; border-radius: 5px; font-weight: bold; font-size: 11px; }

        /* Statistics */
        .section-title { font-family: 'Dancing Script', cursive; color: var(--accent); font-size: 30px; margin-bottom: 20px; text-align: center; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .stat-box { 
        background: var(--card);
        padding: 30px 20px;
        border-radius: 15px;
        text-align: center; 
        border: 1px solid #2c3e50; 
        transition: 0.4s;
    }
    .stat-box:hover { border-color: var(--accent); transform: translateY(-8px); box-shadow: 0 10px 20px rgba(243, 156, 18, 0.1); }
    .stat-box h4 { font-size: 13px; color: var(--gray); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
    .stat-box .number { font-size: 40px; font-weight: bold; color: var(--accent); }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">Jo Cafe Dashboard</div>
    <a href="#" class="btn-logout">Logout</a>
</nav>

<div class="container">
    <header class="welcome-banner">
    <h2>Halo, <?= htmlspecialchars($username) ?>!</h2>
    <p style="color: var(--gray); margin-top: 10px;">Panel kendali reservasi Jo Cafe (Preview Mode).</p>   
    </header> 

 <section class="info-card">
    <h3>📄 Data Akun</h3>
    <table>
        <tr>
            <td class="label">ID Manager</td>
            <td>#<?=$id_user?></td>
        </tr>
        <tr>
            <td class="label">Nama Pengguna</td>
            <td><?= htmlspecialchars($username) ?></td>
        </tr>
        <tr>
            <td class="label">Status Akses</td>
            <td><span class="badge">Manager</span></td>
        </tr>
    </table>
</section>

    <h3 class="section-title">📊 Statistik Reservasi</h3>
    <div class="stats-grid">
        <div class="stat-box">
            <h4>Total</h4>
            <div class="number"><?=$total_reservasi?></div>
        </div>
        <div class="stat-box">
            <h4>Hari Ini</h4>
            <div class="number"><?=$hari_ini?></div>
        </div>
        <div class="stat-box">
            <h4>Pending</h4>
            <div class="number" style="color: #e74c3c;"><?= $pending ?></div>
        </div>
    </div>
</div>

</body>
</html>