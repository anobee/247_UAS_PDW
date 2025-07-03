<?php
// File: asisten/edit_modul.php
$pageTitle = 'Edit Modul';
$activePage = 'modul';
require_once '../config.php';
require_once 'templates/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM modul WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$modul = $result->fetch_assoc();

$praktikum = $conn->query("SELECT id, nama_praktikum FROM praktikum");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $praktikum_id = $_POST['praktikum_id'];
    $nama_modul = $_POST['nama_modul'];
    $pertemuan_ke = $_POST['pertemuan_ke'];
    $file_materi = $modul['file_materi'];

    if ($_FILES['file_materi']['name']) {
        $file_materi = $_FILES['file_materi']['name'];
        move_uploaded_file($_FILES['file_materi']['tmp_name'], '../materi/' . $file_materi);
    }

    $update = $conn->prepare("UPDATE modul SET praktikum_id = ?, nama_modul = ?, file_materi = ?, pertemuan_ke = ? WHERE id = ?");
    $update->bind_param("issii", $praktikum_id, $nama_modul, $file_materi, $pertemuan_ke, $id);
    $update->execute();

    header("Location: modul.php");
    exit();
}
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Modul</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700">Mata Praktikum</label>
            <select name="praktikum_id" class="w-full mt-1 p-2 border rounded">
                <?php while ($row = $praktikum->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= $row['id'] == $modul['praktikum_id'] ? 'selected' : '' ?>>
                        <?= $row['nama_praktikum'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Nama Modul</label>
            <input type="text" name="nama_modul" value="<?= htmlspecialchars($modul['nama_modul']) ?>" required class="w-full mt-1 p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Pertemuan Ke</label>
            <input type="number" name="pertemuan_ke" value="<?= $modul['pertemuan_ke'] ?>" required class="w-full mt-1 p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">File Materi (PDF/DOCX)</label>
            <input type="file" name="file_materi" class="w-full mt-1">
            <?php if ($modul['file_materi']): ?>
                <p class="text-sm text-gray-500 mt-1">File sekarang: <?= htmlspecialchars($modul['file_materi']) ?></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>

