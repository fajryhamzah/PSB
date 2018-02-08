-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2018 at 01:47 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penerimaan_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_siswa`
--

CREATE TABLE `detail_siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(35) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(9) DEFAULT NULL,
  `alamat` text,
  `asal_sekolah` varchar(30) DEFAULT NULL,
  `nama_ayah` varchar(35) DEFAULT NULL,
  `alamat_ayah` text,
  `id_pekerjaan_ayah` int(3) DEFAULT NULL,
  `nama_ibu` varchar(35) DEFAULT NULL,
  `alamat_ibu` text,
  `id_pekerjaan_ibu` int(3) DEFAULT NULL,
  `status_ibu` varchar(20) NOT NULL,
  `status_ayah` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_siswa`
--

INSERT INTO `detail_siswa` (`id`, `nama`, `tgl_lahir`, `jenis_kelamin`, `alamat`, `asal_sekolah`, `nama_ayah`, `alamat_ayah`, `id_pekerjaan_ayah`, `nama_ibu`, `alamat_ibu`, `id_pekerjaan_ibu`, `status_ibu`, `status_ayah`) VALUES
(7, 'Akbar Agustin', '2015-04-20', 'L', 'Jl. Sekeloa no.11/12 rt.05 rw.07', 'SMP 2 Bandung', 'Agustin Mahone', 'Jl. Sekeloa no.11/12 rt.05 rw.07', 1, 'Jihan', 'Jl. Sekeloa no.11/12 rt.05 rw.07', 4, '0', '0'),
(10, 'Akhmad Niko', '2017-10-04', 'L', 'Jl. Gardu Tanjak no. 20/20 rt. 04 rw.05', 'SMA 1 Pandeglang', 'Akhmad', 'Jl. Gardu Tanjak no. 20/20 rt. 04 rw.05', NULL, 'Inas', 'Jl. Gardu Tanjak no. 20/20 rt. 04 rw.05', NULL, '', ''),
(11, 'Nizar', '1998-11-11', 'L', 'afdagfrfsa', 'SMP 02 BANDUNG', 'tryryry', 'dsagdsgdsgdsgd', NULL, 'hgjkk', 'hthththth', NULL, '', ''),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', ''),
(43, 'rayiso', '1999-04-09', 'L', 'bandung', 'smp 3 bandung', 'uzepp', 'bandung jawa barat', 3, 'bibi may', 'bandung jawa barat', 4, '0', '0'),
(44, 'dicky aceng', '2000-02-03', 'L', 'jl.kadungora garut jawa barat', 'smp 4 kadungora', 'jajang', 'kadungora garut jawa barat', 2, 'asih putri', 'kadungora garut', 1, '0', '0'),
(46, 'rangga yadi', '2000-05-05', 'L', 'jakarta selatan', 'smp 4 jakarta', 'ujang', 'jakarta', 5, 'puput', 'jakarta', 3, '0', '0'),
(47, 'erlangga', '2000-07-15', 'L', 'garut jawa barat', 'smp 11 garut', 'ujang septo', 'garut jawa barat', 5, 'euis puput', 'garut jawa barat', 4, '0', '0'),
(48, 'angga saraceng', '1999-11-05', 'L', 'cisarua jakarta', 'smp 6 cisarua', 'jajang nur', 'jakarta', 2, 'venny', 'jakarta', 1, '0', '0'),
(49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', ''),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', ''),
(53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', ''),
(55, 'Setya Novanto', '2017-12-12', 'L', 'adadsadsadsad', 'SMP 02 BANDUNG', 'asdasdsadsad', 'adasdsa', 1, 'geegegeg', 'asdsadsad', 1, '0', '0'),
(57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_ujian`
--

