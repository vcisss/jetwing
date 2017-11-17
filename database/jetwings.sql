/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.1.33-community : Database - jetwings
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jetwings` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `jetwings`;

/*Table structure for table `aktivitas` */

DROP TABLE IF EXISTS `aktivitas`;

CREATE TABLE `aktivitas` (
  `KdAktivitas` int(11) NOT NULL AUTO_INCREMENT,
  `NamaAktivitas` varchar(100) DEFAULT NULL,
  `Jenis` int(1) DEFAULT NULL COMMENT '1: CTG, 2: GTC',
  `IDR` decimal(15,2) DEFAULT '0.00',
  `USD` decimal(15,2) DEFAULT '0.00',
  `RMB` decimal(15,2) DEFAULT '0.00',
  `Aktif` char(1) DEFAULT NULL COMMENT 'Y=Ya, T=Tidak',
  `AddUser` varchar(20) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `EditUser` varchar(20) DEFAULT NULL,
  `EditDate` date DEFAULT NULL,
  PRIMARY KEY (`KdAktivitas`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `aktivitas` */

insert  into `aktivitas`(`KdAktivitas`,`NamaAktivitas`,`Jenis`,`IDR`,`USD`,`RMB`,`Aktif`,`AddUser`,`AddDate`,`EditUser`,`EditDate`) values (1,'aktivitas 1',1,'0.00','0.00','0.00','Y',NULL,NULL,'tonny1205','2017-08-23'),(2,'teasta 3',1,'30000.00','100.00','0.00','Y',NULL,NULL,NULL,NULL),(3,'taest a5',1,'0.00','50.00','0.00','Y',NULL,NULL,NULL,NULL),(4,'tset  6',1,'200.00','0.00','100.00','T',NULL,NULL,NULL,NULL),(5,'asdfasdf',1,'0.00','0.00','0.00','Y',NULL,NULL,NULL,NULL),(6,'asdfasdf',1,'0.00','0.00','0.00','Y',NULL,NULL,NULL,NULL),(7,'afasdf',1,'0.00','0.00','0.00','Y',NULL,NULL,NULL,NULL),(8,'asfasdf',1,'1000.00','20.00','30.00','Y',NULL,NULL,NULL,NULL),(9,'asdfasda',1,'0.00','0.00','0.00','Y',NULL,NULL,NULL,NULL),(10,'asfasdfasdd',1,'0.00','0.00','0.00','Y',NULL,NULL,NULL,NULL),(11,'asdfasdasdf',1,'0.00','0.00','0.00','Y',NULL,NULL,NULL,NULL);

/*Table structure for table `aktivitasgroup` */

DROP TABLE IF EXISTS `aktivitasgroup`;

CREATE TABLE `aktivitasgroup` (
  `KdGroup` int(11) NOT NULL,
  `KdAktivitas` int(11) NOT NULL,
  `Tanggal` date DEFAULT NULL,
  `Pax` int(11) DEFAULT '0',
  `IDR` decimal(15,4) DEFAULT '0.0000',
  `USD` decimal(15,4) DEFAULT '0.0000',
  `RMB` decimal(15,4) DEFAULT '0.0000',
  `AddUser` varchar(20) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `EditUser` varchar(20) DEFAULT NULL,
  `EditDate` date DEFAULT NULL,
  PRIMARY KEY (`KdGroup`,`KdAktivitas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `aktivitasgroup` */

/*Table structure for table `aktivitasoptionaltour` */

DROP TABLE IF EXISTS `aktivitasoptionaltour`;

