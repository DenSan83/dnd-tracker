SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
--  `config` table
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conf_key` varchar(255) NOT NULL,
  `conf_value` varchar(255) NOT NULL,
  `visibility` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
--  `config` content
--

INSERT INTO `config` (`id`, `conf_key`, `conf_value`, `visibility`) VALUES
(1, 'allow_login', '1', 'admin'),
(2, 'logout_user', '0', 'admin'),
(3, 'spell_columns', 'level, school, casting_time, duration, sp_range, sp_area, attack, save, damage_effect, ritual, concentration, vsm, verbal, somatic, material, material_list, source, details, url', 'admin');
COMMIT;
