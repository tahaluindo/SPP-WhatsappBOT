-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jan 2022 pada 04.51
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fahmiff1_wiki`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `angsurantoko`
--

CREATE TABLE `angsurantoko` (
  `id_angsurantoko` varchar(10) NOT NULL,
  `id_hutangtoko` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `angsuran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

CREATE TABLE `bank` (
  `id` int(10) NOT NULL,
  `nmBank` varchar(100) NOT NULL,
  `atasNama` varchar(100) NOT NULL,
  `noRek` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`id`, `nmBank`, `atasNama`, `noRek`) VALUES
(1, 'BRI', 'Lembaga Pendidikan Al Fatah', 2147483647),
(2, 'MANDIRI', 'Lembaga Al Fatah ', 342252);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bulan`
--

CREATE TABLE `bulan` (
  `idBulan` varchar(15) NOT NULL DEFAULT '0',
  `nmBulan` varchar(25) DEFAULT NULL,
  `urutan` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bulan`
--

INSERT INTO `bulan` (`idBulan`, `nmBulan`, `urutan`) VALUES
('1', 'Januari', 7),
('10', 'Oktober', 4),
('11', 'November', 5),
('12', 'Desember', 6),
('2', 'Februari', 8),
('3', 'Maret', 9),
('4', 'April', 10),
('5', 'Mei', 11),
('6', 'Juni', 12),
('7', 'Juli', 1),
('8', 'Agustus', 2),
('9', 'September', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cron`
--

CREATE TABLE `cron` (
  `id` int(11) NOT NULL,
  `con` text,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `id` int(11) NOT NULL,
  `nmDonasi` varchar(100) NOT NULL,
  `noRek` int(15) NOT NULL,
  `tanggal` datetime NOT NULL,
  `idSiswa` int(10) NOT NULL,
  `jumlahDonasi` varchar(100) NOT NULL,
  `buktiTf` varchar(100) NOT NULL,
  `status` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`id`, `nmDonasi`, `noRek`, `tanggal`, `idSiswa`, `jumlahDonasi`, `buktiTf`, `status`) VALUES
(34, 'Donasi', 2147483647, '2022-01-08 20:20:36', 7, '4000000', '', 'Y'),
(35, 'Donasi', 342252, '2022-01-08 20:56:28', 7, '5000', '', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hutangtoko`
--

CREATE TABLE `hutangtoko` (
  `id_hutangtoko` varchar(10) NOT NULL,
  `hutangke` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `ket` varchar(100) NOT NULL,
  `nominal` int(11) NOT NULL,
  `sisa` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Struktur dari tabel `identitas`
--

CREATE TABLE `identitas` (
  `npsn` varchar(8) NOT NULL,
  `nmSekolah` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `propinsi` varchar(100) NOT NULL,
  `nipKepsek` varchar(20) DEFAULT NULL,
  `nmKepsek` varchar(100) DEFAULT NULL,
  `nipKaTU` varchar(200) DEFAULT NULL,
  `nmKaTU` varchar(100) DEFAULT NULL,
  `nipBendahara` varchar(200) DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `link_one_sender` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `wa` varchar(100) NOT NULL,
  `nmBendahara` varchar(100) DEFAULT NULL,
  `logo_kiri` varchar(255) DEFAULT NULL,
  `logo_kanan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `identitas`
--

INSERT INTO `identitas` (`npsn`, `nmSekolah`, `alamat`, `kabupaten`, `propinsi`, `nipKepsek`, `nmKepsek`, `nipKaTU`, `nmKaTU`, `nipBendahara`, `link`, `link_one_sender`, `token`, `wa`, `nmBendahara`, `logo_kiri`, `logo_kanan`) VALUES
('10700295', 'Percobaan', 'Jl. Angker No.111', 'Surabaya', 'Jawa Timur ', 'false', 'Jojon.Spd.', 'SB-Mid-server-MGrqH0etTuGjr6n5d432VINL', 'ANISA ANJARSARI ', 'SB-Mid-client-HoGPUS9TvPG38_3Z', 'https://app.sandbox.midtrans.com/snap/snap.js', 'https://wa.juraganitweb.com/api/send-message.php', '68172c4edaca837ea3c2ff948a57ccc28c9db3a8', '6285156619657', 'SHOLIHATUL FAHMI', 'APA AJA.png', 'Barokah Channel.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_bayar`
--

CREATE TABLE `jenis_bayar` (
  `idJenisBayar` int(10) NOT NULL,
  `idPosBayar` int(5) DEFAULT NULL,
  `idTahunAjaran` int(5) DEFAULT NULL,
  `nmJenisBayar` varchar(100) DEFAULT NULL,
  `tipeBayar` enum('bulanan','bebas') DEFAULT 'bulanan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_bayar`
--

INSERT INTO `jenis_bayar` (`idJenisBayar`, `idPosBayar`, `idTahunAjaran`, `nmJenisBayar`, `tipeBayar`) VALUES
(5, 13, 11, 'SPP', 'bulanan'),
(6, 14, 11, 'SPP ', 'bulanan'),
(7, 15, 11, 'SPP ', 'bulanan'),
(8, 16, 11, 'SPP ', 'bulanan'),
(9, 17, 11, 'SPP ', 'bulanan'),
(10, 14, 11, 'QURBAN', 'bebas'),
(11, 13, 11, 'LAUNDRY 1', 'bebas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_umum`
--

CREATE TABLE `jurnal_umum` (
  `id` int(50) NOT NULL,
  `tgl` date DEFAULT NULL,
  `ket` varchar(100) DEFAULT NULL,
  `penerimaan` int(10) DEFAULT '0',
  `pengeluaran` int(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal_umum`
--

INSERT INTO `jurnal_umum` (`id`, `tgl`, `ket`, `penerimaan`, `pengeluaran`) VALUES
(1, '2022-01-15', 'hluegte', 0, 800000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kas`
--

CREATE TABLE `kas` (
  `kode` int(11) NOT NULL,
  `keterangan` varchar(300) NOT NULL,
  `idKelas` int(50) NOT NULL,
  `tgl` date NOT NULL,
  `jumlah` int(10) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `keluar` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_siswa`
--

CREATE TABLE `kelas_siswa` (
  `idKelas` int(5) NOT NULL,
  `nmKelas` varchar(20) DEFAULT NULL,
  `ketKelas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kelas_siswa`
--

INSERT INTO `kelas_siswa` (`idKelas`, `nmKelas`, `ketKelas`) VALUES
(1, '1 A', 'SD Al Fatah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kwitansi`
--

CREATE TABLE `kwitansi` (
  `id_kwitansi` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `tgl_cetak` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kwitansi`
--

INSERT INTO `kwitansi` (`id_kwitansi`, `id_siswa`, `tgl_cetak`) VALUES
(1, 299, '2021-07-14'),
(5, 299, '2021-07-14'),
(6, 299, '2021-07-14'),
(7, 299, '2021-07-14'),
(8, 299, '2021-07-14'),
(9, 299, '2021-07-17'),
(10, 299, '2021-07-17'),
(11, 299, '2021-07-18'),
(12, 299, '2021-07-18'),
(13, 320, '2021-07-19'),
(14, 317, '2021-07-19'),
(15, 305, '2021-07-20'),
(16, 306, '2021-07-22'),
(17, 299, '2021-07-22'),
(18, 299, '2021-07-24'),
(19, 299, '2021-07-25'),
(20, 299, '2021-07-25'),
(21, 299, '2021-07-26'),
(22, 299, '2021-07-26'),
(23, 299, '2021-07-28'),
(24, 6, '2021-12-26'),
(25, 6, '2021-12-26'),
(26, 6, '2021-12-26'),
(27, 6, '2021-12-30'),
(28, 6, '2022-01-02'),
(29, 6, '2022-01-02'),
(30, 6, '2022-01-02'),
(31, 1, '2022-01-02'),
(32, 6, '2022-01-02'),
(33, 1, '2022-01-02'),
(34, 1, '2022-01-02'),
(35, 1, '2022-01-02'),
(36, 6, '2022-01-02'),
(37, 6, '2022-01-02'),
(38, 6, '2022-01-02'),
(39, 6, '2022-01-02'),
(40, 6, '2022-01-02'),
(41, 6, '2022-01-02'),
(42, 6, '2022-01-02'),
(43, 6, '2022-01-02'),
(44, 6, '2022-01-02'),
(45, 6, '2022-01-02'),
(46, 6, '2022-01-02'),
(47, 6, '2022-01-02'),
(48, 6, '2022-01-02'),
(49, 6, '2022-01-02'),
(50, 6, '2022-01-02'),
(51, 6, '2022-01-02'),
(52, 6, '2022-01-05'),
(53, 7, '2022-01-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mitra`
--

CREATE TABLE `mitra` (
  `id` int(10) NOT NULL,
  `nmMitra` varchar(100) NOT NULL,
  `linkMitra` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mitra`
--

INSERT INTO `mitra` (`id`, `nmMitra`, `linkMitra`) VALUES
(1, 'Bank BRI', 'https://juraganitweb.com/'),
(2, 'Pulsa', 'https://wa.juraganitweb.com/');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos_bayar`
--

CREATE TABLE `pos_bayar` (
  `idPosBayar` int(5) NOT NULL,
  `nmPosBayar` varchar(100) DEFAULT NULL,
  `ketPosBayar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pos_bayar`
--

INSERT INTO `pos_bayar` (`idPosBayar`, `nmPosBayar`, `ketPosBayar`) VALUES
(13, 'TK', 'TK Al Fatah'),
(14, 'SD', 'SD Al Fatah'),
(15, 'SMP', 'SMP Al Fatah'),
(16, 'TPQ', 'TPQ Darul Fattah'),
(17, 'Pesantren', 'Pesantren Darul Fattah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `idSiswa` int(10) NOT NULL,
  `nisSiswa` varchar(25) DEFAULT NULL,
  `nisnSiswa` varchar(25) DEFAULT NULL,
  `nmSiswa` varchar(100) DEFAULT NULL,
  `jkSiswa` varchar(15) DEFAULT NULL,
  `agamaSiswa` varchar(15) DEFAULT NULL,
  `idKelas` int(5) DEFAULT NULL,
  `statusSiswa` enum('Aktif','Non Aktif','Pindah','Drop Out','Lulus') DEFAULT 'Aktif',
  `username` varchar(20) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `level` varchar(10) NOT NULL,
  `nmOrtu` varchar(40) DEFAULT NULL,
  `alamatOrtu` varchar(100) DEFAULT NULL,
  `noHpOrtu` varchar(30) DEFAULT NULL,
  `noHpSis` varchar(30) DEFAULT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`idSiswa`, `nisSiswa`, `nisnSiswa`, `nmSiswa`, `jkSiswa`, `agamaSiswa`, `idKelas`, `statusSiswa`, `username`, `password`, `level`, `nmOrtu`, `alamatOrtu`, `noHpOrtu`, `noHpSis`, `saldo`) VALUES
(7, '123', '123456', 'Rivani Noer Maulidi', 'L', 'Islam', 1, 'Aktif', 'siswa', 'siswa', 'siswa', 'Hadiri', 'Sampangan Muncar', '6285156619657', '6285156619657', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan_bebas`
--

CREATE TABLE `tagihan_bebas` (
  `idTagihanBebas` int(50) NOT NULL,
  `idJenisBayar` int(5) DEFAULT NULL,
  `idSiswa` int(10) DEFAULT NULL,
  `idKelas` int(5) DEFAULT NULL,
  `idBulan` int(10) NOT NULL,
  `totalTagihan` int(10) DEFAULT NULL,
  `ref` varchar(100) NOT NULL,
  `statusBayar` enum('0','1','2') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tagihan_bebas`
--

INSERT INTO `tagihan_bebas` (`idTagihanBebas`, `idJenisBayar`, `idSiswa`, `idKelas`, `idBulan`, `totalTagihan`, `ref`, `statusBayar`) VALUES
(26, 11, 7, 1, 1, 300000, '', '0'),
(29, 10, 7, 1, 1, 55000, '', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan_bebas_bayar`
--

CREATE TABLE `tagihan_bebas_bayar` (
  `idTagihanBebasBayar` int(50) NOT NULL,
  `idTagihanBebas` int(50) DEFAULT NULL,
  `tglBayar` date DEFAULT NULL,
  `jumlahBayar` int(10) DEFAULT NULL,
  `ketBayar` varchar(100) DEFAULT NULL,
  `caraBayar` enum('Tunai','Transfer') DEFAULT 'Tunai'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan_bulanan`
--

CREATE TABLE `tagihan_bulanan` (
  `idTagihanBulanan` int(50) NOT NULL,
  `idJenisBayar` int(5) DEFAULT NULL,
  `idSiswa` int(10) DEFAULT NULL,
  `idKelas` int(5) DEFAULT NULL,
  `idBulan` varchar(15) DEFAULT NULL,
  `jumlahBayar` int(10) DEFAULT NULL,
  `tglBayar` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tglUpdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `inv` varchar(100) NOT NULL,
  `statusBayar` enum('0','1','2') DEFAULT '0',
  `caraBayar` enum('Tunai','Transfer','Transfer Midtrans') DEFAULT 'Tunai'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tagihan_bulanan`
--

INSERT INTO `tagihan_bulanan` (`idTagihanBulanan`, `idJenisBayar`, `idSiswa`, `idKelas`, `idBulan`, `jumlahBayar`, `tglBayar`, `tglUpdate`, `inv`, `statusBayar`, `caraBayar`) VALUES
(73, 6, 7, 1, '1', 200000, NULL, NULL, '', '0', 'Tunai'),
(74, 6, 7, 1, '2', 200000, NULL, NULL, '', '0', 'Tunai'),
(75, 6, 7, 1, '3', 200000, NULL, NULL, '', '0', 'Tunai'),
(76, 6, 7, 1, '4', 200000, NULL, NULL, '', '0', 'Tunai'),
(77, 6, 7, 1, '5', 200000, NULL, NULL, '', '0', 'Tunai'),
(78, 6, 7, 1, '6', 200000, NULL, NULL, '', '0', 'Tunai'),
(79, 6, 7, 1, '7', 200000, '2022-01-08 13:24:16', '2022-01-08 13:24:13', '', '1', 'Tunai'),
(80, 6, 7, 1, '8', 200000, '2022-01-09 06:22:03', '2022-01-09 06:21:59', '', '1', 'Transfer'),
(81, 6, 7, 1, '9', 200000, NULL, NULL, '', '0', 'Tunai'),
(82, 6, 7, 1, '10', 200000, NULL, NULL, '', '0', 'Tunai'),
(83, 6, 7, 1, '11', 200000, NULL, NULL, '', '0', 'Tunai'),
(84, 6, 7, 1, '12', 200000, NULL, NULL, '', '0', 'Tunai'),
(85, 5, 7, 1, '1', 200000, NULL, NULL, '', '0', 'Tunai'),
(86, 5, 7, 1, '2', 200000, NULL, NULL, '', '0', 'Tunai'),
(87, 5, 7, 1, '3', 200000, NULL, NULL, '', '0', 'Tunai'),
(88, 5, 7, 1, '4', 200000, NULL, NULL, '', '0', 'Tunai'),
(89, 5, 7, 1, '5', 200000, NULL, NULL, '', '0', 'Tunai'),
(90, 5, 7, 1, '6', 200000, NULL, NULL, '', '0', 'Tunai'),
(91, 5, 7, 1, '7', 200000, '2022-01-15 10:31:13', '2022-01-15 10:31:08', '', '1', 'Tunai'),
(92, 5, 7, 1, '8', 200000, NULL, NULL, '', '0', 'Tunai'),
(93, 5, 7, 1, '9', 200000, NULL, NULL, '', '0', 'Tunai'),
(94, 5, 7, 1, '10', 200000, NULL, NULL, '', '0', 'Tunai'),
(95, 5, 7, 1, '11', 200000, NULL, NULL, '', '0', 'Tunai'),
(96, 5, 7, 1, '12', 200000, NULL, NULL, '', '0', 'Tunai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `idTahunAjaran` int(5) NOT NULL,
  `nmTahunAjaran` varchar(9) DEFAULT NULL,
  `aktif` enum('Y','T') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`idTahunAjaran`, `nmTahunAjaran`, `aktif`) VALUES
(11, '2021/2022', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(50) NOT NULL,
  `nisnSiswa` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `debit` int(10) NOT NULL,
  `kredit` int(10) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `no_telp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'admin',
  `blokir` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `idKelas` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `id_session` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `level`, `blokir`, `idKelas`, `id_session`, `last_login`) VALUES
('ade', 'a562cfa07c2b1213b3a5c99b756fc206', 'Rivani vhan', 'theivhan@gmail.com', '085366972361', 'admin', 'N', '', '', NULL),
('admin', '0192023a7bbd73250516f069df18b500', 'Rivani Noer Maulidi', 'theivhan@gmail.com', '085233072661', 'admin', 'N', '', 'vgjkducma2cld9dq2a7ahg5f04', '2022-01-15 03:49:00'),
('adminjuraganpay', '21232f297a57a5a743894a0e4a801fc3', 'Riv', 'theivhan@gmail.com', '68233072661', 'bendahara', 'N', '', '', NULL),
('koperasi', '0192023a7bbd73250516f069df18b500', 'Koperasi', 'theivhan@gmail.com', '68233072661', 'koperasi', 'N', '', '', NULL),
('wakel', '21d4cfa6c49e0bfad4b3b7484d9cd50c', 'Vivi', 'theivhan@gmail.com', '68233072661', 'wakel', 'N', '3', '', NULL);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_detil_jenis_bayar`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_detil_jenis_bayar` (
`idJenisBayar` int(10)
,`idPosBayar` int(5)
,`idTahunAjaran` int(5)
,`nmJenisBayar` varchar(100)
,`tipeBayar` enum('bulanan','bebas')
,`nmPosBayar` varchar(100)
,`nmTahunAjaran` varchar(9)
,`aktif` enum('Y','T')
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_detil_siswa`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_detil_siswa` (
`idSiswa` int(10)
,`nisSiswa` varchar(25)
,`nisnSiswa` varchar(25)
,`nmSiswa` varchar(100)
,`jkSiswa` varchar(15)
,`agamaSiswa` varchar(15)
,`idKelas` int(5)
,`statusSiswa` enum('Aktif','Non Aktif','Pindah','Drop Out','Lulus')
,`nmKelas` varchar(20)
,`ketKelas` varchar(255)
,`nmOrtu` varchar(40)
,`alamatOrtu` varchar(100)
,`noHpOrtu` varchar(30)
,`noHpSis` varchar(30)
,`saldo` double
,`username` varchar(20)
,`password` varchar(200)
,`level` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_laporan_bayar_bulanan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_laporan_bayar_bulanan` (
`idTagihanBulanan` int(50)
,`idJenisBayar` int(5)
,`idSiswa` int(10)
,`idKelas` int(5)
,`idBulan` varchar(15)
,`jumlahBayar` int(10)
,`tglBayar` datetime
,`tglUpdate` datetime
,`statusBayar` enum('0','1','2')
,`idTahunAjaran` int(5)
,`nmJenisBayar` varchar(100)
,`nmTahunAjaran` varchar(9)
,`nisSiswa` varchar(25)
,`nmSiswa` varchar(100)
,`nmKelas` varchar(20)
,`nmBulan` varchar(25)
,`urutan` int(2)
,`caraBayar` enum('Tunai','Transfer','Transfer Midtrans')
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_detil_jenis_bayar`
--
DROP TABLE IF EXISTS `view_detil_jenis_bayar`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `view_detil_jenis_bayar`  AS  select `jenis_bayar`.`idJenisBayar` AS `idJenisBayar`,`jenis_bayar`.`idPosBayar` AS `idPosBayar`,`jenis_bayar`.`idTahunAjaran` AS `idTahunAjaran`,`jenis_bayar`.`nmJenisBayar` AS `nmJenisBayar`,`jenis_bayar`.`tipeBayar` AS `tipeBayar`,`pos_bayar`.`nmPosBayar` AS `nmPosBayar`,`tahun_ajaran`.`nmTahunAjaran` AS `nmTahunAjaran`,`tahun_ajaran`.`aktif` AS `aktif` from ((`jenis_bayar` join `pos_bayar` on((`jenis_bayar`.`idPosBayar` = `pos_bayar`.`idPosBayar`))) join `tahun_ajaran` on((`jenis_bayar`.`idTahunAjaran` = `tahun_ajaran`.`idTahunAjaran`))) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_detil_siswa`
--
DROP TABLE IF EXISTS `view_detil_siswa`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `view_detil_siswa`  AS  select `siswa`.`idSiswa` AS `idSiswa`,`siswa`.`nisSiswa` AS `nisSiswa`,`siswa`.`nisnSiswa` AS `nisnSiswa`,`siswa`.`nmSiswa` AS `nmSiswa`,`siswa`.`jkSiswa` AS `jkSiswa`,`siswa`.`agamaSiswa` AS `agamaSiswa`,`siswa`.`idKelas` AS `idKelas`,`siswa`.`statusSiswa` AS `statusSiswa`,`kelas_siswa`.`nmKelas` AS `nmKelas`,`kelas_siswa`.`ketKelas` AS `ketKelas`,`siswa`.`nmOrtu` AS `nmOrtu`,`siswa`.`alamatOrtu` AS `alamatOrtu`,`siswa`.`noHpOrtu` AS `noHpOrtu`,`siswa`.`noHpSis` AS `noHpSis`,`siswa`.`saldo` AS `saldo`,`siswa`.`username` AS `username`,`siswa`.`password` AS `password`,`siswa`.`level` AS `level` from (`siswa` join `kelas_siswa` on((`siswa`.`idKelas` = `kelas_siswa`.`idKelas`))) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_laporan_bayar_bulanan`
--
DROP TABLE IF EXISTS `view_laporan_bayar_bulanan`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `view_laporan_bayar_bulanan`  AS  select `tagihan_bulanan`.`idTagihanBulanan` AS `idTagihanBulanan`,`tagihan_bulanan`.`idJenisBayar` AS `idJenisBayar`,`tagihan_bulanan`.`idSiswa` AS `idSiswa`,`tagihan_bulanan`.`idKelas` AS `idKelas`,`tagihan_bulanan`.`idBulan` AS `idBulan`,`tagihan_bulanan`.`jumlahBayar` AS `jumlahBayar`,`tagihan_bulanan`.`tglBayar` AS `tglBayar`,`tagihan_bulanan`.`tglUpdate` AS `tglUpdate`,`tagihan_bulanan`.`statusBayar` AS `statusBayar`,`jenis_bayar`.`idTahunAjaran` AS `idTahunAjaran`,`jenis_bayar`.`nmJenisBayar` AS `nmJenisBayar`,`tahun_ajaran`.`nmTahunAjaran` AS `nmTahunAjaran`,`siswa`.`nisSiswa` AS `nisSiswa`,`siswa`.`nmSiswa` AS `nmSiswa`,`kelas_siswa`.`nmKelas` AS `nmKelas`,`bulan`.`nmBulan` AS `nmBulan`,`bulan`.`urutan` AS `urutan`,`tagihan_bulanan`.`caraBayar` AS `caraBayar` from (((((`tagihan_bulanan` join `jenis_bayar` on((`tagihan_bulanan`.`idJenisBayar` = `jenis_bayar`.`idJenisBayar`))) join `tahun_ajaran` on((`jenis_bayar`.`idTahunAjaran` = `tahun_ajaran`.`idTahunAjaran`))) join `siswa` on((`tagihan_bulanan`.`idSiswa` = `siswa`.`idSiswa`))) join `kelas_siswa` on((`siswa`.`idKelas` = `kelas_siswa`.`idKelas`))) join `bulan` on((`tagihan_bulanan`.`idBulan` = `bulan`.`idBulan`))) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `angsurantoko`
--
ALTER TABLE `angsurantoko`
  ADD PRIMARY KEY (`id_angsurantoko`);

--
-- Indeks untuk tabel `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`idBulan`);

--
-- Indeks untuk tabel `cron`
--
ALTER TABLE `cron`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hutangtoko`
--
ALTER TABLE `hutangtoko`
  ADD PRIMARY KEY (`id_hutangtoko`);

--
-- Indeks untuk tabel `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`npsn`);

--
-- Indeks untuk tabel `jenis_bayar`
--
ALTER TABLE `jenis_bayar`
  ADD PRIMARY KEY (`idJenisBayar`),
  ADD KEY `fk_pos` (`idPosBayar`),
  ADD KEY `fk_tahun` (`idTahunAjaran`);

--
-- Indeks untuk tabel `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD PRIMARY KEY (`idKelas`);

--
-- Indeks untuk tabel `kwitansi`
--
ALTER TABLE `kwitansi`
  ADD PRIMARY KEY (`id_kwitansi`);

--
-- Indeks untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pos_bayar`
--
ALTER TABLE `pos_bayar`
  ADD PRIMARY KEY (`idPosBayar`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`idSiswa`),
  ADD KEY `fk_kelas` (`idKelas`),
  ADD KEY `fk_status` (`statusSiswa`);

--
-- Indeks untuk tabel `tagihan_bebas`
--
ALTER TABLE `tagihan_bebas`
  ADD PRIMARY KEY (`idTagihanBebas`),
  ADD KEY `fk_t_jenis` (`idJenisBayar`),
  ADD KEY `fk_t_siswa` (`idSiswa`),
  ADD KEY `fk_t_kelas` (`idKelas`);

--
-- Indeks untuk tabel `tagihan_bebas_bayar`
--
ALTER TABLE `tagihan_bebas_bayar`
  ADD PRIMARY KEY (`idTagihanBebasBayar`),
  ADD KEY `fkbayarbebas` (`idTagihanBebas`);

--
-- Indeks untuk tabel `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  ADD PRIMARY KEY (`idTagihanBulanan`),
  ADD KEY `fk_t_jenis` (`idJenisBayar`),
  ADD KEY `fk_t_siswa` (`idSiswa`),
  ADD KEY `fk_t_kelas` (`idKelas`),
  ADD KEY `fk_t_bulan` (`idBulan`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`idTahunAjaran`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `cron`
--
ALTER TABLE `cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `jenis_bayar`
--
ALTER TABLE `jenis_bayar`
  MODIFY `idJenisBayar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kas`
--
ALTER TABLE `kas`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  MODIFY `idKelas` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kwitansi`
--
ALTER TABLE `kwitansi`
  MODIFY `id_kwitansi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pos_bayar`
--
ALTER TABLE `pos_bayar`
  MODIFY `idPosBayar` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `idSiswa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tagihan_bebas`
--
ALTER TABLE `tagihan_bebas`
  MODIFY `idTagihanBebas` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `tagihan_bebas_bayar`
--
ALTER TABLE `tagihan_bebas_bayar`
  MODIFY `idTagihanBebasBayar` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  MODIFY `idTagihanBulanan` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `idTahunAjaran` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jenis_bayar`
--
ALTER TABLE `jenis_bayar`
  ADD CONSTRAINT `fk_pos` FOREIGN KEY (`idPosBayar`) REFERENCES `pos_bayar` (`idPosBayar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tahun` FOREIGN KEY (`idTahunAjaran`) REFERENCES `tahun_ajaran` (`idTahunAjaran`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`idKelas`) REFERENCES `kelas_siswa` (`idKelas`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan_bebas`
--
ALTER TABLE `tagihan_bebas`
  ADD CONSTRAINT `tagihan_bebas_ibfk_2` FOREIGN KEY (`idJenisBayar`) REFERENCES `jenis_bayar` (`idJenisBayar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tagihan_bebas_ibfk_3` FOREIGN KEY (`idKelas`) REFERENCES `kelas_siswa` (`idKelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tagihan_bebas_ibfk_4` FOREIGN KEY (`idSiswa`) REFERENCES `siswa` (`idSiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan_bebas_bayar`
--
ALTER TABLE `tagihan_bebas_bayar`
  ADD CONSTRAINT `fkbayarbebas` FOREIGN KEY (`idTagihanBebas`) REFERENCES `tagihan_bebas` (`idTagihanBebas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  ADD CONSTRAINT `fk_t_bulan` FOREIGN KEY (`idBulan`) REFERENCES `bulan` (`idBulan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_t_jenis` FOREIGN KEY (`idJenisBayar`) REFERENCES `jenis_bayar` (`idJenisBayar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_t_kelas` FOREIGN KEY (`idKelas`) REFERENCES `kelas_siswa` (`idKelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_t_siswa` FOREIGN KEY (`idSiswa`) REFERENCES `siswa` (`idSiswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
