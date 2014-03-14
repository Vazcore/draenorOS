-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 14 2014 г., 23:15
-- Версия сервера: 5.6.16
-- Версия PHP: 5.4.25

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `os_commands`
--

CREATE TABLE IF NOT EXISTS `os_commands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

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
(12, 'wls', 'Просмотр содержимвого директории'),
(13, 'wrmd', 'Удаление каталога'),
(14, 'wgo', 'Переход в каталог'),
(15, 'wgoback', 'Возврат в родительскую директорию');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `os_users`
--

CREATE TABLE IF NOT EXISTS `os_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'User',
  `location_id` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `os_users`
--

INSERT INTO `os_users` (`id`, `name`, `pass`, `role`, `location_id`, `status`) VALUES
(1, 'Alexey', '1234', 'Admin', 31, 1),
(2, 'Alex', '1234', 'User', 31, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
