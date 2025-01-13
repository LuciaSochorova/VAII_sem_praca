
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `vaiicko_db`;
CREATE DATABASE `vaiicko_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `vaiicko_db`;

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

INSERT INTO `ingredients` (`id`, `name`) VALUES
(46,	'banán'),
(38,	'cesnak'),
(42,	'cestoviny'),
(44,	'čierne olivy'),
(49,	'grécky jogurt'),
(48,	'hrozno'),
(47,	'hruška'),
(45,	'jablko'),
(40,	'korenie'),
(36,	'kuracie prsia'),
(50,	'med'),
(37,	'olivový olej'),
(39,	'soľ'),
(51,	'škorica'),
(43,	'tuniak'),
(41,	'zelenina');

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `minutes` int(11) NOT NULL,
  `portions` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` enum('sladké','slané') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `reported` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `recipes_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

INSERT INTO `recipes` (`id`, `author_id`, `title`, `description`, `minutes`, `portions`, `image`, `category`, `notes`, `reported`) VALUES
(39,	1,	'Kuracie prsia na rýchlo',	'Kuracie prsia na rýchlo je jednoduché a výživné jedlo, ktoré si obľúbia milovníci rýchlej a chutnej kuchyne. Kombinuje jemné kuracie mäso s rôznou zeleninou, čím vznikne vyvážená a chutná večera. Je to skvelá voľba pre tých, ktorí chcú zdravo a rýchlo sa najesť.',	20,	4,	NULL,	'slané',	NULL,	NULL),
(40,	2,	'Cestoviny s tuniakom a olivami',	'Skvelá voľba pre tých, ktorí hľadajú jednoduchý a chutný recept.',	15,	2,	'public/uploads/images/img_55dae4ac41a9eddf210d5028a0f6813d',	'slané',	NULL,	NULL),
(41,	3,	'Ovocný šalát s jogurtom',	'Tento ovocný šalát je skvelým spôsobom, ako si dopriať niečo sladké a zdravé zároveň.',	5,	1,	'public/uploads/images/img_667e04282d32de481408b9056b592984',	NULL,	'Tip: Pridaj do šalátu aj orechy alebo semienka pre extra chuť a výživné látky.',	NULL);

DROP TABLE IF EXISTS `recipe_ingredients`;
CREATE TABLE `recipe_ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `com` (`ingredient_id`,`recipe_id`),
  KEY `recipe_id` (`recipe_id`),
  CONSTRAINT `recipe_ingredients_ibfk_3` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `recipe_ingredients_ibfk_4` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `recipe_ingredients` (`id`, `recipe_id`, `ingredient_id`, `amount`) VALUES
(135,	39,	36,	'2 ks'),
(136,	39,	37,	'1 lyžica'),
(137,	39,	38,	'1 strúčik'),
(138,	39,	39,	'od oka'),
(139,	39,	40,	'od oka'),
(140,	39,	41,	'primerane'),
(153,	41,	45,	'2'),
(154,	41,	46,	'1'),
(155,	41,	47,	'1'),
(156,	41,	48,	'100g'),
(157,	41,	49,	'200g'),
(158,	41,	50,	'2 lyžice'),
(159,	41,	51,	'štipka'),
(160,	40,	42,	'200g'),
(161,	40,	43,	'1 konzerva'),
(162,	40,	44,	'50g'),
(163,	40,	37,	'primerane'),
(164,	40,	39,	'od oka');

DROP TABLE IF EXISTS `steps`;
CREATE TABLE `steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`),
  CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `steps` (`id`, `recipe_id`, `text`, `order`) VALUES
(48,	39,	'Kuracie prsia nakrájame na rezne a osolíme, okoreníme.',	1),
(49,	39,	'Na panvici rozohrejeme olej a opečieme kuracie mäso dozlatista.',	2),
(50,	39,	'Pridáme na kocky nakrájanú zeleninu a restujeme, kým nezmäkne.',	3),
(51,	39,	'Podávame s ryžou alebo zemiakmi.',	4),
(52,	40,	'Uvaríme cestoviny podľa návodu.',	1),
(53,	40,	'Tuniaka odcedíme a rozdrobíme.',	2),
(54,	40,	'V miske zmiešame cestoviny, tuniaka, olivy, soľ.',	3),
(55,	41,	'Ovocie dôkladne umyj a nakrájaj na kocky alebo plátky.',	1),
(56,	41,	'V miske zmiešaj nakrájané ovocie, grécky jogurt a med.',	2),
(57,	41,	'Posyp škoricou a dobre premiešaj.',	3);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `email`, `password_hash`, `role`) VALUES
(1,	'admin@admin.com',	'$2y$10$GRA8D27bvZZw8b85CAwRee9NH5nj4CQA6PDFMc90pN9Wi4VAWq3yq',	'admin'),
(2,	'test1@test.com',	'$2y$10$iKEdcltPWYKhVYZR.fLkfu.206k4jPZc875kbSdQfxZ28NTy34lAK',	'user'),
(3,	'test2@test.com',	'$2y$10$zXszjO.xVzfy06hAkxD5b.yJUP98HNTpW28WBPtt5jc8GY.G0Dq4a',	'user');