CREATE TABLE `aktivitasoptionaltour` (
  `KdGroup` int(11) NOT NULL,
  `KdTour` int(11) NOT NULL,
  `Tanggal` date DEFAULT NULL,
  `Pax` int(11) DEFAULT '0',
  `HargaJualUSD` decimal(15,2) DEFAULT '0.00',
  `HPP` decimal(15,2) DEFAULT '0.00',
  `AddUser` varchar(20) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `EditUser` varchar(20) DEFAULT NULL,
  `EditDate` date DEFAULT NULL,
  PRIMARY KEY (`KdGroup`,`KdTour`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `aktivitasoptionaltour` */

/*Table structure for table `aplikasi` */

DROP TABLE IF EXISTS `aplikasi`;

CREATE TABLE `aplikasi` (
  `Tahun` varchar(4) DEFAULT NULL,
  `KdCabang` varchar(2) DEFAULT '',
  `TglTrans` date NOT NULL DEFAULT '0000-00-00',
  `NamaAlias` varchar(50) DEFAULT NULL,
  `NamaPT` varchar(50) NOT NULL,
  `Alamat1PT` varchar(50) NOT NULL,
  `Alamat2PT` varchar(50) NOT NULL,
  `TelpPT` char(30) DEFAULT NULL,
  `Logo` varchar(15) DEFAULT NULL,
  `LamaPass` char(1) DEFAULT NULL,
  `NPWP` varchar(20) NOT NULL,
  `FolderSqlDump` varchar(1000) DEFAULT NULL,
  `PathAplikasi` varchar(1000) DEFAULT NULL,
  `AddDate` date NOT NULL DEFAULT '0000-00-00',
  `EditDate` date NOT NULL DEFAULT '0000-00-00',
  `LastUpdate` datetime DEFAULT NULL,
  `TahunBulanAwal` varchar(6) DEFAULT NULL,
  `DefaultKdCostCenter` char(3) DEFAULT NULL,
  `DefaultKdDepartemen` char(2) DEFAULT NULL,
  `DefaultKdProject` char(5) DEFAULT NULL,
  `FlagTutupHari` char(1) DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `aplikasi` */

insert  into `aplikasi`(`Tahun`,`KdCabang`,`TglTrans`,`NamaAlias`,`NamaPT`,`Alamat1PT`,`Alamat2PT`,`TelpPT`,`Logo`,`LamaPass`,`NPWP`,`FolderSqlDump`,`PathAplikasi`,`AddDate`,`EditDate`,`LastUpdate`,`TahunBulanAwal`,`DefaultKdCostCenter`,`DefaultKdDepartemen`,`DefaultKdProject`,`FlagTutupHari`) values ('2017','00','2017-08-09','SECRET GARDEN VILLAGE','PT. Natura Pesona Mandiri','Jl. Raya Denpasar Bedugul KM.36 Tabanan','Bali 82191 - Indonesia','+62 361 4715379','logo.jpg','2','02.231.300.1-908.000','C:/xampp/mysql/bin/mysqldumpmysqldump','D:/BackupNPM/','2011-12-07','2008-10-28','2012-12-07 13:00:01','201507',NULL,NULL,NULL,'T');

/*Table structure for table `ci_query` */

DROP TABLE IF EXISTS `ci_query`;

CREATE TABLE `ci_query` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query_string` text,
  `module` varchar(100) DEFAULT NULL,
  `AddUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86339 DEFAULT CHARSET=latin1;

/*Data for the table `ci_query` */

insert  into `ci_query`(`id`,`query_string`,`module`,`AddUser`) values (86317,'search_keyword=tset 6','aktivitas','tonny1205'),(86318,'search_keyword=ket','groupoptionaltour','tonny1205'),(86319,'search_keyword=karung','optionaltour','tonny1205'),(86320,'search_keyword=guide','tourguide','tonny1205'),(86338,'search_keyword=&search_tanggal=0000-00-00','group','tonny1205');

/*Table structure for table `employee` */

DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_nik` varchar(225) DEFAULT NULL,
  `employee_code_hrd` varchar(225) DEFAULT NULL,
  `employee_code_hrd_cabang` varchar(225) DEFAULT NULL,
  `no_ktp` varchar(100) DEFAULT NULL,
  `no_kpj` varchar(100) DEFAULT NULL,
  `employee_name` varchar(225) DEFAULT NULL,
  `employee_nick_name` varchar(100) DEFAULT NULL,
  `address_1` varchar(225) DEFAULT NULL,
  `address_2` varchar(225) DEFAULT NULL,
  `city` varchar(225) DEFAULT NULL,
  `address_actual_1` varchar(225) DEFAULT NULL,
  `address_actual_2` varchar(225) DEFAULT NULL,
  `city_actual` varchar(225) DEFAULT NULL,
  `handphone_1` varchar(225) DEFAULT NULL,
  `handphone_2` varchar(225) DEFAULT NULL,
  `handphone_3` varchar(225) DEFAULT NULL,
  `handphone_def` varchar(10) DEFAULT NULL,
  `phone` varchar(225) DEFAULT NULL,
  `gender` varchar(225) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `place_birth` varchar(225) DEFAULT NULL,
  `religion` varchar(225) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `rekening` varchar(225) DEFAULT NULL,
  `username` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `rekening_mandiri` varchar(225) DEFAULT NULL,
  `jamsostek` varchar(225) DEFAULT NULL,
  `npwp` varchar(225) DEFAULT NULL,
  `remarks` varchar(225) DEFAULT NULL,
  `employee_status_id` int(11) DEFAULT NULL,
  `tanggal_pengangkatan` date DEFAULT NULL,
  `work_hour_id` int(11) NOT NULL,
  `work_day_id` int(11) NOT NULL,
  `author` varchar(225) DEFAULT NULL,
  `edited` varchar(225) DEFAULT NULL,
  `employee_id_reff` varchar(225) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `universitas` varchar(100) DEFAULT NULL,
  `no_kartu_keluarga` varchar(255) DEFAULT NULL,
  `nama_ibu_kandung` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=383 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `employee` */

/*Table structure for table `group_tour` */

DROP TABLE IF EXISTS `group_tour`;

CREATE TABLE `group_tour` (
  `KdGroup` int(11) NOT NULL AUTO_INCREMENT,
  `NamaGroup` varchar(150) DEFAULT NULL,
  `Tanggal` date DEFAULT NULL,
  `TanggalSelesai` date DEFAULT NULL,
  `Pax` int(11) DEFAULT NULL,
  `KdTourGuide` int(11) DEFAULT NULL,
  `PersentaseGuide` decimal(5,2) DEFAULT NULL,
  `Status` int(11) DEFAULT '1' COMMENT '1=Aktif, 2=Close',
  `AddUser` varchar(20) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `EditUser` varchar(20) DEFAULT NULL,
  `EditDate` date DEFAULT NULL,
  PRIMARY KEY (`KdGroup`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `group_tour` */

insert  into `group_tour`(`KdGroup`,`NamaGroup`,`Tanggal`,`TanggalSelesai`,`Pax`,`KdTourGuide`,`PersentaseGuide`,`Status`,`AddUser`,`AddDate`,`EditUser`,`EditDate`) values (1,'','0000-00-00','0000-00-00',0,2,'0.00',1,'tonny1205','2017-08-23',NULL,NULL),(2,'','0000-00-00','0000-00-00',0,2,'0.00',1,'tonny1205','2017-08-23',NULL,NULL),(3,'','0000-00-00','0000-00-00',0,2,'0.00',1,'tonny1205','2017-08-23',NULL,NULL),(4,'aasdfadsf','2017-08-28','2017-09-07',1,2,'40.00',2,'tonny1205','2017-08-23','tonny1205','2017-08-23');

/*Table structure for table `groupoptionaltour` */

DROP TABLE IF EXISTS `groupoptionaltour`;

CREATE TABLE `groupoptionaltour` (
  `KdGroupOptional` int(11) NOT NULL AUTO_INCREMENT,
  `Keterangan` varchar(100) DEFAULT NULL,
  `AddUser` varchar(20) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `EditUser` varchar(20) DEFAULT NULL,
  `EditDate` date DEFAULT NULL,
  PRIMARY KEY (`KdGroupOptional`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `groupoptionaltour` */

insert  into `groupoptionaltour`(`KdGroupOptional`,`Keterangan`,`AddUser`,`AddDate`,`EditUser`,`EditDate`) values (1,'afasdf','tonny1205','2017-08-23','tonny1205','2017-08-23'),(2,'keterangan 23','tonny1205','2017-08-23','tonny1205','2017-08-23');

/*Table structure for table `log_user` */

DROP TABLE IF EXISTS `log_user`;

CREATE TABLE `log_user` (
  `IDUser` char(4) DEFAULT NULL,
  `DateLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `log_user` */

insert  into `log_user`(`IDUser`,`DateLogin`) values ('189','2017-08-22 15:34:59'),('189','2017-08-22 15:36:03'),('189','2017-08-22 16:29:00'),('189','2017-08-22 17:39:39'),('189','2017-08-24 10:25:11');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `nama` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ulid` varchar(25) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `root` varchar(25) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `urutan` tinyint(1) DEFAULT NULL,
  `FlagAktif` tinyint(4) DEFAULT NULL,
  `UserLevelID` int(11) DEFAULT NULL,
  `icon` varchar(100) COLLATE latin1_general_ci DEFAULT '',
  `sts_apps` int(11) DEFAULT '0' COMMENT '0=NPM, 1=HRGA, 2=PRODUKSI'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `menu` */

insert  into `menu`(`nama`,`ulid`,`root`,`url`,`urutan`,`FlagAktif`,`UserLevelID`,`icon`,`sts_apps`) values ('Home','','1','index.php/start/',1,1,-1,'entypo-gauge',0),('Master','ddsubmenu1','1','',2,1,-1,'entypo-briefcase',0),('Tabel User','ddsubmenu6','ddsubmenu6','asdfas',9,1,-1,'',0),('Logout','','1','index.php/logout/',11,1,-1,'entypo-logout',0),('User','ddsubmenu6','Tabel User','index.php/master/user/',2,1,-1,'',0),('Setup','ddsubmenu6','1','',8,1,-1,'entypo-tools',0),('Transaksi','ddsubmenu4','1','',4,1,-1,'entypo-suitcase',0),('Tour','ddsubmenu4','ddsubmenu4','index.php/transaksi/group/',1,1,-1,'',0),('Aktivitas','ddsubmenu1','ddsubmenu1','index.php/master/aktivitas/',1,1,-1,'',0),('Optional Tour','ddsubmenu1','ddsubmenu1','index.php/master/optionaltour/',2,1,-1,'',0),('Main Tour','ddsubmenu4','ddsubmenu4','index.php/transaksi/aktivitasgroup/',2,1,-1,'',0),('Group Optional Tour','ddsubmenu1','ddsubmenu1','index.php/master/groupoptionaltour/',3,1,-1,'',0),('Tour Guide','ddsubmenu1','ddsubmenu1','index.php/master/tourguide/',4,1,-1,NULL,0),('Reporting','Reporting','1','',5,1,-1,'entypo-docs',0),('Aplikasi','ddsubmenu6','ddsubmenu6','index.php/setup/aplikasi/',1,1,-1,NULL,0),('Tour Guide Claim','reporting','reporting','test',1,1,-1,'',0);

/*Table structure for table `optionaltour` */

DROP TABLE IF EXISTS `optionaltour`;

CREATE TABLE `optionaltour` (
  `KdTour` int(11) NOT NULL AUTO_INCREMENT,
  `NamaTour` varchar(100) DEFAULT NULL,
  `KdGroupOptional` int(11) DEFAULT NULL,
  `HargaJualUSD` decimal(15,2) DEFAULT '0.00',
  `HPP` decimal(15,2) DEFAULT '0.00',
  `AddUser` varchar(20) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `EditUser` varchar(20) DEFAULT NULL,
  `EditDate` date DEFAULT NULL,
  PRIMARY KEY (`KdTour`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `optionaltour` */

insert  into `optionaltour`(`KdTour`,`NamaTour`,`KdGroupOptional`,`HargaJualUSD`,`HPP`,`AddUser`,`AddDate`,`EditUser`,`EditDate`) values (1,'asfas',1,'11.00','5.00','tonny1205','2017-08-23','tonny1205','2017-08-23'),(2,'balap karung',1,'10.00','2.00','tonny1205','2017-08-23',NULL,NULL);

/*Table structure for table `tourguide` */

DROP TABLE IF EXISTS `tourguide`;

CREATE TABLE `tourguide` (
  `KdTourGuide` int(11) NOT NULL AUTO_INCREMENT,
  `NamaTourGuide` varchar(100) DEFAULT NULL,
  `UserName` varchar(20) DEFAULT NULL,
  `AddUser` varchar(20) DEFAULT NULL,
  `AddDate` date DEFAULT NULL,
  `EditUser` varchar(20) DEFAULT NULL,
  `EditDate` date DEFAULT NULL,
  PRIMARY KEY (`KdTourGuide`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tourguide` */

insert  into `tourguide`(`KdTourGuide`,`NamaTourGuide`,`UserName`,`AddUser`,`AddDate`,`EditUser`,`EditDate`) values (1,'xiang xiex',NULL,'tonny1205','2017-08-23','tonny1205','2017-08-23'),(2,'guide 2',NULL,'tonny1205','2017-08-23',NULL,NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserLevel` int(11) NOT NULL DEFAULT '0',
  `employee_nik` varchar(225) DEFAULT NULL COMMENT 'nik employee',
  `UserName` varchar(20) NOT NULL,
  `Password` char(50) NOT NULL,
  `Active` char(1) DEFAULT '0',
  `AddDate` date NOT NULL DEFAULT '0000-00-00',
  `EditDate` date NOT NULL DEFAULT '0000-00-00',
  `MainPage` varchar(20) DEFAULT NULL,
  `Bulan` char(2) DEFAULT NULL,
  `Tahun` char(4) DEFAULT NULL,
  `OtoDisc` varchar(1) DEFAULT 'T',
  `MaxDisc` decimal(5,2) DEFAULT '0.00',
  `Barcode` varchar(15) DEFAULT '',
  `TelegramID` varchar(20) DEFAULT '',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `unik_data` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`Id`,`UserLevel`,`employee_nik`,`UserName`,`Password`,`Active`,`AddDate`,`EditDate`,`MainPage`,`Bulan`,`Tahun`,`OtoDisc`,`MaxDisc`,`Barcode`,`TelegramID`) values (1,10,'20163033','feby0502','19e3f6b634ed7565898fa0edff0c96c6','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(2,10,'20163038','ferry1311','92abdeb15c5db4b1b297e91f88a6713a','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(3,10,'20163030','i2007','51951b88bf080711f9aed3846cafab98','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(4,10,'20163035','giri2512','68c9332deef7cc13450a10b8118468ad','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(5,10,'20163036','ni2302','29ef0cf28f33a1e5f9b1fb10420fa91c','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(6,10,'20163057','viorin0212','c02d734de22c3289551ffa3e5cacf969','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(7,10,'20163042','widia1210','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(8,10,'20163040','dewi3003','a13ad8b9bb119fa00cc57431bd5b6cd9','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(9,10,'20163055','tutik0307','bf9c6f97e0b5b38cd2a85ece12dbd293','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(10,10,'20163054','puri2302','1b05782bb6bdce8139dab0a9d89dc028','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(11,10,'20163039','i2708','d38e1c48065c570a7cee5d6f7a70fcda','Y','2016-05-22','2016-05-24','Home','08','2016','T','0.00','',''),(12,10,'20163037','desak1211','1a068c9764794eb47890067cd43ecd46','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(13,10,'20163041','dedek0912','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-22','2016-05-23','Home','08','2016','T','0.00','',''),(14,10,'20163034','omink1602','0f9efcfb605e5216658c71ee0f493e2e','Y','2016-05-22','2016-07-10','Home','08','2016','T','0.00','',''),(15,13,'20163056','putu0306','4d7b0aaeca3f0dcffd44f2a91257ba77','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(16,10,'20163032','ayu2008','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-22','2016-05-22','Home','08','2016','T','0.00','',''),(17,0,'20162890','y2802','b12b2596c8ba5f1dfcb163ed74c6df04','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(18,6,'20162890','darren2802','ae75c65c6c9a9b779a62826de1c59fc6','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(19,0,'20162899','aandp1011','e5c09b2dc7fc9b383bbf33f60d7ed130','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(20,10,'20163109','ahmad2803','bdb0dc792179bfb096c1d382f4535b39','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(21,6,'20163107','bella0301','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(22,6,'20162978','desilya1712','6f56a23529f14e1014d11ccecfa9b025','Y','2016-05-23','2016-06-15','Home','08','2016','T','0.00','',''),(23,1,'20163028','gede0909','edcaed3b31f0a0a04b3153949495d0f8','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(24,10,'20163112','gunardi2708','85721eed596fee576f2d72eb1372acb8','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(25,9,'20163047','gusti0703','24afd5d9a09ba185ea327cd61561505e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(26,6,'20163059','hendra2906','54ad7e370961300f08ae226f1bfd40be','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(27,10,'20162920','herlambang1805','263aad7adb87db6899b1628d1dc5307e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(28,3,'20163105','i1608','c7ae869b1704b6168231787f7bc7ee73','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(29,0,'20163091','i0304','1e67f1e1c8c85be0bb04b9c496d43fe3','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(30,0,'20163024','i0808','bb18c9db6f6ec8697d3143aea3dbd2cc','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(31,0,'20163023','i1609','d652f4177ff066b4bc67c8b4b01370de','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(32,9,'20163044','i0609','9d80f7548494d473533b6639620f0a8b','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(33,0,'20163052','i1112','3f06e7d6e2c4c694f0f6e69ccb7c1ba7','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(34,5,'20163050','miko0806','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(35,0,'20163104','i0408','3829a18c44aa4f6bc27f9480a61ab1d2','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(36,0,'20163092','i1202','512dbf97288ba0a3a51648e6fe9b551f','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(37,8,'20163083','i0205','0ce0c94eac91ef601b28efe6c86551ac','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(38,0,'20163095','i0802','e2401d999bac723b92baf1508762e601','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(39,9,'20162966','i0411','f67a7cf744e18652214a0a364b64b75e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(40,0,'20163090','i1010','9f2003ebecb4ba827dbdc83e6a3d50e0','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(41,0,'20162917','i1009','2a123aa434a7cc96c00621416a41b347','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(42,0,'20162252','ryan0710','478f1cb7d5f33f67f61d5cf24a742db3','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(43,5,'20163027','adi1610','9fda65b1a49076e25fcece6c21294341','Y','2016-05-23','2016-07-01','Home','11','2016','T','0.00','',''),(44,0,'20162874','boga0505','78a1df4ba2352f8d6f4f3e6b812691d7','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(45,1,'20152200','artedy1306','b2fb59d4b7008a9e237dd35803f8609a','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(46,0,'20163118','i2004','9badc1c1a581d986f266118cb4dd8440','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(47,0,'20163085','i0804','e0fb54c783f16f3ee4ce2e8cea38fd0d','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(48,6,'20162865','dian1101','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(49,0,'20163031','i0905','b94fdb199507396f04a938812fa7d65b','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(50,-1,'17121350','dicky0707','25d9fed238404891fb5bcac2c6c7665c','Y','2016-05-23','2016-05-23','Home','08','2016','Y','20.00','909878309482093',''),(51,8,'20163088','i1901','ce472655f81e18e2ba59449ef6a5f577','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(52,0,'20163096','i2809','9654c600eafe8c7a23a07f704aeaad21','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(53,3,'20162965','eka0804','448116cbbae9ba3eb4c56b1cbf5926ba','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(54,0,'20163110','i0504','ea6513df956a22ba6e970c2c40aa8afa','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(55,0,'20163009','ema0505','581de57b245a70c6cbf98a825ccb8cfd','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(56,10,'20163087','i0510','95b118d83ef1b9d52dbe3b98cb5997ea','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(57,0,'20163106','frans1706','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(58,0,'20163060','i0901','cab6b241fa75a50ded3fb83390722c52','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(59,0,'20163048','gede3108','3f28c5bbf75e9c853179ba31d972ad0d','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(60,0,'20163077','gusti0205','4081d9186e0b62df555f83cd9a1b166e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(61,0,'20163089','i2307','9826e047158d054fc85d051bf53cfa66','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(62,-1,'20163115','i1205','52102f8dfd74ad3191d0678b64fde202','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(63,0,'20163075','i0104','9b3fbf5c7711af6059c5924e17d9201e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(64,0,'20163058','i1612','5c6b4ff72a3c81aa7d78bb0db7409e28','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(65,0,'20163079','i2212','ace833a621a6d8765b76e458c823c3ed','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(66,0,'20163082','indra2103','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(67,0,'20163051','iwan2204','3f489d53121f4f3a9227563726a7e0fd','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(68,-1,'20163063','i2511','3b637401a00502bdcd4cb14e9d2c1253','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(69,16,'20163114','yarde0705','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-07-05','Home','08','2016','T','0.00','','444460570'),(70,6,'20163124','jefry2610','75770b25c85a73cc6a56a342566ae6e3','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(71,0,'20163074','i1211','d72d69d8b4710555557f21e5017bc4b3','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(72,0,'20163116','i2202','392140ede371684e3a4d0d8a1c3216ca','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(73,0,'20163068','kadek2107','c85129d38a520ca741a9fa35953aaee3','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(74,21,'20163117','gun0512','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(75,0,'20163026','sari1608','18422e795bcbccf2e439bba43b224d06','Y','2016-05-23','2016-06-08','Home','08','2016','T','0.00','',''),(76,0,'20163076','i0203','cc6b8953e6173fce0bbf90696bcb0cc3','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(77,0,'20163067','made0104','c9019a1d28dacb996ced69740742e3a8','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(78,10,'20163061','kd2204','eb62f3463bdd3ceae633f1ab73189b72','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(79,10,'20163069','kleopaul2904','d99df895dabcb7e092c66abe3dbbd5b7','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(80,10,'20162967','i1605','d0898ff6a4b8575367d3ce0a900adf22','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(81,0,'20163097','krisnayanti0302','6ac360751d9389630a377a2c0289097c','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(82,10,'20163073','i1606','71b07a7f782dd5ab8165353aab5b23bd','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(83,-1,'20163053','luh0809','eac16132f03295176b9a09ae7d350a7b','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(84,10,'20162902','yudi2109','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(85,0,'20163123','i0805','e7f047c2b2035179221a4ecc337a2da5','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(86,0,'20163078','putu1202','4a308f1096b9c3594426338d1abe8496','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(87,10,'20163043','saman1504','2381957b1887e3b17c1faca148f83a1d','Y','2016-05-23','2016-06-10','Home','08','2016','T','0.00','',''),(88,5,'20163120','huda2601','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(89,0,'20162979','muhammad1803','d9fe99dc3dfd2b9bc82cd74f4089146d','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(90,8,'20163084','ni0405','4f498eb71f6414d971be2ac4386bfc12','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(91,0,'20163102','ni2903','093343892b0525aa288dea909f55b681','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(92,0,'20163080','ni3008','2c39e735bbb9b71054823190c550caad','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(93,0,'20163065','ni0305','2c9332f3cdf09ca62363df2896d3faab','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(94,10,'20163098','ni1306','d6285024f5114092d3037c52434f2f98','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(95,0,'20163119','ni1402','98a1b96931e570b0f8b18ea01bb6fd60','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(96,0,'20163064','ni3112','5ef12b4900630a8f12a9ec88e126d3bd','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(97,0,'20163081','ni1302','0fe2d1e40c858188485ff0dd4de840a2','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(98,5,'20163122','darni1512','96864eff10ec95713fbe7fbbba97cebf','Y','2016-05-23','2016-07-04','Home','08','2016','T','0.00','',''),(99,-1,'20163029','yulia2107','01e7c71de969916ca447e392ce6de8d8','Y','2016-05-23','2017-07-12','Home','08','2016','T','0.00','',''),(100,0,'20163101','ni2408','b9fb7161447d2d6f6a78511b4c09a678','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(101,-1,'20163046','ni2810','05b99e488ef72ee2a1977766c3a55802','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(102,2,'20163121','siska1705','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-30','Home','08','2016','T','0.00','',''),(103,6,'20162868','putu0605','35b52042a9c86c84446984d145f53b8b','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(104,-1,'20163045','ni2606','e676343a578e858735144b4d0138fb9f','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(105,-1,'20152205','yunita1006','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(106,0,'20163099','ni1012','c59c8242817e2a3818dad8410ef1c3d5','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(107,0,'20163113','ni2509','a360abd503aff0155490dc3f29c5dcd6','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(108,0,'20163066','ni2811','1d91cc3665e7410af3b3843966dfd2c2','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(109,10,'20163070','ni2202','fedb8fad81336d60387929de84d20744','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(110,10,'20163072','ni1805','216408b289b2d505ac8c5bfcb2374362','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(111,0,'20163071','ni0105','f843a8a7ac12ee8ad5ace9a460b07fee','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(112,-1,'20162891','ni0412','c6d94248342dfcdb078c48ac1338d3b2','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(113,0,'20152204','johanis0201','f1723ee4f9405b470c9e91db8f5f5de1','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(114,2,'20163103','cahyo2608','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(115,10,'20163062','ni0203','c034ff0a3bfebebe4b08faa68d70400e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(116,2,'20152202','riza2606','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(117,25,'20163025','arya2206','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(118,0,'20152203','sugiarsa0702','bda0971f667ec28750f5c02c17aea3d8','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(119,0,'20162968','obay3001','2696c58357b9298ee93163632aab6824','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(120,0,'20162875','asiang2803','1396003547aea91ad9c4140c2260e5d2','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(121,3,'20152743','sari1004','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(122,-1,'20163094','putu2105','4e97048e79e6cfdb6ee26a6b6c5cb894','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(123,0,'20162869','siwantha2901','67b5cc1c6413e2847c82f05e95e090fd','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(124,0,'20163049','ni2005','6fb4f7bd0d93af47076da9d10d2448c0','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(125,0,'20162913','rifki0112','8577c204afc4b73f391e7dda768ce391','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(126,20,'20163022','rbt1010','5290bd4ffc00cc4807aad5a4aec90391','Y','2016-05-23','2016-05-23','ORDER TOUCH','08','2016','T','0.00','',''),(127,10,'20163100','ni2212','fe8b197cdce1b165bb925d693b8ac10b','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(128,0,'20163093','setya0709','a9ec5a6b90367443d84e45e123d7027f','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(129,0,'20163111','sriman3110','18b63393ea9db6955653e53f3f42f35c','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(130,0,'20162873','luh2111','b9e65fb48fff2c290356f89b828de845','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(131,0,'20163125','theng1808','1fdc28b18b515652aa278c838240bcbc','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(132,0,'20163086','tomy2603','2eba95b48f99913eb0640ca8453782c9','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(133,0,'20163108','tri2605','8728894ffb6e350cc61f24eea48372a9','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(134,0,'20152253','muflikhatun0407','a9d3c97ba815170bd7dde3873ae88686','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(135,0,'20162877','utami1901','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-31','Home','08','2016','T','0.00','',''),(136,5,'20162871','zulfiyah2709','d4d154d3eb27b65b55e1dbdc0b1225ec','Y','2017-04-07','2017-04-07','HOME','04','2017','T','0.00','',''),(137,0,'20162864','setya2011','5ad5708227eda275f65ca567f1952243','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(138,9,'20162921','yudhi2607','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(139,-1,'20163126','william1001','11b3388e22061d6b451059d9fed21608','Y','2016-05-23','2017-07-26','Home','08','2016','T','0.00','','383919257'),(140,0,'20163010','wijaya1802','6dfd49ed11e344627abcea6fbdb5257c','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(141,3,'20162870','stefanus2501','a156775bba716ca77e0ce5618799a63c','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(142,-1,NULL,'DISCNATAL','f7a6234384e17fc37cfc8216ef4cb5c9','Y','2016-05-23','2016-05-23','Home','08','2016','Y','20.00','',''),(143,0,NULL,'febri0202','206d43416cb3ff3f2f1dda27c4d2d857','Y','2016-05-23','2016-05-24','Home','08','2016','T','0.00','',''),(144,0,NULL,'hendri1003','2f863b89271fd0fc364bc74442512811','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(145,0,NULL,'maizarnia0505','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(146,-1,NULL,'frangky2311','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(147,5,NULL,'prwnho','46f94c8de14fb36680850768ff1b7f2a','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(148,0,NULL,'fajar1611','46f94c8de14fb36680850768ff1b7f2a','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(149,-1,NULL,'tri0410','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(150,-1,NULL,'trisno1402','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','Y','20.00','876349530923098','352276572'),(151,-1,NULL,'wieok3110','82819567b9ad4e8c5212f49f67743616','Y','2016-05-23','2016-05-23','Home','08','2016','Y','50.00','','2057656'),(192,12,'20163150','luh2903','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-22','2016-10-28','Home','08','2016','T','0.00','',''),(153,0,NULL,'epra0404','e10adc3949ba59abbe56e057f20f883e','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(154,0,'20162876','kus0802','cbd26060f2563a35e752fb7215938eaf','Y','2016-05-23','2016-07-03','Home','08','2016','T','0.00','',''),(155,0,NULL,'anwar2006','152d9815abfe3257d64f08f73dcdad3f','Y','0000-00-00','2016-07-21','Home','08','2016','T','0.00','',''),(156,11,NULL,'haryo2610','0','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(157,13,NULL,'ita1709','2c8efeec0699159bc1502385b5ed0cd9','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(158,21,NULL,'samsul1012','135d4d40b768220ad92a2d90325202c9','Y','0000-00-00','2016-07-29','Home','08','2016','T','0.00','',''),(159,0,NULL,'anwar2508','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(160,-1,NULL,'nurul2607','d39d6ba21906d5649f84b36e768d508f','Y','0000-00-00','2016-07-25','Home','08','2016','T','0.00','',''),(161,0,NULL,'windha','3ab367f955da990e07cea6d62c35fcc7','Y','0000-00-00','2016-06-18','Home','08','2016','T','0.00','',''),(162,2,NULL,'ayik0106','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(163,-1,NULL,'henny2905','1ecb315f3ddbeb65317727aec7f1eeba','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(164,0,NULL,'budi2002','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(165,26,NULL,'sukadana3007','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(167,-1,NULL,'iikOH','c4f82ef268ffd54167bcd43261edd8c1','Y','0000-00-00','2016-07-16','Home','08','2016','T','0.00','',''),(168,6,'20163148','prinata2403','01cfcd4f6b8770febfb40cb906715822','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(169,2,'','putra0909','c1b1aa5c4abc8152df82b1d535a25976','Y','2016-05-23','2016-05-30','Home','08','2016','T','0.00','',''),(170,0,'20163151','komang2412','65517850d3ce9dfb13b38d5caa7cc1cd','1','2016-07-01','0000-00-00','Home','08','2016','T','0.00','',''),(171,-1,'15070232','ambar0410','1fd3534ab4fdd4f539da7f236ae6b54f','Y','2016-07-01','0000-00-00','Home','08','2016','Y','20.00','498245627384232',''),(172,5,'20163175','yuni0204','61adc5a7838db3db41ef4cd10ebc221e','Y','2016-07-10','2016-07-10','Home','08','2016','T','0.00','',''),(173,10,'20162966','arista0411','4931461372456214902b43c01f54204f','Y','2016-07-11','2016-07-11','Home','08','2016','T','0.00','',''),(174,10,'20163094','riska2105','ba26d64d75b1715707996c467b096f19','Y','2016-07-12','2016-07-12','Home','08','2016','T','0.00','',''),(175,0,'20163044','mega0609','a5e6dd1610175f2ef4eba8a381b8b94c','Y','2016-07-12','2016-07-12','Home','08','2016','T','0.00','',''),(176,16,'20163178','mila0202','13e8592797e78b06eb987a10e5ca5db1','Y','2016-07-13','2016-07-13','Home','08','2016','T','0.00','',''),(177,-1,'20163183','dian3010','929e51a4a6165521a6991b5a1d6c0dc7','Y','0000-00-00','2016-08-05','Home','08','2016','T','0.00','',''),(178,0,NULL,'joko2002','e10adc3949ba59abbe56e057f20f883e','Y','2016-07-30','2016-07-30','Home','08','2016','T','0.00','',''),(179,-1,NULL,'audit','5334d52151a527283b3a55705da12046','Y','0000-00-00','2017-03-24','Home','08','2016','T','0.00','',''),(180,24,'20163179','yadi2212','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(181,-1,NULL,'justinus1007','7bc0c6b6f11697b5924120ab543a231e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(182,10,'20163195','ayu1117','e10adc3949ba59abbe56e057f20f883e','Y','2016-08-14','2016-08-14','Home','08','2016','T','0.00','',''),(183,5,'20163194','adi0301','e10adc3949ba59abbe56e057f20f883e','Y','2016-08-29','2016-08-29','Home','08','2016','T','0.00','',''),(184,10,'20163199','dede1305','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(186,3,'20163200','indah2905','e10adc3949ba59abbe56e057f20f883e','Y','2016-09-10','2016-09-10','Home','08','2016','T','0.00','',''),(187,0,'20162891','eva0412','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(188,-1,NULL,'mechael0101','e10adc3949ba59abbe56e057f20f883e','Y','2016-09-29','2016-09-29','Home','09','2016','T','0.00','','300127392'),(189,-1,NULL,'tonny1205','af98903c7100e363b5f6b38259dc65f8','Y','2016-10-03','2016-10-03','Home','10','2016','T','0.00','','188790806'),(190,0,NULL,'mirza','912ec803b2ce49e4a541068d495ab570','Y','2016-05-23','2016-05-23','Home','08','2016','T','0.00','',''),(191,-1,'20163219','charles3105','7d86485b66b12858aca67cb44d49903e','Y','0000-00-00','2017-02-02','Home','08','2016','T','0.00','',''),(193,14,'20163236','ratna1908','e10adc3949ba59abbe56e057f20f883e','Y','2016-11-23','2016-11-23','Home','11','2016','T','0.00','',''),(194,10,'20163243','tista2510','e10adc3949ba59abbe56e057f20f883e','Y','2016-11-23','2016-11-23','Home','11','2016','T','0.00','',''),(195,10,'20163242','devita2702','e10adc3949ba59abbe56e057f20f883e','Y','2016-11-23','2016-11-23','Home','11','2016','T','0.00','',''),(196,10,'','rina3010','55592db6428fcc4dc1239113a5108d9f','Y','2016-11-23','2016-11-23','Home','11','2016','T','0.00','',''),(197,10,'','komang0101 ','c553a4d9ac5266e8e52daeab619d6491','Y','2016-11-23','2016-11-23','Home','11','2016','T','0.00','',''),(198,5,'','ni1601','e10adc3949ba59abbe56e057f20f883e','Y','2016-11-23','2016-11-23','Home','11','2016','T','0.00','',''),(199,-1,NULL,'idaayu','93bf8ac6abb9480b63600e4e59252e49','Y','2017-01-05','2017-07-31','Home','11','2016','T','0.00','',''),(202,23,'20163224','bsp1412','e10adc3949ba59abbe56e057f20f883e','Y','2016-07-13','2016-07-13','Home','08','2016','T','0.00','',''),(200,20,NULL,'kdk0605','e10adc3949ba59abbe56e057f20f883e','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(201,20,NULL,'luwus0202','e10adc3949ba59abbe56e057f20f883e','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(203,20,NULL,'bima0131','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(204,20,NULL,'wayan2410','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(205,20,'20173258','putu0702','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(206,20,'20163149','kadek2712','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(207,20,'20163226','kadek1402','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(208,20,'20173260','kadek1412','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(209,20,'20173259','wayan1205','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(210,20,'20163239','wayan2402','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(211,20,'20173257','ni0509','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(212,20,'20163193','ni1109','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(213,20,'20163239','devi0402','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(214,20,'20163083','eka0205','202cb962ac59075b964b07152d234b70','Y','2017-01-05','0000-00-00','ORDER TOUCH','11','2016','T','0.00','',''),(215,0,NULL,'abdulloh0609','0bf782cc84541f5478d1d986a329b0d5','Y','2017-03-01','2017-03-01','HOME','03','2017','T','0.00','',''),(216,0,NULL,'agus0411','a906449d5769fa7361d7ecc6aa3f6d28','Y','2017-03-01','2017-03-01','HOME','03','2017','T','0.00','',''),(217,22,'20163250','indah2405','e10adc3949ba59abbe56e057f20f883e','Y','2016-07-10','2016-07-10','Home','08','2016','T','0.00','',''),(218,10,NULL,'reservasi','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','03','2017','T','0.00','',''),(254,-1,'','billyhs','82819567b9ad4e8c5212f49f67743616','Y','2017-07-26','2017-07-26','HOME','07','2017','T','0.00','','430979785'),(220,24,'20163179','ely2306','e10adc3949ba59abbe56e057f20f883e','Y','0000-00-00','0000-00-00','Home','08','2016','T','0.00','',''),(221,0,'20173287','ni2312','e76285e705934688310c9a25b92a99b5','Y','2017-03-21','2017-03-21','HOME','03','2017','T','0.00','',''),(222,25,'frontoffice','frontoffice','e10adc3949ba59abbe56e057f20f883e','0','0000-00-00','0000-00-00','HOME','03','2017','T','0.00','',''),(223,22,NULL,'myn2017','e10adc3949ba59abbe56e057f20f883e','Y','2016-07-10','2016-07-10','Home','08','2016','T','0.00','',''),(224,10,'20173283','luh1205','e10adc3949ba59abbe56e057f20f883e','Y','2017-03-22','2017-03-22','HOME','03','2017','T','0.00','',''),(225,10,'20173275','ni3006','e10adc3949ba59abbe56e057f20f883e','Y','2017-03-22','2017-03-22','HOME','03','2017','T','0.00','',''),(226,13,'20173269','i1410','8981fbee018bf0d32804649f2fec43ad','Y','2017-03-22','2017-03-22','HOME','03','2017','T','0.00','',''),(227,10,'20163049','luh2005','bac7a987623c1f9240bf63d437c6648c','Y','2017-03-24','2017-03-24','HOME','03','2017','T','0.00','',''),(228,10,'20163069','babaro2904','05eccddc77d90d6905c2d1eba012cfde','Y','2017-03-24','2017-03-24','HOME','03','2017','T','0.00','',''),(229,-1,NULL,'DISCREI','8872f2d4e130bbde6eeb80692b453df3','Y','2016-05-23','2016-05-23','Home','08','2016','Y','15.00','',''),(244,2,'20173340','hilda1012','7f3e19b11dab0eacde815fedd07aa530','Y','2017-06-21','2017-06-21','HOME','06','2017','T','0.00','',''),(231,-1,'','anadewi','af5372c9639c098470c2065d46bb171c','Y','2016-05-23','2016-05-23','Home','08','2016','Y','20.00','','398575589'),(232,20,'20173296','luh1306','202cb962ac59075b964b07152d234b70','Y','2017-04-27','2017-04-27','HOME','04','2017','T','0.00','',''),(233,20,'20173297','i0212','202cb962ac59075b964b07152d234b70','Y','2017-04-27','2017-04-27','HOME','04','2017','T','0.00','',''),(234,10,'20173297','gede0427','e10adc3949ba59abbe56e057f20f883e','Y','2017-04-27','2017-04-27','HOME','04','2017','T','0.00','',''),(235,10,'20173304','gede2411','35b1ad16870d2eb3f21d52ffdc65c3c7','Y','2017-05-04','2017-05-04','HOME','05','2017','T','0.00','',''),(236,10,'20173276','i2610','5c042bb72bdff14cbb712c7b8c4187b7','Y','2017-05-04','2017-05-04','HOME','05','2017','T','0.00','',''),(237,10,'20173308','ni2602','ba1154216fab08ce131434e12f3e88a8','Y','2017-05-09','2017-05-09','HOME','05','2017','T','0.00','',''),(238,0,'20173319','ni0404','','0','0000-00-00','0000-00-00',NULL,NULL,NULL,'T','0.00','',''),(239,16,'20173319','made0404','caf7ec9326cb03e51a646eeca882a25d','Y','2017-05-22','2017-05-22','HOME','05','2017','T','0.00','',''),(240,-1,'20173325','i2911','930ba496790a0bdeedc6a6eca8729f71','Y','2017-05-29','2017-05-29','HOME','05','2017','T','0.00','',''),(241,0,'20173320','mansyur2905','e10adc3949ba59abbe56e057f20f883e','Y','2017-05-29','2017-05-29','HOME','05','2017','T','0.00','',''),(242,16,'20163198','victor1207','e10adc3949ba59abbe56e057f20f883e','Y','2017-05-29','2017-05-29','HOME','05','2017','T','0.00','',''),(243,6,'20163192','grammy0404','e10adc3949ba59abbe56e057f20f883e','Y','2017-05-29','2017-05-29','HOME','05','2017','T','0.00','',''),(246,10,'20173350','ni0907','5709e71deecaac7ebf42cd11bfa10af6','Y','2017-07-12','2017-07-12','HOME','07','2017','T','0.00','',''),(247,10,'20173347','ni1202','8b873bdaabff76c3cbf9b5f4d14dd604','Y','2017-07-12','2017-07-12','HOME','07','2017','T','0.00','',''),(248,10,'20173348','ni0512','ec15154afe90c60e06a8ac08270e858e','Y','2017-07-12','2017-07-12','HOME','07','2017','T','0.00','',''),(249,10,'20173349','ni1410','9d21956a1fe656b5c5d393b97526f1a9','Y','2017-07-12','2017-07-12','HOME','07','2017','T','0.00','',''),(250,22,'20173256','rizal2504','d42e4fad07bdfc2d87e2daefdc96b78c','Y','2017-07-12','2017-07-12','HOME','07','2017','T','0.00','',''),(251,0,'20173292','r.0206','','0','0000-00-00','0000-00-00',NULL,NULL,NULL,'T','0.00','',''),(252,22,'20173292','deril0206','8e498d751b17a350ef396bdb7c4856cf','Y','2017-07-26','2017-07-26','HOME','07','2017','T','0.00','',''),(253,5,'20173323','kho2211','7673268d3a35d9ec05bab4bf56ba953e','Y','2017-07-26','2017-07-26','HOME','07','2017','T','0.00','',''),(256,-1,'20173361','putu1404','ec28a2825025eb62adce5b9489b4e9f4','Y','2017-07-29','2017-07-29','HOME','07','2017','T','0.00','','');

/*Table structure for table `userlevelpermissions` */

DROP TABLE IF EXISTS `userlevelpermissions`;

CREATE TABLE `userlevelpermissions` (
  `userlevelid` char(2) COLLATE latin1_general_ci NOT NULL,
  `tablename` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `add` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'Y' COMMENT 'y=ya,t=tidak',
  `edit` char(1) COLLATE latin1_general_ci DEFAULT 'Y' COMMENT 'y=ya,t=tidak',
  `delete` char(1) COLLATE latin1_general_ci DEFAULT 'Y' COMMENT 'y=ya,t=tidak',
  `view` char(1) COLLATE latin1_general_ci DEFAULT 'Y' COMMENT 'y=ya,t=tidak',
  PRIMARY KEY (`userlevelid`,`tablename`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `userlevelpermissions` */

insert  into `userlevelpermissions`(`userlevelid`,`tablename`,`add`,`edit`,`delete`,`view`) values ('-1','Group Optional Tour','Y','Y','Y','Y'),('-1','Aktivitas','Y','Y','Y','Y'),('-1','Optional Tour','Y','Y','Y','Y'),('-1','Tour Guide','Y','Y','Y','Y'),('-1','Tour','Y','Y','Y','Y'),('-1','Main Tour','Y','Y','Y','Y');

/*Table structure for table `userlevels` */

DROP TABLE IF EXISTS `userlevels`;

CREATE TABLE `userlevels` (
  `UserLevelID` int(11) NOT NULL DEFAULT '0',
  `UserLevelName` varchar(50) NOT NULL,
  `AddDate` date NOT NULL DEFAULT '0000-00-00',
  `EditDate` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`UserLevelID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `userlevels` */

insert  into `userlevels`(`UserLevelID`,`UserLevelName`,`AddDate`,`EditDate`) values (-1,'Administrator','0000-00-00','0000-00-00'),(4,'AUDIT','2015-12-31','0000-00-00'),(1,'Finance','2015-12-31','0000-00-00'),(3,'HRGA','2015-12-31','0000-00-00'),(2,'PURCHASING','2015-12-31','2016-10-20'),(5,'GUDANG','2015-12-31','0000-00-00'),(6,'MARKETING','2015-12-31','0000-00-00'),(7,'SALES','2015-12-31','0000-00-00'),(8,'RESTO','2015-12-31','0000-00-00'),(9,'COFFEE','2015-12-31','0000-00-00'),(10,'KASIR','2015-12-31','2016-10-20'),(11,'REPORTING','2015-12-31','0000-00-00'),(12,'KASIR HO','2016-10-28','0000-00-00'),(13,'Admin Kasir','0000-00-00','0000-00-00'),(14,'Ticketing','0000-00-00','0000-00-00'),(15,'Kepala Kasir','0000-00-00','0000-00-00'),(16,'Admin Operation','0000-00-00','0000-00-00'),(20,'Waiter','0000-00-00','0000-00-00'),(21,'Kepala Gudang','0000-00-00','0000-00-00'),(22,'Produksi','0000-00-00','0000-00-00'),(23,'Sales','0000-00-00','0000-00-00'),(24,'Admin IT','0000-00-00','0000-00-00'),(25,'Receiptionis','0000-00-00','0000-00-00'),(26,'Registrasi','0000-00-00','0000-00-00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
