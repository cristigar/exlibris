-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Gazda: sql201.byethost33.com
-- Timp de generare: 19 Apr 2016 la 06:49
-- Versiune server: 5.6.29-76.2
-- Versiune PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Bază de date: `b33_17781728_exlibris`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

--
-- Salvarea datelor din tabel `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
(4, 'Alcorn Wade'),
(5, 'Barker Tom'),
(12, 'Frăsinaru Cristian'),
(29, 'Кнут Дональд'),
(46, 'Meyer Eric'),
(59, 'Rochkind Marc'),
(43, 'Drăgulănescu Nicolae'),
(44, 'Autor'),
(47, 'Oppel Andy'),
(48, 'Crockford Douglas'),
(49, 'Шаньгин Владимир Федорович'),
(50, 'Haverbeke Marijn'),
(51, 'Zakas Nicholas'),
(52, 'Williamson Ken'),
(53, 'Monteiro Fernando'),
(54, 'Гололобов В. Н.'),
(55, 'Wilson Chris'),
(56, 'Tanenbaum Andrew'),
(57, 'Flanagan David'),
(58, 'DuBois Paul'),
(60, 'Manian Divya'),
(61, 'Brown Ethan'),
(62, 'Sikos Leslie'),
(63, 'Ramtal Dev'),
(64, 'Blum Richard'),
(65, 'Niemeyer Patrick'),
(66, 'Peterson Clarissa'),
(67, 'Heineman George');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `author` int(100) NOT NULL,
  `pub_year` smallint(4) DEFAULT NULL,
  `num_of_pages` int(5) NOT NULL,
  `lang` int(11) NOT NULL,
  `publisher` int(11) DEFAULT NULL,
  `locality` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `lang` (`lang`),
  KEY `publisher` (`publisher`),
  KEY `locality` (`locality`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Salvarea datelor din tabel `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `pub_year`, `num_of_pages`, `lang`, `publisher`, `locality`, `isbn`) VALUES
