-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Okt 2024 pada 09.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `nama_pelanggan` varchar(30) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `kuantitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_paket`, `nama_pelanggan`, `telepon`, `kuantitas`) VALUES
(8, 23, 7, 'manusia', '08976566', 3),
(9, 24, 7, 'manusia', '08976566', 2),
(10, 25, 17, 'orang', '08976566', 2),
(11, 26, 17, 'orang', '08976566', 3),
(12, 27, 17, 'orang', '08976566', 2),
(13, 28, 17, 'orang', '085774136308', 2),
(14, 29, 17, 'rapi', '08976566', 4),
(15, 30, 17, 'orang', '08976566', 5),
(16, 31, 17, 'orang', '085774136308', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `kelurahan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id`, `kelurahan`) VALUES
(1, 'Munjul'),
(2, 'Cilangkap'),
(3, 'Cipayung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `jenkel` varchar(15) NOT NULL,
  `alamat` varchar(60) NOT NULL,
  `telepon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`id`, `nama`, `jenkel`, `alamat`, `telepon`) VALUES
(2, 'katiar', 'Laki-laki', 'Jalan Buni,GG Mawar Rt008 Rw04 Kelurahan Munjul', '085774136308');

-- --------------------------------------------------------

--
-- Struktur dari tabel `outlet`
--

CREATE TABLE `outlet` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `background` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `outlet`
--

INSERT INTO `outlet` (`id`, `nama`, `alamat`, `telepon`, `background`) VALUES
(3, 'Laundry', 'jalanan', '08573848638', 'outlet/laundry.jpg'),
(20, 'manusia', 'jalanan', '08976566', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id` int(100) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id`, `id_outlet`, `jenis`, `nama`, `deskripsi`, `harga`) VALUES
(17, 3, 'Cuci Kering Lipat', 'cuci kilat', 'bakso enak daging sapi asli', 15000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `tanggal_bayar` date NOT NULL DEFAULT current_timestamp(),
  `biaya_tambahan` int(11) NOT NULL,
  `diskon` double NOT NULL,
  `pajak` int(11) NOT NULL,
  `status` enum('baru','proses','selesai','diambil') NOT NULL,
  `dibayar` enum('unpaid','paid') NOT NULL,
  `subtotal` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_outlet`, `invoice`, `tanggal_bayar`, `biaya_tambahan`, `diskon`, `pajak`, `status`, `dibayar`, `subtotal`, `id_user`) VALUES
(25, 3, 'INV2410088466', '2024-10-09', 300, 0, 1500, 'baru', 'paid', 15000, 1),
(26, 3, 'INV2410089645', '2024-10-09', 450, 0, 1500, 'baru', 'paid', 45000, 1),
(27, 3, 'INV2410086301', '2024-10-09', 300, 0, 1500, 'baru', 'paid', 30000, 1),
(28, 3, 'INV2410093491', '2024-10-09', 300, 0, 1500, 'baru', 'paid', 30000, 1),
(29, 3, 'INV2410096184', '2024-10-09', 600, 0, 1500, 'baru', 'paid', 60000, 1),
(30, 3, 'INV2410095920', '2024-10-09', 750, 0.2, 1500, 'baru', 'paid', 78000, 1),
(31, 3, 'INV2410093451', '2024-10-09', 450, 0, 1500, 'baru', 'paid', 46500, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `role` enum('kasir','admin','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `id_outlet`, `role`) VALUES
(1, 'katiar', 'katiar', '$2y$10$pyC8YCTNpuS/Te15FYUGj.hbUWANuteB8CxO3j7vLaWMzCQ0Hxubm', 3, 'admin'),
(2, 'sabib', 'sabib', '$2y$10$7pZNWUVJ6XN2ahDCugEEzukI1gfxkdgVXJfmtea9kynngDKdTghUy', 3, 'kasir'),
(4, 'orang', 'gatau', '$2y$10$5SrwIJsNV35Awn7YTlFJV.g5w91bkRE7q0/wPIRsglRXTq9SuzPKi', 0, ''),
(5, 'ddd', 'ddd', '$2y$10$1i96VKk/WJ1jcXdtvNABDOduKO8FQmu6ZVHeNZWyEf1IAdSiIx/dG', 0, ''),
(7, 'manusia', 'admin', '$2y$10$3h/1qdegfSLgbN0LK8rvuellw8mhTb0eIVwqtUVaRNbItynjkzR.e', 3, 'admin'),
(8, 'katiar', 'katiar', '$2y$10$xnwlet8s2UVv72eoBIYk5.Hiw.dcSffMIK8XW8TE0o9DpBv0V4uGC', 3, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `outlet`
--
ALTER TABLE `outlet`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_outlet` (`id_outlet`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `outlet`
--
ALTER TABLE `outlet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD CONSTRAINT `paket_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `outlet` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
