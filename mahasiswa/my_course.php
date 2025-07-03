<?php
session_start();
require_once '../config.php';

$pageTitle = 'Praktikum Saya';
$activePage = 'my_course';
require_once 'templates/header_mahasiswa.php';

$user_id = $_SESSION['user_id'];

// Ambil daftar praktikum yang diikuti mahasiswa
$sql = "SELECT p.id AS praktikum_id, p.nama_praktikum, p.deskripsi
        FROM pendaftaran_praktikum pp
        JOIN praktikum p ON pp.praktikum_id = p.id
        WHERE pp.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$praktikum_result = $stmt->get_result();
?>

<div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Praktikum yang Kamu Ikuti</h2>

    <?php if ($praktikum_result->num_rows > 0): ?>
        <?php while ($praktikum = $praktikum_result->fetch_assoc()): ?>
            <div class="border rounded-lg p-4 mb-6 bg-gray-50 shadow">
                <h3 class="text-xl font-semibold text-blue-700"><?= htmlspecialchars($praktikum['nama_praktikum']) ?></h3>
                <p class="text-gray-600 mb-4"><?= nl2br(htmlspecialchars($praktikum['deskripsi'])) ?></p>

                <?php
                // Ambil modul dari praktikum ini
                $sql_modul = "SELECT m.id AS modul_id, m.nama_modul, m.pertemuan_ke, m.file_materi, l.file_laporan, l.status, l.nilai
                              FROM modul m
                              LEFT JOIN laporan l ON m.id = l.modul_id AND l.user_id = ?
                              WHERE m.praktikum_id = ?
                              ORDER BY m.pertemuan_ke ASC";
                $stmt_modul = $conn->prepare($sql_modul);
                $stmt_modul->bind_param("ii", $user_id, $praktikum['praktikum_id']);
                $stmt_modul->execute();
                $modul_result = $stmt_modul->get_result();
                ?>

                <?php if ($modul_result->num_rows > 0): ?>
                    <table class="w-full mt-2 table-auto text-sm">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-2 py-2 text-left">Pertemuan</th>
                                <th class="px-2 py-2 text-left">Modul</th>
                                <th class="px-2 py-2 text-left">Materi</th>
                                <th class="px-2 py-2 text-left">Laporan</th>
                                <th class="px-2 py-2 text-left">Status</th>
                                <th class="px-2 py-2 text-left">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($modul = $modul_result->fetch_assoc()): ?>
                                <tr class="border-b">
                                    <td class="px-2 py-2"><?= $modul['pertemuan_ke'] ?></td>
                                    <td class="px-2 py-2"><?= htmlspecialchars($modul['nama_modul']) ?></td>
                                    <td class="px-2 py-2">
                                        <?php if ($modul['file_materi']): ?>
                                            <a href="../materi/<?= $modul['file_materi'] ?>" class="text-blue-600 hover:underline" target="_blank">Download</a>
                                        <?php else: ?>
                                            <span class="text-gray-500 italic">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-2 py-2">
                                        <?php if ($modul['file_laporan']): ?>
                                            <a href="../laporan/<?= $modul['file_laporan'] ?>" target="_blank" class="text-green-600 hover:underline">Lihat</a>
                                        <?php else: ?>
                                            <form method="POST" action="upload_laporan.php" enctype="multipart/form-data">
                                                <input type="hidden" name="modul_id" value="<?= $modul['modul_id'] ?>">
                                                <input type="file" name="laporan" required class="text-xs mb-1">
                                                <button type="submit" class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">Upload</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-2 py-2">
                                        <?= $modul['status'] ? ucfirst($modul['status']) : '-' ?>
                                    </td>
                                    <td class="px-2 py-2">
                                        <?= $modul['nilai'] !== null ? $modul['nilai'] : '-' ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-sm text-gray-500">Belum ada modul pada praktikum ini.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-gray-600">Kamu belum mendaftar ke praktikum manapun.</p>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer_mahasiswa.php'; ?>
