SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Structure de la table `characters`
--

CREATE TABLE `characters` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `data` text NOT NULL,
  `max_health` int(11) NOT NULL,
  `cur_health` int(11) NOT NULL,
  `char_modifiers` text NOT NULL,
  `initiative` int(11) NOT NULL DEFAULT 1,
  `role` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `owner` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Index and AUTO_INCREMENT for `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
COMMIT;