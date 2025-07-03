<?php
// File: asisten/tambah_modul.php
$pageTitle = 'Tambah Modul';
$activePage = 'modul';
require_once '../config.php';
require_once 'templates/header.php';

// Ambil daftar praktikum untuk dropdown
$praktikum = $conn->query("SELECT id, nama_praktikum FROM praktikum");

// Proses form tambah modul
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $praktikum_id = $_POST['praktikum_id'];
    $nama_modul = $_POST['nama_modul'];
    $pertemuan_ke = $_POST['pertemuan_ke'];
    $file_materi = $_FILES['file_materi']['name'];
    $tmp = $_FILES['file_materi']['tmp_name'];

    if ($file_materi) {
        $uploadPath = '../materi/' . $file_materi;
        move_uploaded_file($tmp, $uploadPath);
    }

    $stmt = $conn->prepare("INSERT INTO modul (praktikum_id, nama_modul, file_materi, pertemuan_ke) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $praktikum_id, $nama_modul, $file_materi, $pertemuan_ke);
    $stmt->execute();

    header("Location: modul.php");
    exit();
}
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Modul</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700">Mata Praktikum</label>
            <select name="praktikum_id" class="w-full mt-1 p-2 border rounded">
                <?php while ($row = $praktikum->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nama_praktikum'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Nama Modul</label>
            <input type="text" name="nama_modul" required class="w-full mt-1 p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Pertemuan Ke</label>
            <input type="number" name="pertemuan_ke" required class="w-full mt-1 p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">File Materi (PDF/DOCX)</label>
            <input type="file" name="file_materi" class="w-full mt-1">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>