CREATE TABLE `nilai_ujian` (
  `id_nilai_ujian` int(11) NOT NULL,
  `id_ujian` int(11) DEFAULT NULL,
  `id_penilai` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `nilai` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai_ujian`
--

INSERT INTO `nilai_ujian` (`id_nilai_ujian`, `id_ujian`, `id_penilai`, `id_siswa`, `nilai`) VALUES
(2, 1, 4, 11, 100),
(3, 2, 4, 10, 50),
(5, 1, 4, 10, 70),
(18, 1, 19, 44, 89),
(19, 2, 19, 44, 75),
(20, 1, 20, 46, 75),
(21, 2, 20, 46, 87),
(22, 1, 21, 47, 95),
(23, 2, 21, 47, 76),
(24, 1, 24, 48, 77),
(25, 2, 24, 48, 78),
(26, 2, 4, 7, 90),
(29, 2, 4, 11, 80),
(30, 1, 56, 55, 40);

-- --------------------------------------------------------

--
-- Table structure for table `no_telp`
--

CREATE TABLE `no_telp` (
  `id` int(11) NOT NULL,
  `no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `no_telp`
--

INSERT INTO `no_telp` (`id`, `no`) VALUES
(7, '08123456789'),
(47, '08916671544'),
(55, '081546548956');

-- --------------------------------------------------------

--
-- Table structure for table `no_telp_ayah`
--

CREATE TABLE `no_telp_ayah` (
  `id` int(11) NOT NULL,
  `no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `no_telp_ayah`
--

INSERT INTO `no_telp_ayah` (`id`, `no`) VALUES
(7, '081546987456'),
(47, '08916671544'),
(55, '081546548956');

-- --------------------------------------------------------

--
-- Table structure for table `no_telp_ibu`
--

CREATE TABLE `no_telp_ibu` (
  `id` int(11) NOT NULL,
  `no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `no_telp_ibu`
--

INSERT INTO `no_telp_ibu` (`id`, `no`) VALUES
(7, '081546987458'),
(47, '08916671544'),
(55, '081546548956');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int(3) NOT NULL,
  `nama_pekerjaan` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_pekerjaan`, `nama_pekerjaan`) VALUES
(1, 'PNS'),
(2, 'Karyawan'),
(3, 'Wiraswasta'),
(4, 'Ibu Rumah Tangga'),
(5, 'Buruh');

-- --------------------------------------------------------

--
-- Table structure for table `persyaratan`
--

CREATE TABLE `persyaratan` (
  `id` int(11) NOT NULL,
  `foto` varchar(25) DEFAULT NULL,
  `kartu_keluarga` varchar(25) DEFAULT NULL,
  `skhun` varchar(25) DEFAULT NULL,
  `surat_keterangan_pindah_kota` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `persyaratan`
--

INSERT INTO `persyaratan` (`id`, `foto`, `kartu_keluarga`, `skhun`, `surat_keterangan_pindah_kota`) VALUES
(1, NULL, NULL, NULL, NULL),
(7, 'foto_7.jpeg', 'kk_7.png', 'skhun_7.jpeg', 'skpk_7.jpeg'),
(11, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, NULL),
(43, NULL, NULL, NULL, NULL),
(44, NULL, NULL, NULL, NULL),
(46, NULL, NULL, NULL, NULL),
(47, 'foto_47.jpeg', 'kk_47.jpeg', 'skhun_47.jpeg', NULL),
(48, 'foto_48.jpeg', 'kk_48.jpeg', 'skhun_48.jpeg', NULL),
(49, 'foto_49.jpeg', NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL),
(53, NULL, NULL, NULL, NULL),
(55, NULL, NULL, NULL, NULL),
(57, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id_prestasi` int(11) NOT NULL,
  `nama_prestasi` varchar(25) NOT NULL,
  `keterangan` varchar(25) DEFAULT NULL,
  `dokumen` varchar(40) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `id_penilai` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id_prestasi`, `nama_prestasi`, `keterangan`, `dokumen`, `id`, `id_penilai`, `nilai`) VALUES
(1, 'Pelajar Teladan', 'gfdgfgfdgfdg', '5b09bef57b78aab6656e9685ba4c95e6.jpeg', 7, 4, 70),
(2, 'hgdsdf', 'sdfsdfsdf', NULL, 7, 4, 80),
(7, 'juara poli', 'juara 1 poli putra', '244aadb94b5ca8e3654e3504d80a08a3.jpeg', 43, 19, 76),
(8, 'juara web ipb 2016', 'juara 1 kategoriblog staf', '90500500469de8c0dfd507a853f3e626.jpeg', 44, 19, 80),
(9, 'juara futsal', 'juara 1 futsal jabar', 'c28058a8df14f7245a33d68e93b46622.jpeg', 48, 19, 75),
(10, 'begadang', 'begadang 24 jam', '326d8021d577f8c44efa4cc140395f65.jpeg', 7, NULL, NULL),
(11, 'testetet', 'asdasdasd', '70f0d9fd0797a5afde704b9900f34c4e.png', 55, NULL, NULL),
(12, 'tidur', 'tidur', NULL, 7, NULL, NULL),
(13, 'asdsadsad', 'sadasdasd', NULL, 57, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `name` varchar(20) NOT NULL,
  `nilai` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`name`, `nilai`) VALUES
('kuota', '1000'),
('tahun_ajaran', '2017'),
('tgl_buka', '2018/01/04'),
('tgl_mulai', '2017/11/25'),
('tgl_selesai', '2018/02/08'),
('tgl_tutup_prestasi', '2018/12/18');

-- --------------------------------------------------------

--
-- Table structure for table `terpilih`
--

CREATE TABLE `terpilih` (
  `id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terpilih`
--

INSERT INTO `terpilih` (`id`, `status`) VALUES
(43, 'Prestasi'),
(44, 'Prestasi'),
(55, 'Nilai');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id_ujian` int(11) NOT NULL,
  `nama_ujian` varchar(10) NOT NULL,
  `persentase` int(3) NOT NULL,
  `tahun_ajaran` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id_ujian`, `nama_ujian`, `persentase`, `tahun_ajaran`) VALUES
(1, 'Wawancara', 50, '2017'),
(2, 'Tulis', 50, '2017'),
(4, 'Wawancara', 100, '2018');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(30) NOT NULL,
  `id_tipe` int(10) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `aktif` int(1) NOT NULL DEFAULT '1',
  `tahun_ajaran` varchar(5) NOT NULL DEFAULT '2017'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `id_tipe`, `tgl_daftar`, `aktif`, `tahun_ajaran`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 1, '0000-00-00', 1, '2017'),
(2, 'Rayan', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'qwert@gmail.com', 2, '2017-10-22', 1, '2017'),
(4, 'fajry', 'c9f3c074553092f955878fa4f5856201', 'asdfg@gmail.com', 2, '2017-10-22', 1, '2017'),
(5, 'agun', '60f787d1ef906a9efcf87cdc01fa0f07', 'lkjhg@gmail.com', 2, '2017-10-22', 1, '2017'),
(6, 'abdan', 'eb89f40da6a539dd1b1776e522459763', 'zxcvb@gmail.com', 2, '2017-10-22', 1, '2017'),
(7, 'akbar', '4f033a0a2bf2fe0b68800a3079545cd1', 'mnbvc@gmail.com', 3, '2017-10-22', 1, '2017'),
(10, 'nikoah', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'qwerty123@gmail.com', 3, '2017-10-22', 1, '2017'),
(11, 'nizar', 'bf93e5f003e40c3fba44e512aecd3cdc', 'asdfg321@gmail.com', 3, '2017-10-22', 1, '2017'),
(12, 'moretest', 'b626f2e6367fd04971383156e62fa545', 'mote@mote.com', 3, '2017-10-26', 1, '2017'),
(19, 'Asep01', 'fcea920f7412b5da7be0cf42b8c93759', 'asep01@gmail.com', 2, '2017-12-10', 1, '2017'),
(20, 'Asep02', 'fcea920f7412b5da7be0cf42b8c93759', 'asep02@gmail.com', 2, '2017-12-10', 1, '2017'),
(21, 'Asep03', 'fcea920f7412b5da7be0cf42b8c93759', 'asep03@gmail.com', 2, '2017-12-10', 1, '2017'),
(22, 'Asep04', 'fcea920f7412b5da7be0cf42b8c93759', 'asep04@gmail.com', 2, '2017-12-10', 1, '2017'),
(24, 'Asep05', 'fcea920f7412b5da7be0cf42b8c93759', 'asep05@gmail.com', 2, '2017-12-10', 1, '2017'),
(43, 'rayiso', 'fcea920f7412b5da7be0cf42b8c93759', 'rayiso@gmail.com', 3, '2017-12-10', 1, '2017'),
(44, 'dicky', 'fcea920f7412b5da7be0cf42b8c93759', 'dicky@gmail.com', 3, '2017-12-10', 1, '2017'),
(46, 'rangga', 'fcea920f7412b5da7be0cf42b8c93759', 'rangga@gmail.com', 3, '2017-12-10', 1, '2017'),
(47, 'erlangga', 'fcea920f7412b5da7be0cf42b8c93759', 'erlangga@gmail.com', 3, '2017-12-10', 1, '2017'),
(48, 'angga', 'fcea920f7412b5da7be0cf42b8c93759', 'angga@gmail.com', 3, '2017-12-10', 1, '2017'),
(49, 'tester', 'f5d1278e8109edd94e1e4197e04873b9', 'tester@tester.com', 3, '2017-12-12', 1, '2017'),
(50, 'falllein', '3842468dbd1fcd4a0dd44cb3a8d1c351', 'asdas@asdad.com', 3, '2017-12-12', 0, '2017'),
(53, 'setnov', 'b6aa4145827b3225af567c7ab9d3b2a5', 'setnov123@gmail.com', 3, '2017-12-18', 1, '2017'),
(55, 'setnov', '74a5a071077ba804742c6a78264d1f19', 'setnov@set.vom', 3, '2017-12-18', 1, '2018'),
(56, 'fajry', 'c9f3c074553092f955878fa4f5856201', 'fajryhamzah@gmail.com', 2, '2017-12-18', 1, '2018'),
(57, 'mabel', 'c54fdf9dd28d984697251054720c50cf', 'mabel@gmail.com', 3, '2017-12-22', 1, '2017');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pekerjaan_ayah` (`id_pekerjaan_ayah`),
  ADD KEY `id_pekerjaan_ibu` (`id_pekerjaan_ibu`);

--
-- Indexes for table `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  ADD PRIMARY KEY (`id_nilai_ujian`),
  ADD UNIQUE KEY `unique` (`id_ujian`,`id_siswa`) USING BTREE,
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_penilai` (`id_penilai`);

--
-- Indexes for table `no_telp`
--
ALTER TABLE `no_telp`
  ADD UNIQUE KEY `no` (`no`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `no_telp_ayah`
--
ALTER TABLE `no_telp_ayah`
  ADD UNIQUE KEY `no` (`no`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `no_telp_ibu`
--
ALTER TABLE `no_telp_ibu`
  ADD UNIQUE KEY `no` (`no`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id_prestasi`),
  ADD KEY `id` (`id`),
  ADD KEY `id_penilai` (`id_penilai`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `terpilih`
--
ALTER TABLE `terpilih`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id_ujian`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`,`tahun_ajaran`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  MODIFY `id_nilai_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id_prestasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD CONSTRAINT `detail_siswa_ibfk_1` FOREIGN KEY (`id_pekerjaan_ayah`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_siswa_ibfk_2` FOREIGN KEY (`id_pekerjaan_ibu`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hdfhdh` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  ADD CONSTRAINT `nilai_ujian_ibfk_3` FOREIGN KEY (`id_ujian`) REFERENCES `ujian` (`id_ujian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ujian_ibfk_4` FOREIGN KEY (`id_siswa`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ujian_ibfk_5` FOREIGN KEY (`id_penilai`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `no_telp`
--
ALTER TABLE `no_telp`
  ADD CONSTRAINT `no_telp_ibfk_1` FOREIGN KEY (`id`) REFERENCES `detail_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `no_telp_ayah`
--
ALTER TABLE `no_telp_ayah`
  ADD CONSTRAINT `no_telp_ayah_ibfk_1` FOREIGN KEY (`id`) REFERENCES `detail_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `no_telp_ibu`
--
ALTER TABLE `no_telp_ibu`
  ADD CONSTRAINT `no_telp_ibu_ibfk_1` FOREIGN KEY (`id`) REFERENCES `detail_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD CONSTRAINT `persyaratan_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD CONSTRAINT `prestasi_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prestasi_ibfk_2` FOREIGN KEY (`id_penilai`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `terpilih`
--
ALTER TABLE `terpilih`
  ADD CONSTRAINT `terpilih_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
