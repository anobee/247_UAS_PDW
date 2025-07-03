<?php
session_start();
require_once('../config.php');


$pageTitle = 'Cari Praktikum';
$activePage = 'course';
require_once 'templates/header_mahasiswa.php';

$sql = "SELECT * FROM praktikum ORDER BY nama_praktikum ASC";
$result = $conn->query($sql);
?>

<div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Mata Praktikum</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="p-4 border rounded-lg bg-gray-50 shadow-sm">
                    <h3 class="text-lg font-semibold text-blue-600"><?= htmlspecialchars($row['nama_praktikum']) ?></h3>
                    <p class="text-sm text-gray-700 mt-1"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'mahasiswa'): ?>
                        <form action="daftar_praktikum.php" method="POST" class="mt-3">
                            <input type="hidden" name="praktikum_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm">Daftar</button>
                        </form>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 mt-2 italic">Login sebagai mahasiswa untuk mendaftar.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600">Tidak ada mata praktikum tersedia saat ini.</p>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer_mahasiswa.php'; ?>
