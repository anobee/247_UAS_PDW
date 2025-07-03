    <?php
    // ======================== laporan.php ========================
    // File: asisten/laporan.php
    $pageTitle = 'Laporan Mahasiswa';
    $activePage = 'laporan';
    require_once '../config.php';
    require_once 'templates/header.php';

    // Query laporan
    $sql    = "SELECT l.id, u.nama AS nama_mahasiswa, m.nama_modul, l.file_laporan, l.nilai, l.feedback, l.status, l.tanggal_kumpul
            FROM laporan l
            JOIN users u ON l.user_id = u.id
            JOIN modul m ON l.modul_id = m.id";

    $result = $conn->query($sql);
    ?>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Laporan Masuk</h2>
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">Mahasiswa</th>
                    <th class="px-4 py-2 text-left">Modul</th>
                    <th class="px-4 py-2 text-left">Laporan</th>
                    <th class="px-4 py-2 text-left">Nilai</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($laporan = $result->fetch_assoc()): ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= htmlspecialchars($laporan['nama_mahasiswa']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($laporan['nama_modul']) ?></td>
                        <td class="px-4 py-2">
                            <a href="../uploads/<?= $laporan['file_laporan'] ?>" class="text-blue-600 hover:underline" target="_blank">Download</a>
                        </td>
                        <td class="px-4 py-2"><?= $laporan['nilai'] ?? '-' ?></td>
                        <td class="px-4 py-2">
                            <a href="beri_nilai.php?id=<?= $laporan['id'] ?>" class="text-green-600 hover:underline">Nilai</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php require_once 'templates/footer.php'; ?>
