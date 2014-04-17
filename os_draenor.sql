-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 17 2014 г., 23:07
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `os_draenor`
--

-- --------------------------------------------------------

--
-- Структура таблицы `os_clusters`
--

CREATE TABLE IF NOT EXISTS `os_clusters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(5) NOT NULL,
  `link` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'free',
  `cluster_id` int(11) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- Дамп данных таблицы `os_clusters`
--

INSERT INTO `os_clusters` (`id`, `type`, `link`, `status`, `cluster_id`, `data`) VALUES
(1, 'S', 0, 'busy', 1, 'None'),
(2, 'S', 0, 'free', 2, 'None'),
(3, 'S', 0, 'free', 3, 'None'),
(4, 'S', 0, 'free', 4, 'None'),
(5, 'S', 0, 'free', 5, 'None'),
(6, 'S', 0, 'free', 6, 'None'),
(7, 'S', 0, 'free', 7, 'None'),
(8, 'S', 0, 'free', 8, 'None'),
(9, 'S', 0, 'free', 9, 'None'),
(10, 'S', 0, 'free', 10, 'None'),
(11, 'S', 0, 'free', 11, 'None'),
(12, 'S', 0, 'free', 12, 'None'),
(13, 'S', 0, 'free', 13, 'None'),
(14, 'S', 0, 'free', 14, 'None'),
(15, 'S', 0, 'free', 15, 'None'),
(16, 'S', 0, 'free', 16, 'None'),
(17, 'S', 0, 'free', 17, 'None'),
(18, 'S', 0, 'free', 18, 'None'),
(19, 'S', 0, 'free', 19, 'None'),
(20, 'S', 0, 'free', 20, 'None'),
(21, 'S', 0, 'free', 21, 'None'),
(22, 'S', 0, 'free', 22, 'None'),
(23, 'S', 0, 'free', 23, 'None'),
(24, 'S', 0, 'free', 24, 'None'),
(25, 'S', 0, 'free', 25, 'None'),
(26, 'S', 0, 'free', 26, 'None'),
(27, 'S', 0, 'free', 27, 'None'),
(28, 'S', 0, 'free', 28, 'None'),
(29, 'S', 0, 'free', 29, 'None'),
(30, 'S', 0, 'free', 30, 'None'),
(31, 'U', 0, 'busy', 31, 'None'),
(32, 'U', 0, 'free', 32, 'None'),
(33, 'U', 0, 'free', 33, 'None'),
(34, 'U', 0, 'free', 34, 'None'),
(35, 'U', 0, 'free', 35, 'None'),
(36, 'U', 0, 'free', 36, 'None'),
(37, 'U', 0, 'free', 37, 'None'),
(38, 'U', 0, 'free', 38, 'None'),
(39, 'U', 0, 'free', 39, 'None'),
(40, 'U', 0, 'free', 40, 'None'),
(41, 'U', 0, 'free', 41, 'None'),
(42, 'U', 0, 'free', 42, 'None'),
(43, 'U', 0, 'free', 43, 'None'),
(44, 'U', 0, 'free', 44, 'None'),
(45, 'U', 0, 'free', 45, 'None'),
(46, 'U', 0, 'free', 46, 'None'),
(47, 'U', 0, 'free', 47, 'None'),
(48, 'U', 0, 'free', 48, 'None'),
(49, 'U', 0, 'free', 49, 'None'),
(50, 'U', 0, 'free', 50, 'None'),
(51, 'U', 0, 'free', 51, 'None'),
(52, 'U', 0, 'free', 52, 'None'),
(53, 'U', 0, 'free', 53, 'None'),
(54, 'U', 0, 'free', 54, 'None'),
(55, 'U', 0, 'free', 55, 'None'),
(56, 'U', 0, 'free', 56, 'None'),
(57, 'U', 0, 'free', 57, 'None'),
(58, 'U', 0, 'free', 58, 'None'),
(59, 'U', 0, 'free', 59, 'None'),
(60, 'U', 0, 'free', 60, 'None'),
(61, 'U', 0, 'free', 61, 'None'),
(62, 'U', 0, 'free', 62, 'None'),
(63, 'U', 0, 'free', 63, 'None'),
(64, 'U', 0, 'free', 64, 'None'),
(65, 'U', 0, 'free', 65, 'None'),
(66, 'U', 0, 'free', 66, 'None'),
(67, 'U', 0, 'free', 67, 'None'),
(68, 'U', 0, 'free', 68, 'None'),
(69, 'U', 0, 'free', 69, 'None'),
(70, 'U', 0, 'free', 70, 'None'),
(71, 'U', 0, 'free', 71, 'None'),
(72, 'U', 0, 'free', 72, 'None'),
(73, 'U', 0, 'free', 73, 'None'),
(74, 'U', 0, 'free', 74, 'None'),
(75, 'U', 0, 'free', 75, 'None'),
(76, 'U', 0, 'free', 76, 'None'),
(77, 'U', 0, 'free', 77, 'None'),
(78, 'U', 0, 'free', 78, 'None'),
(79, 'U', 0, 'free', 79, 'None'),
(80, 'U', 0, 'free', 80, 'None'),
(81, 'U', 0, 'free', 81, 'None'),
(82, 'U', 0, 'free', 82, 'None'),
(83, 'U', 0, 'free', 83, 'None'),
(84, 'U', 0, 'free', 84, 'None'),
(85, 'U', 0, 'free', 85, 'None'),
(86, 'U', 0, 'free', 86, 'None'),
(87, 'U', 0, 'free', 87, 'None'),
(88, 'U', 0, 'free', 88, 'None'),
(89, 'U', 0, 'free', 89, 'None'),
(90, 'U', 0, 'free', 90, 'None'),
(91, 'U', 0, 'free', 91, 'None'),
(92, 'U', 0, 'free', 92, 'None'),
(93, 'U', 0, 'free', 93, 'None'),
(94, 'U', 0, 'free', 94, 'None'),
(95, 'U', 0, 'free', 95, 'None'),
(96, 'U', 0, 'free', 96, 'None'),
(97, 'U', 0, 'free', 97, 'None'),
(98, 'U', 0, 'free', 98, 'None'),
(99, 'U', 0, 'free', 99, 'None'),
(100, 'U', 0, 'free', 100, 'None');

-- --------------------------------------------------------

--
-- Структура таблицы `os_commands`
--

CREATE TABLE IF NOT EXISTS `os_commands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `os_commands`
--

