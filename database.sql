-- Buat database
CREATE DATABASE IF NOT EXISTS inventaris_senjata;
USE inventaris_senjata;

-- Buat tabel mahasiswa
CREATE TABLE IF NOT EXISTS `mahasiswa` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(255) NOT NULL,
    `nim` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
);

-- Buat tabel senjata
CREATE TABLE IF NOT EXISTS `senjata` (
    `idsenjata` INT NOT NULL AUTO_INCREMENT,
    `nosenjata` VARCHAR(50) NOT NULL,
    `keterangan` TEXT NOT NULL,
    `kodeqr` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`idsenjata`)
);

-- Buat tabel acara_dinas
CREATE TABLE IF NOT EXISTS `acara_dinas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nama_acara` VARCHAR(255) NOT NULL,
    `jenis_dinas` ENUM('Luar', 'Dalam') NOT NULL,
    PRIMARY KEY (`id`)
);

-- Buat tabel pengambilan
CREATE TABLE IF NOT EXISTS `pengambilan` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idsenjata` INT NOT NULL,
    `tanggal` DATE NOT NULL,
    `penerima` VARCHAR(255) NOT NULL,
    `id_acara_dinas` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`idsenjata`) REFERENCES `senjata`(`idsenjata`),
    FOREIGN KEY (`id_acara_dinas`) REFERENCES `acara_dinas`(`id`)
);
