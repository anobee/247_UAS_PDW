<?php
// ======================== modul.php ========================
// File: asisten/modul.php
$pageTitle = 'Kelola Modul';
$activePage = 'modul';
require_once '../config.php';
require_once 'templates/header.php';

// Query ambil modul
$query = "SELECT modul.id, modul.nama_modul, praktikum.nama_praktikum 
          FROM modul 
          JOIN praktikum ON modul.praktikum_id = praktikum.id";
$result = $conn->query($query);
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Modul</h2>
    <a href="tambah_modul.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Modul</a>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Judul Modul</th>
                <th class="px-4 py-2 text-left">Mata Praktikum</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($modul = $result->fetch_assoc()): ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?= htmlspecialchars($modul['nama_modul']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($modul['nama_praktikum']) ?></td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="edit_modul.php?id=<?= $modul['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                        <a href="hapus_modul.php?id=<?= $modul['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once 'templates/footer.php'; ?>
