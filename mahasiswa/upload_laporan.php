<?php
session_start();
require_once '../config.php';

// Pastikan user login dan sebagai mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validasi input
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['laporan']) && isset($_POST['modul_id'])) {
    $modul_id = intval($_POST['modul_id']);
    $file = $_FILES['laporan'];

    // Validasi file
    if ($file['error'] === 0) {
        $allowedExt = ['pdf', 'docx'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedExt)) {
            echo "Hanya file PDF atau DOCX yang diperbolehkan.";
            exit();
        }

        // Buat nama file baru agar unik
        $newFileName = 'laporan_' . $user_id . '_' . $modul_id . '.' . $fileExt;
        $uploadPath = '../laporan/' . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Simpan data ke DB
            $stmt = $conn->prepare("INSERT INTO laporan (user_id, modul_id, file_laporan) 
                                    VALUES (?, ?, ?)
                                    ON DUPLICATE KEY UPDATE 
                                        file_laporan = VALUES(file_laporan),
                                        tanggal_kumpul = CURRENT_TIMESTAMP,
                                        status = 'dikirim',
                                        nilai = NULL,
                                        feedback = NULL");

            $stmt->bind_param("iis", $user_id, $modul_id, $newFileName);
            $stmt->execute();

            header("Location: my_course.php?upload=success");
            exit();
        } else {
            echo "Gagal mengunggah file.";
            exit();
        }
    } else {
        echo "Terjadi kesalahan saat upload.";
        exit();
    }
} else {
    echo "Permintaan tidak valid.";
    exit();
}

