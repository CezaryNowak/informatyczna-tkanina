-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2022 at 01:29 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `informatyczna-tkanina`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins`
(
    `id`       int(11) NOT NULL,
    `nick`     text    NOT NULL,
    `email`    text    NOT NULL,
    `password` text    NOT NULL,
    `date`     date    NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nick`, `email`, `password`, `date`)
VALUES (1, 'admin', 'admin@informatycznatkanina.com', '$2y$10$gDMsNZEbi8LGp2y/I9.m3.vtIvnNHMxne83Vy4nyF5yEUt/2.aCJ2',
        '2022-07-25'),
       (3, 'admin1', 'test@test.com', '$2y$10$HcNYjyWHvhnp7FTu6c5oieeWNo839vcu7rMGBwdf4r0L3iVehxKYu', '2022-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories`
(
    `id`       int(11)                                        NOT NULL,
    `category` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
    `date`     date                                           NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `date`)
VALUES (2, 'Numeryczna', '2022-07-25'),
       (3, 'Abstrakcja', '2022-07-25'),
       (4, 'Natura', '2022-07-25');

-- --------------------------------------------------------

--
-- Table structure for table `wallpapers`
--

CREATE TABLE `wallpapers`
(
    `id`          int(11)                                        NOT NULL,
    `title`       text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
    `description` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
    `category`    text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
    `image`       text                                           NOT NULL,
    `size`        int(11)                                        NOT NULL,
    `width`       int(11)                                        NOT NULL,
    `height`      int(11)                                        NOT NULL,
    `date`        date                                           NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Dumping data for table `wallpapers`
--

INSERT INTO `wallpapers` (`id`, `title`, `description`, `category`, `image`, `size`, `width`, `height`, `date`)
VALUES (1, 'Dominująca jedynka', 'Jedynka pokazuje swoją obecność.', 'Numeryczna', 'ZdreqGidp0.png', 12535, 1920, 1080,
        '2022-07-25'),
       (3, 'Dw&oacute;jka pierwsza', 'Dw&oacute;jka postanowiła być pierwsza', 'Numeryczna', 'ZzIhnenrTc.png', 26468,
        1920, 1080, '2022-07-25'),
       (4, 'Tr&oacute;jka po prawicy jedynki', 'Mniejsza tr&oacute;jka stoi po prawicy jedynki.', 'Numeryczna',
        'h9oeuKaJIN.png', 14077, 1920, 1080, '2022-07-25'),
       (8, 'Jasne fale barwowe', 'Mieszanina jasnych barw.', 'Abstrakcja', 'CZ5icd69jz.png', 1150783, 1920, 1080,
        '2022-07-25'),
       (9, 'Mieszanie wirowania farb', 'Lekko ciemne barwy z zielenią w roli centrum.', 'Abstrakcja', '3WHaXOUgmR.png',
        1150782, 1920, 1080, '2022-07-25'),
       (10, 'Mroczne odcienie koloru', 'Ciemne barwy z kolorami pr&oacute;bującymi przebić czerń.', 'Abstrakcja',
        'spSIumTspf.png', 1680595, 1920, 1080, '2022-07-25'),
       (11, 'Kolorowa mieszanina materiału', 'Kolorowa mieszanina jasnych żywych barw.', 'Abstrakcja', 'qMwJSV1kxp.png',
        2334764, 1920, 1080, '2022-07-25'),
       (12, 'Kolorowa jasność pośrodku kolorowego wiru ciemności', 'Kolorowo ciemny wir prowadzi ku jasnym barwom.',
        'Abstrakcja', 'QjO26CwNqy.png', 2117586, 1920, 1080, '2022-07-25'),
       (13, 'Niebieski świt planety', 'Niebieski świt unosi się nad ciemną planetą', 'Abstrakcja', 'FNA9Imz0nK.png',
        4251925, 3840, 2160, '2022-07-25'),
       (14, 'Niebieski armagedon fioletu', 'Niebieski rozświetla ciemność fioletu.', 'Abstrakcja', 'ASbaPbTK3P.png',
        8210925, 3840, 2160, '2022-07-25'),
       (15, 'Kraniec kolor&oacute;w', 'Szaro kolorowe kolory znajdują u krańcu kolor&oacute;w', 'Abstrakcja',
        'X69ZygtDot.png', 4083712, 1920, 1080, '2022-07-25'),
       (16, 'Blaknięcie kolor&oacute;w', 'Kolory zaczynają tracić sw&oacute;ją wyrazistość oraz sw&oacute;j blask.',
        'Abstrakcja', 'M0K8QGdd4W.png', 4695607, 1920, 1080, '2022-07-25'),
       (17, 'Głębia tęczy', 'Jasno barwne kolory nadają nowy kształ tęczy.', 'Abstrakcja', 'B0GuIdgzgr.png', 994611,
        1920, 1080, '2022-07-25'),
       (18, 'Infiltracja fioletowych pierścieni', 'Fioletowe pierścienie infiltrują jasne barwy.', 'Abstrakcja',
        '7eY1QBmiLj.png', 1355256, 1920, 1080, '2022-07-25'),
       (19, 'Eksplozja czerwonego obiektu', 'Czerwony obiekt zaczyna pochłaniać całe otoczenie', 'Abstrakcja',
        'Oq37GCR5sz.png', 1311471, 1920, 1080, '2022-07-25'),
       (20, 'Neony wśr&oacute;d nocy',
        'Neony roświetlają swym zielono ż&oacute;łtym blaskiem pośr&oacute;d małej ciemności.', 'Abstrakcja',
        '2eJnEhrk7z.png', 2346789, 1920, 1080, '2022-07-25'),
       (21, 'Wyrazistość kolor&oacute;w',
        'Zielone czerwone niebieskie i ż&oacute;łty kolory walczą o dominację nad powierzchnią.', 'Abstrakcja',
        'NjuEvlkk2M.png', 837215, 1280, 720, '2022-07-25'),
       (22, 'Ścieżka w lesie',
        'Kamienna schody prowadzące do dalszej ścieżki w lesie.\r\nPhoto by https://unsplash.com/@joshmccausland',
        'Natura', 'yyzFXzacBe.jpg', 8499757, 4562, 6843, '2022-07-25'),
       (23, 'Krajobraz g&oacute;rski',
        'Piękny krajobraz g&oacute;rski w miejscowości Lanzada we Włoszech.\r\nPhoto by https://unsplash.com/@marekpiwnicki',
        'Natura', 'ELzZarw7XP.jpg', 3726218, 4854, 3034, '2022-07-25'),
       (24, 'Energia', 'Przeszywająca energia świateł.', 'Abstrakcja', 'r5wrA2VIIJ.jpg', 4171495, 3840, 3072,
        '2022-07-25'),
       (25, 'Wybuch ż&oacute;łtego światła', 'Wybuch światła podobnego do słonecznego.', 'Abstrakcja', '74eaotMZhy.jpg',
        1806331, 3200, 2400, '2022-07-25'),
       (26, 'test', 'test', 'Natura', 'drq5UfEBMq.jpg', 169137, 1280, 892, '2022-07-29'),
       (27, 'Ścieżka leśna', 'Piękna ścieżka leśna.\r\nPhoto by https://unsplash.com/@szmigieldesign', 'Natura',
        'dQM1v5iN8a.jpg', 1307559, 2560, 1705, '2022-08-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallpapers`
--
ALTER TABLE `wallpapers`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT for table `wallpapers`
--
ALTER TABLE `wallpapers`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