(41, 'Values, Units, and Colors', 46, 2012, 46, 2, 2, 2, '978-1-449-34251-7'),
(2, 'The Browser Hacker''s Handbook', 4, 2014, 650, 2, 1, 1, '978-1-118-66210-6'),
(3, 'High Performance Responsive Web Design', 5, 2015, 176, 2, 2, 2, '978-1-491-94998-6'),
(4, 'Curs practic de Java', 12, NULL, 462, 1, NULL, NULL, NULL),
(5, 'Искусство программирования. Том 1. Основные алгоритмы', 29, 2015, 720, 3, NULL, 6, '978-5-8459-0080-7'),
(26, 'CSS and Documents', 46, 2012, 35, 2, 2, 2, '978-1-449-34247-0'),
(27, 'SQL fără mistere', 47, 0, 304, 1, 19, 25, ''),
(43, 'HTML5 Boilerplate Web Development', 60, 2012, 174, 2, 23, 28, '978-1-84951-850-5'),
(23, 'Agenda radioelectronistului', 43, 1989, 752, 1, 16, 22, '973-31-0079-X'),
(24, 'Ghid metodologic', 44, 2015, 164, 1, 17, 23, ''),
(42, 'Expert PHP and MySQL. Application Design and Development', 59, 2013, 328, 2, 25, 30, '978-1-4302-6008-0'),
(28, 'JavaScript. The Good Parts', 48, 2008, 172, 2, 2, 2, '978-0-596-51774-8'),
(29, 'Защита информации в компьютерных системах и сетях', 49, 2012, 593, 3, 20, 6, '978-5-94074-637-9'),
(30, 'Eloquent JavaScript', 50, 2014, 490, 2, 21, 25, ''),
(31, 'The Principles of Object-Oriented JavaScript', 51, 2014, 122, 2, 22, 26, '978-1-59327-540-2'),
(32, 'Learning AngularJS', 52, 2015, 325, 2, 2, 27, '978-1-491-91675-9'),
(33, 'Learning Single-page Web Application Development', 53, 2014, 214, 2, 23, 28, '978-1-78355-209-2'),
(34, 'CSS Pocket Reference, Fourth Edition', 46, 2011, 250, 2, 2, 2, '978-1-449-39903-0'),
(35, 'Наглядная электроника', 54, 2007, 80, 3, 21, 6, ''),
(36, 'RaphaëlJS', 55, 2014, 121, 2, 2, 2, '978-1-449-36536-3'),
(37, 'Modern Operating Systems', 56, 2015, 1137, 2, 24, 29, '978-0-13-359162-0'),
(38, 'JavaScript Pocket Reference, Third Edition', 57, 2012, 280, 2, 2, 2, '978-1-449-31685-3'),
(39, 'MySQL Cookbook, Third Edition', 58, 2014, 866, 2, 2, 2, '978-1-449-37402-0'),
(40, 'CSS. The Definitive Guide, Third Edition', 46, 2007, 538, 2, 2, 2, '978-0-596-52733-4'),
(44, 'Selectors, Specificity, and the Cascade', 46, 2012, 85, 2, 2, 2, '978-1-449-34249-4'),
(45, 'Web Development with Node and Express', 61, 2014, 329, 2, 2, 28, '978-1-491-94930-6'),
(46, 'CSS Fonts', 46, 2013, 68, 2, 2, 2, '978-1-449-37149-4'),
(47, 'Web Standards - Mastering HTML5, CSS3, and XML', 62, 2014, 510, 2, 25, 30, '978-1-4842-0883-0'),
(48, 'Physics for JavaScript Games, Animation, and Simulations with HTML5 Canvas', 63, 2014, 490, 2, 25, 30, '978-1-4302-6338-8'),
(49, 'Linux® Command Line and Shell Scripting Bible, Third Edition', 64, 2015, 818, 2, 1, 1, '978-1-118-98385-0'),
(50, 'Learning Java, Fourth Edition', 65, 2013, 1010, 2, 2, 28, '978-1-449-31924-3'),
(51, 'Искусство программирования. Том 2. Получисленные алгоритмы', 29, 2011, 832, 3, 26, 6, '978-5-8459-0081-4'),
(52, 'Искусство программирования. Том 3. Сортировка и поиск', 29, 2012, 824, 3, 26, 6, '978-5-8459-0082-1'),
(54, 'Learning Responsive Web Design', 66, 2014, 412, 2, 2, 2, '978-1-4493-6294-2'),
(55, 'JavaScript. The Definitive Guide, Sixth Edition', 57, 2011, 1098, 2, 2, 2, '978-0-596-80552-4'),
(56, 'Algorithms in a Nutshell', 67, 2009, 344, 2, 2, 2, '978-0-596-51624-6');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `langs`
--

CREATE TABLE IF NOT EXISTS `langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Salvarea datelor din tabel `langs`
--

INSERT INTO `langs` (`id`, `name`) VALUES
(1, 'română'),
(2, 'english'),
(3, 'русский');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `localities`
--

CREATE TABLE IF NOT EXISTS `localities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Salvarea datelor din tabel `localities`
--

INSERT INTO `localities` (`id`, `name`) VALUES
(1, 'Indianapolis'),
(2, 'Sebastopol'),
(6, 'Москва'),
(25, ''),
(30, 'New York'),
(22, 'București'),
(23, 'Chișinău'),
(26, 'San Francisco'),
(27, 'Cambridge'),
(28, 'Birmingham'),
(29, 'New Jersey');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `publishers`
--

CREATE TABLE IF NOT EXISTS `publishers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Salvarea datelor din tabel `publishers`
--

INSERT INTO `publishers` (`id`, `name`) VALUES
(1, 'Wiley'),
(2, 'O''Reilly'),
(19, 'Rosetti'),
(25, 'Apress'),
(16, 'Tehnică'),
(17, 'Pro Didactica'),
(20, 'ДМК Пресс'),
(21, ''),
(22, 'No Starch Press'),
(23, 'Packt Publishing'),
(24, 'Pearson Prentice-Hall'),
(26, 'Вильямс');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
