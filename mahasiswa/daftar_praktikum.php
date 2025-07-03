<?php
session_start();
require_once('../config.php');

// Cek apakah user login dan berperan sebagai mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

// Tangkap ID praktikum dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['praktikum_id'])) {
    $user_id = $_SESSION['user_id'];
    $praktikum_id = intval($_POST['praktikum_id']);

    // Cek apakah sudah pernah daftar
    $cek = $conn->prepare("SELECT id FROM pendaftaran_praktikum WHERE user_id = ? AND praktikum_id = ?");
    $cek->bind_param("ii", $user_id, $praktikum_id);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        header("Location: my_course.php?status=exists");
    } else {
        // Lakukan pendaftaran
        $stmt = $conn->prepare("INSERT INTO pendaftaran_praktikum (user_id, praktikum_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $praktikum_id);
        if ($stmt->execute()) {
            header("Location: my_course.php?status=success");
        } else {
            echo "Gagal mendaftar.";
        }
    }
} else {
    echo "Akses tidak sah.";
}
?>
