CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','asisten') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (nama, email, password, role)
VALUES 
('Assist1', 'A1@mail.com', '123', 'asisten'),
('Mahas1', 'M1@mail.com', '123', 'mahasiswa');

-- 2. Tabel Praktikum
CREATE TABLE praktikum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_praktikum VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO praktikum (nama_praktikum, deskripsi)
VALUES 
('Pemrograman Web', 'Praktikum membuat website dinamis menggunakan PHP.'),
('Jaringan Komputer', 'Praktikum dasar jaringan komputer dan konfigurasi perangkat.');

-- 3. Tabel Pendaftaran Praktikum
CREATE TABLE pendaftaran_praktikum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    praktikum_id INT NOT NULL,
    tanggal_daftar DATE DEFAULT CURDATE(),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (praktikum_id) REFERENCES praktikum(id),
    UNIQUE (user_id, praktikum_id)
);

INSERT INTO pendaftaran_praktikum (user_id, praktikum_id)
VALUES 
(2, 1), -- Ani Mahasiswa daftar ke Pemrograman Web
(2, 2); -- Ani Mahasiswa daftar ke Jaringan Komputer

-- 4. Tabel Modul
CREATE TABLE modul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    praktikum_id INT NOT NULL,
    nama_modul VARCHAR(100) NOT NULL,
    file_materi VARCHAR(255),
    pertemuan_ke INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (praktikum_id) REFERENCES praktikum(id)
);

INSERT INTO modul (praktikum_id, nama_modul, file_materi, pertemuan_ke)
VALUES 
(1, 'HTML & CSS Dasar', 'materi/html_css_dasar.pdf', 1),
(1, 'Form & Validasi PHP', 'materi/form_php.pdf', 2),
(2, 'Topologi Jaringan', 'materi/topologi.pdf', 1);

-- 5. Tabel Laporan
CREATE TABLE laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    modul_id INT NOT NULL,
    file_laporan VARCHAR(255),
    tanggal_kumpul DATETIME DEFAULT CURRENT_TIMESTAMP,
    nilai INT DEFAULT NULL,
    feedback TEXT,
    status ENUM('dikirim', 'dinilai') DEFAULT 'dikirim',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (modul_id) REFERENCES modul(id),
    UNIQUE (user_id, modul_id)
);

INSERT INTO laporan (user_id, modul_id, file_laporan)
VALUES 
(2, 1, 'laporan/ani_modul1.pdf'),
(2, 2, 'laporan/ani_modul2.pdf');

