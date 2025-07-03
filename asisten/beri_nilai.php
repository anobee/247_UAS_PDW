<?php
require_once '../config.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID laporan tidak ditemukan.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = $_POST['nilai'];
    $feedback = $_POST['feedback'];

    $stmt = $conn->prepare("UPDATE laporan SET nilai = ?, feedback = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nilai, $feedback, $id);
    $stmt->execute();

    header("Location: laporan.php");
    exit;
}

// Ambil data laporan
$stmt = $conn->prepare("SELECT * FROM laporan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$laporan = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Beri Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">Beri Nilai untuk: <?= htmlspecialchars($laporan['file_laporan']) ?></h1>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block font-medium">Nilai</label>
            <input type="text" name="nilai" class="border p-2 w-full" required>
        </div>
        <div>
            <label class="block font-medium">Feedback</label>
            <textarea name="feedback" class="border p-2 w-full" rows="4"></textarea>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
        <a href="laporan.php" class="ml-4 text-gray-600 hover:underline">Kembali</a>
    </form>
</body>
</html>
