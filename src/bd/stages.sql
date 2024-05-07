-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           11.1.2-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour gestion_stages
CREATE DATABASE IF NOT EXISTS `gestion_stages` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `gestion_stages`;

-- Listage de la structure de table gestion_stages. tbl_company
CREATE TABLE IF NOT EXISTS `tbl_company` (
  `id_e` int(11) NOT NULL AUTO_INCREMENT,
  `nom_e` varchar(50) DEFAULT NULL,
  `rue_e` varchar(50) DEFAULT NULL,
  `CP_e` varchar(5) DEFAULT NULL,
  `ville_e` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_e`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_company : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_degree
CREATE TABLE IF NOT EXISTS `tbl_degree` (
  `id_c` int(11) NOT NULL AUTO_INCREMENT,
  `nom_c` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_degree : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_effectuer
CREATE TABLE IF NOT EXISTS `tbl_effectuer` (
  `id_s_internship` int(11) NOT NULL,
  `id_etu_student` int(11) NOT NULL,
  PRIMARY KEY (`id_s_internship`,`id_etu_student`),
  KEY `id_etu_student` (`id_etu_student`),
  CONSTRAINT `tbl_effectuer_ibfk_1` FOREIGN KEY (`id_s_internship`) REFERENCES `tbl_stage` (`id_s`),
  CONSTRAINT `tbl_effectuer_ibfk_2` FOREIGN KEY (`id_etu_student`) REFERENCES `tbl_student` (`id_etu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_effectuer : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_personne
CREATE TABLE IF NOT EXISTS `tbl_personne` (
  `id_p` int(11) NOT NULL AUTO_INCREMENT,
  `password_p` varchar(255) DEFAULT NULL,
  `nom_p` varchar(50) DEFAULT NULL,
  `prenom_p` varchar(50) DEFAULT NULL,
  `mail_p` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_p`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_personne : ~11 rows (environ)
INSERT INTO `tbl_personne` (`id_p`, `password_p`, `nom_p`, `prenom_p`, `mail_p`) VALUES
	(5, NULL, NULL, NULL, NULL),
	(6, 'test', 'test', 'test', 'test@gmail.com'),
	(7, '$2y$10$eCJp5JtPkgF6g8lz2D40I.AMASlQZ39LP9d91bcDlEmN1eEmCr/ay', 'test', 'test', 'test@gmail.com'),
	(8, '$2y$10$3P5bVipREopJvzv71HERo.LvHqmxJVVeDkGHcvgEXWnutuUMeTjOq', 'léo', 'germain', 'gleo@gmail.com'),
	(9, '$2y$10$PDjLeyEwEgCxfLqIsigqBO8.0uvPyzzMUPdpx1QlG0oxEoGxxaI1e', 'léo', 'germain', 'gleo@gmail.com'),
	(10, '$2y$10$nW0KI9hL3g1t2Rm5pe0W7ezIQVPOHp3kt3xyeWv0msE5CXXSqPmAa', 'moi', 'vincent', 'moi@gmail.com'),
	(11, '$2y$10$P43kcFpaZ42sseh2w2CVouYWP/MdBqMta7L3ehRkcGwRcAmmdUGq.', 'gamblin', 'vincent', 'gamblinvincent@ik.me'),
	(12, '$2y$10$Tdvm5j94/tAIm9ROkKH/8.E3.vNNmXCViDOhtK6oZioHYXEtmBkie', 'Ricaud', 'Patrick', 'Ricaudpatrick@gmail.com'),
	(13, '$2y$10$iDYAB4ibFpEcycPZXn/pz.62nCmDvNIcBtxWmidqLuHEgNT5YG7fe', 'Laveille', 'Mathis', 'mathis@jesuischiant.com'),
	(14, '$2y$10$m9rHqbsXjPcsTrPvqFZyJOwfMfcRIGYxgcBUY16wJwt9HyvoHpzSy', 'gagagaag', 'tyuiop', 'test2@gmail.com'),
	(15, '$2y$10$qqIBZsHFfQJ2iOczgTeEsuO6CRDIaBpdHJnWXuUpaixDTDmvSxgtG', '', '', '');

-- Listage de la structure de table gestion_stages. tbl_school
CREATE TABLE IF NOT EXISTS `tbl_school` (
  `id_ec` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ec` varchar(50) DEFAULT NULL,
  `cp_ec` varchar(5) DEFAULT NULL,
  `ville_ec` varchar(50) DEFAULT NULL,
  `rue_ec` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_ec`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_school : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_sederouler
CREATE TABLE IF NOT EXISTS `tbl_sederouler` (
  `id_e_company` int(11) NOT NULL,
  `id_s_internship` int(11) NOT NULL,
  PRIMARY KEY (`id_e_company`,`id_s_internship`),
  KEY `id_s_internship` (`id_s_internship`),
  CONSTRAINT `tbl_sederouler_ibfk_1` FOREIGN KEY (`id_e_company`) REFERENCES `tbl_company` (`id_e`),
  CONSTRAINT `tbl_sederouler_ibfk_2` FOREIGN KEY (`id_s_internship`) REFERENCES `tbl_stage` (`id_s`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_sederouler : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_stage
CREATE TABLE IF NOT EXISTS `tbl_stage` (
  `id_s` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_s`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_stage : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_student
CREATE TABLE IF NOT EXISTS `tbl_student` (
  `id_etu` int(11) NOT NULL AUTO_INCREMENT,
  `id_ec` int(11) NOT NULL,
  `id_c` int(11) NOT NULL,
  `id_p_person` int(11) NOT NULL,
  PRIMARY KEY (`id_etu`),
  UNIQUE KEY `id_p_person` (`id_p_person`),
  KEY `id_ec` (`id_ec`),
  KEY `id_c` (`id_c`),
  CONSTRAINT `tbl_student_ibfk_1` FOREIGN KEY (`id_ec`) REFERENCES `tbl_school` (`id_ec`),
  CONSTRAINT `tbl_student_ibfk_2` FOREIGN KEY (`id_c`) REFERENCES `tbl_degree` (`id_c`),
  CONSTRAINT `tbl_student_ibfk_3` FOREIGN KEY (`id_p_person`) REFERENCES `tbl_personne` (`id_p`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_student : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_supervisor
CREATE TABLE IF NOT EXISTS `tbl_supervisor` (
  `id_s_internship` int(11) NOT NULL,
  `id_t_tutor` int(11) NOT NULL,
  PRIMARY KEY (`id_s_internship`,`id_t_tutor`),
  KEY `id_t_tutor` (`id_t_tutor`),
  CONSTRAINT `tbl_supervisor_ibfk_1` FOREIGN KEY (`id_s_internship`) REFERENCES `tbl_stage` (`id_s`),
  CONSTRAINT `tbl_supervisor_ibfk_2` FOREIGN KEY (`id_t_tutor`) REFERENCES `tbl_tutor` (`id_t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_supervisor : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_tutor
CREATE TABLE IF NOT EXISTS `tbl_tutor` (
  `id_t` int(11) NOT NULL AUTO_INCREMENT,
  `id_p_person` int(11) NOT NULL,
  PRIMARY KEY (`id_t`),
  UNIQUE KEY `id_p_person` (`id_p_person`),
  CONSTRAINT `tbl_tutor_ibfk_1` FOREIGN KEY (`id_p_person`) REFERENCES `tbl_personne` (`id_p`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_tutor : ~0 rows (environ)

-- Listage de la structure de table gestion_stages. tbl_work
CREATE TABLE IF NOT EXISTS `tbl_work` (
  `id_e_company` int(11) NOT NULL,
  `id_t_tutor` int(11) NOT NULL,
  PRIMARY KEY (`id_e_company`,`id_t_tutor`),
  KEY `id_t_tutor` (`id_t_tutor`),
  CONSTRAINT `tbl_work_ibfk_1` FOREIGN KEY (`id_e_company`) REFERENCES `tbl_company` (`id_e`),
  CONSTRAINT `tbl_work_ibfk_2` FOREIGN KEY (`id_t_tutor`) REFERENCES `tbl_tutor` (`id_t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table gestion_stages.tbl_work : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
