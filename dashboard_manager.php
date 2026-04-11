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