INSERT INTO `os_commands` (`id`, `name`, `desc`) VALUES
(1, 'wclear', 'Очистка дисплея консоли'),
(2, 'wds', 'Общее дисковое пространство'),
(3, 'wtcls', 'Общее количество кластеров'),
(4, 'wcrf', 'Создание файла'),
(5, 'wfrs', 'Свободное место на жестком диске'),
(6, 'wpath', 'Текущее местонахождение'),
(7, 'wlogout', 'Выход из системы'),
(8, 'wcluster_size', 'Размер кластера'),
(9, 'wos_init', 'Инициализация системы. (Внимание! Это приведет к потери всех данных!)'),
(11, 'wcrd', 'Создание нового каталога'),
(12, 'wls', 'Просмотр содержимого директории'),
(13, 'wrmd', 'Удаление каталога'),
(14, 'wgo', 'Переход в каталог'),
(15, 'wgoback', 'Возврат в родительскую директорию'),
(16, 'wof', 'Открыть файл'),
(17, 'wadduser', 'Создание нового пользователя');

-- --------------------------------------------------------

--
-- Структура таблицы `os_nodes`
--

CREATE TABLE IF NOT EXISTS `os_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `file_kind` varchar(5) NOT NULL,
  `access` varchar(10) NOT NULL,
  `begin` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent` int(11) NOT NULL,
  `date` varchar(100) NOT NULL,
  `creator` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `os_nodes`
--

INSERT INTO `os_nodes` (`id`, `type`, `file_kind`, `access`, `begin`, `size`, `name`, `parent`, `date`, `creator`) VALUES
(1, 'S', 'F', '0-0-0', 1, 36, 'draenor.sys', -1, '17-04-2014', 1),
(2, 'U', 'D', '7-7-5', 31, 29, 'home', 0, '17-04-2014', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `os_users`
--

CREATE TABLE IF NOT EXISTS `os_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'User',
  `home` int(5) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `os_users`
--

INSERT INTO `os_users` (`id`, `name`, `pass`, `role`, `home`, `location_id`, `status`) VALUES
(1, 'Alexey', '1234', 'Admin', 0, 31, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
