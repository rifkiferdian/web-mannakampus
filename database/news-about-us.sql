-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Agu 2026 pada 05.12
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_manna_kampus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_news`
--

CREATE TABLE `tbl_news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_slug` varchar(255) NOT NULL,
  `news_content` mediumtext NOT NULL,
  `news_content_short` text NOT NULL,
  `news_date` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `total_view` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` mediumtext NOT NULL,
  `meta_description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `tbl_news`
--

INSERT INTO `tbl_news` (`news_id`, `news_title`, `news_slug`, `news_content`, `news_content_short`, `news_date`, `photo`, `category_id`, `publisher`, `total_view`, `meta_title`, `meta_keyword`, `meta_description`) VALUES
(40, 'Pembukaan Cabang Manna Kampus 1', 'pembukaan-cabang-manna-kampus-1', '<p>Manna Kampus resmi membuka cabang pertama di lokasi strategis sebagai langkah awal dalam memperluas akses pendidikan, pembinaan karakter, dan komunitas belajar yang lebih luas.</p><p>Acara pembukaan dihadiri oleh pengurus, relawan, serta masyarakat setempat. Dalam momentum ini, Manna Kampus memperkenalkan program pendampingan belajar, ruang komunitas, dan kegiatan sosial yang menjadi inti dari visi lembaga.</p>', 'Manna Kampus resmi membuka cabang pertama untuk memperluas akses pendidikan dan pembinaan komunitas.', '01-01-2025', 'mk1.png', 1, 'Manna Kampus', 0, 'Pembukaan Cabang Manna Kampus 1', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 1.'),
(41, 'Pembukaan Cabang Manna Kampus 2', 'pembukaan-cabang-manna-kampus-2', '<p>Cabang kedu Manna Kampus dibuka dengan semangat untuk mengembangkan program pembelajaran yang lebih dekat dengan masyarakat. Lokasi baru ini menjadi pusat aktivitas edukasi, pelatihan, dan pemberdayaan komunitas.</p><p>Pembukaan cabang ini juga menandai komitmen Manna Kampus dalam membangun ekosistem belajar yang inklusif, kolaboratif, dan berorientasi pada penguatan potensi generasi muda.</p>', 'Cabang kedua Manna Kampus dibuka sebagai pusat edukasi dan pemberdayaan komunitas.', '15-02-2025', 'mk2.png', 1, 'Manna Kampus', 0, 'Pembukaan Cabang Manna Kampus 2', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 2.'),
(42, 'Pembukaan Cabang Manna Kampus 3', 'pembukaan-cabang-manna-kampus-3', '<p>Manna Kampus resmi membuka cabang ketiga dan memperluas jaringan pendampingan bagi siswa, mahasiswa, dan masyarakat. Ruang belajar baru ini dilengkapi dengan area diskusi, kelas mandiri, dan program pendampingan karakter.</p><p>Dengan hadirnya cabang ini, Manna Kampus semakin dekat dengan komunitas yang membutuhkan ruang tumbuh dan berkembang secara optimal.</p>', 'Cabang ketiga Manna Kampus dibuka untuk memperluas akses belajar dan pendampingan.', '18-03-2025', 'mk3.png', 1, 'Manna Kampus', 0, 'Pembukaan Cabang Manna Kampus 3', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 3.'),
(43, 'Pembukaan Cabang Manna Kampus 4', 'pembukaan-cabang-manna-kampus-4', '<p>Cabang keempat Manna Kampus dibuka sebagai bagian dari perjalanan panjang dalam memperkuat jaringan pendidikan dan pemberdayaan masyarakat. Lokasi baru ini memungkinkan semangat Manna Kampus hadir di lebih banyak wilayah.</p><p>Kegiatan pembukaan ditandai dengan peluncuran program mentoring, kelas digital, serta kegiatan sosial yang melibatkan pelajar dan keluarga setempat.</p>', 'Cabang keempat Manna Kampus dibuka untuk memperluas jangkauan pendidikan dan mentoring.', '10-04-2025', 'mk4.png', 1, 'Manna Kampus', 0, 'Pembukaan Cabang Manna Kampus 4', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 4.'),
(44, 'Pembukaan Cabang Manna Kampus 5', 'pembukaan-cabang-manna-kampus-5', '<p>Manna Kampus membuka cabang kelima sebagai wujud nyata komitmen terhadap peningkatan kualitas pendidikan dan pengembangan karakter di lingkungan sekitar. Cabang baru ini menjadi titik awal bagi lebih banyak program komunitas yang berdampak positif.</p><p>Selain kegiatan belajar, cabang ini juga menggelar program bakti sosial dan pendampingan usaha kecil yang menjadi bagian dari semangat Manna Kampus.</p>', 'Cabang kelima Manna Kampus dibuka untuk penguatan pendidikan dan pemberdayaan masyarakat.', '27-05-2025', 'mk5.png', 1, 'Manna Kampus', 0, 'Pembukaan Cabang Manna Kampus 5', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 5.'),
(45, 'Pembukaan Cabang Manna Kampus 6', 'pembukaan-cabang-manna-kampus-6', '<p>Pembukaan cabang keenam Manna Kampus menjadi langkah strategis untuk memperluas jaringan kegiatan belajar, pelatihan, dan layanan sosial bagi masyarakat. Dengan hadirnya cabang baru, program-program Manna Kampus dapat menjangkau lebih banyak komunitas.</p><p>Acara dibuka dengan sambutan serta sesi perkenalan program yang akan digelar di cabang ini, termasuk pembelajaran berbasis komunitas dan dukungan karier.</p>', 'Cabang keenam Manna Kampus dibuka untuk memperluas program edukasi dan sosial.', '22-06-2025', 'mk6.png', 1, 'Manna Kampus', 0, 'Pembukaan Cabang Manna Kampus 6', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 6.'),
(46, 'Pembukaan Cabang Manna Kampus 7', 'pembukaan-cabang-manna-kampus-7', '<p>Cabang ketujuh Manna Kampus dibuka sebagai tanda perjalanan membangun komunitas belajar yang semakin kuat dan berdampak. Infrastruktur baru ini menjadi ruang kolaborasi bagi siswa, anggota masyarakat, dan relawan.</p><p>Program-program yang akan dikembangkan di cabang ini mencakup pengembangan diri, literasi digital, serta kegiatan sosial yang memberi solusi nyata bagi kebutuhan lokal.</p>', 'Cabang ketujuh Manna Kampus dibuka untuk memperkuat komunitas belajar dan aksi sosial.', '17-07-2025', 'mk7.png', 1, 'Manna Kampus', 1, 'Pembukaan Cabang Manna Kampus 7', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 7.'),
(47, 'Pembukaan Cabang Manna Kampus 8', 'pembukaan-cabang-manna-kampus-8', '<p>Cabang kedelapan Manna Kampus resmi dibuka sebagai pencapaian penting dalam memperluas jejak dampak organisasi. Dengan hadirnya cabang ini, Manna Kampus semakin siap menjadi wadah pengembangan potensi manusia yang lebih luas.</p><p>Acara pembukaan menjadi momen kebersamaan bagi komunitas, pendukung, dan relawan yang terus mendorong program pendidikan serta pemberdayaan masyarakat di berbagai daerah.</p>', 'Cabang kedelapan Manna Kampus dibuka sebagai tonggak perluasan dampak dan kolaborasi.', '04-08-2025', 'mk8.png', 1, 'Manna Kampus', 0, 'Pembukaan Cabang Manna Kampus 8', 'manna kampus, cabang, pembukaan', 'Berita pembukaan cabang Manna Kampus 8.'),
(48, 'Mini MK Resmi Dibuka', 'mini-mk-resmi-dibuka', '<p>Mini MK resmi dibuka sebagai program inovatif Manna Kampus yang menghadirkan pengalaman belajar singkat namun berdampak besar bagi peserta. Konsep Mini MK dirancang agar masyarakat dapat merasakan semangat pendidikan, kreativitas, dan semangat gotong royong dalam ruang yang lebih sederhana.</p><p>Dalam program ini, peserta mengikuti sesi inspirasi, pelatihan dasar, dan aktivitas komunitas yang menumbuhkan rasa percaya diri serta kesiapan menghadapi tantangan masa depan.</p>', 'Mini MK resmi dibuka sebagai program pendidikan singkat yang menumbuhkan kreativitas dan semangat belajar.', '12-09-2025', 'mini1.png', 1, 'Manna Kampus', 2, 'Mini MK Resmi Dibuka', 'mini mk, manna kampus, pendidikan', 'Berita peluncuran program Mini MK Manna Kampus.');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`news_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
