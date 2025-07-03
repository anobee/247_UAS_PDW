<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek jika pengguna belum login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Mahasiswa - <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Navigasi -->
<nav class="bg-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Kiri: Judul Aplikasi -->
            <div class="flex items-center">
                <span class="text-white text-2xl font-bold">SIMPRAK</span>

                <!-- Menu -->
                <div class="hidden md:block ml-10">
                    <?php 
                        $activeClass = 'bg-blue-700 text-white';
                        $inactiveClass = 'text-gray-200 hover:bg-blue-700 hover:text-white';
                    ?>
                    <a href="dashboard.php" class="<?= $activePage == 'dashboard' ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="my_course.php" class="<?= $activePage == 'my_course' ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Praktikum Saya</a>
                    <a href="course.php" class="<?= $activePage == 'course' ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Cari Praktikum</a>
                </div>
            </div>

            <!-- Kanan: Logout -->
            <div class="hidden md:block">
                <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Konten Utama -->
<div class="container mx-auto p-6 lg:p-8">
