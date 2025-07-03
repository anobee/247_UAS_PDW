<?php
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cek apakah ada laporan terkait modul ini
    $cek = $conn->query("SELECT COUNT(*) AS total FROM laporan WHERE modul_id = $id");
    $data = $cek->fetch_assoc();

    if ($data['total'] > 0) {
        echo "Modul tidak bisa dihapus karena sudah memiliki laporan terkait.";
        exit;
    }

    // Hapus modul jika aman
    $sql = "DELETE FROM modul WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: modul.php");
        exit;
    } else {
        echo "Gagal menghapus modul.";
    }
} else {
    echo "ID modul tidak valid.";
}
?>
