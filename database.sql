-- MariaDB dump 10.19-11.1.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dd
-- ------------------------------------------------------
-- Server version	11.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `characters`
--

DROP TABLE IF EXISTS `characters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `hp` int(11) DEFAULT NULL,
  `ap` int(11) DEFAULT NULL,
  `dp` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `inventaire` varchar(255) DEFAULT NULL,
  `equipped_weapon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `equipped_weapon_id` (`equipped_weapon_id`),
  CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`equipped_weapon_id`) REFERENCES `weapons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characters`
--

LOCK TABLES `characters` WRITE;
/*!40000 ALTER TABLE `characters` DISABLE KEYS */;
INSERT INTO `characters` VALUES
(1,'Alice',55,30,35,0,1,'Épée en bois',1),
(2,'Bob',15,48,72,0,1,'Arc court',NULL),
(3,'Charlie',35,85,50,0,1,'Dague',NULL),
(4,'Diana',20,32,18,0,1,'Bâton magique',NULL),
(5,'Luna',110,22,18,0,1,'Magical Wand',NULL),
(6,'Garen',150,30,25,0,1,'Legendary Sword',NULL),
(7,'Elara',65,20,25,0,1,'Elven Bow',NULL),
(8,'Kael',21054,1443,1287,80,24,'Poisoned Dagger, Ring of Invisibility, Puff 6k, Enchanted Sword, hash bar, Potion of Healing',NULL);
/*!40000 ALTER TABLE `characters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combats`
--

DROP TABLE IF EXISTS `combats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) DEFAULT NULL,
  `monster_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`),
  KEY `monster_id` (`monster_id`),
  CONSTRAINT `combats_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`),
  CONSTRAINT `combats_ibfk_2` FOREIGN KEY (`monster_id`) REFERENCES `monsters` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combats`
--

LOCK TABLES `combats` WRITE;
/*!40000 ALTER TABLE `combats` DISABLE KEYS */;
INSERT INTO `combats` VALUES
(1,1,1),
(2,2,2),
(3,3,3),
(4,4,4),
(5,1,2),
(6,2,3),
(7,3,4),
(8,4,1),
(9,1,3),
(10,2,4);
/*!40000 ALTER TABLE `combats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `combat_id` int(11) DEFAULT NULL,
  `loot_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`),
  KEY `room_id` (`room_id`),
  KEY `combat_id` (`combat_id`),
  KEY `loot_id` (`loot_id`),
  CONSTRAINT `games_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`),
  CONSTRAINT `games_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  CONSTRAINT `games_ibfk_3` FOREIGN KEY (`combat_id`) REFERENCES `combats` (`id`),
  CONSTRAINT `games_ibfk_4` FOREIGN KEY (`loot_id`) REFERENCES `loots` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES
(1,1,1,1,3),
(2,2,2,2,2),
(3,3,3,3,3),
(4,4,4,4,4),
(5,1,2,1,3),
(6,2,3,2,3),
(7,3,4,3,4),
(8,4,1,4,1),
(9,1,3,1,3),
(10,2,4,2,4),
(11,1,1,1,3),
(12,2,2,2,2),
(13,3,3,3,3),
(14,4,4,4,4),
(15,1,2,1,3),
(16,2,3,2,3),
(17,3,4,3,4),
(18,4,1,4,1),
(19,1,3,1,3),
(20,2,4,2,4);
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loots`
--

DROP TABLE IF EXISTS `loots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `magical_items` varchar(255) DEFAULT NULL,
  `cursed_items` varchar(255) DEFAULT NULL,
  `cursed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loots`
--

LOCK TABLES `loots` WRITE;
/*!40000 ALTER TABLE `loots` DISABLE KEYS */;
INSERT INTO `loots` VALUES
(1,'Enchanted Sword',NULL,1),
(2,'Potion of Healing',NULL,0),
(3,'Ring of Invisibility','Cursed Amulet of Weakness',1),
(4,'Puff 6k','The paqueta curse',1),
(5,'hash bar',NULL,0);
/*!40000 ALTER TABLE `loots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchantinventory`
--

DROP TABLE IF EXISTS `merchantinventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchantinventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant` varchar(255) DEFAULT NULL,
  `loot_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loot_id` (`loot_id`),
  CONSTRAINT `merchantinventory_ibfk_1` FOREIGN KEY (`loot_id`) REFERENCES `loots` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchantinventory`
--

LOCK TABLES `merchantinventory` WRITE;
/*!40000 ALTER TABLE `merchantinventory` DISABLE KEYS */;
INSERT INTO `merchantinventory` VALUES
(1,'Karim Du 93',1),
(2,'Bob The Merchant',2),
(3,'paqueta',3);
/*!40000 ALTER TABLE `merchantinventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monsters`
--

DROP TABLE IF EXISTS `monsters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monsters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `hp` int(11) DEFAULT NULL,
  `ap` int(11) DEFAULT NULL,
  `dp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monsters`
--

LOCK TABLES `monsters` WRITE;
/*!40000 ALTER TABLE `monsters` DISABLE KEYS */;
INSERT INTO `monsters` VALUES
(1,'Goblin',50,10,5),
(2,'Orc',80,15,10),
(3,'Dragon',150,30,25),
(4,'Skeleton',40,8,4),
(5,'Shadow Wizard',120,25,15),
(6,'Spectral Guard',80,18,12),
(7,'Fire Dragon',200,35,30),
(8,'Fallen Archer',60,20,10);
/*!40000 ALTER TABLE `monsters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puzzles`
--

DROP TABLE IF EXISTS `puzzles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puzzles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text DEFAULT NULL,
  `choice1` varchar(255) DEFAULT NULL,
  `choice2` varchar(255) DEFAULT NULL,
  `choice3` varchar(255) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puzzles`
--

LOCK TABLES `puzzles` WRITE;
/*!40000 ALTER TABLE `puzzles` DISABLE KEYS */;
INSERT INTO `puzzles` VALUES
(1,'Quel est le nom du premier président des États-Unis ?','George Washington','Thomas Jefferson','John Adams','1'),
(2,'Quelle est la capitale de la France ?','Berlin','Paris','Londres','1'),
(3,'Combien de côtés a un triangle ?','3','4','5','1'),
(4,'I can be cracked, made, told, and played. What am I?','A joke','A code','A melody','2'),
(5,'The more you take, the more you leave behind. What am I?','Footsteps','Wisdom','Money','1'),
(6,'I fly without wings. I cry without eyes. Wherever I go, darkness follows me. What am I?','A cloud','A bat','A storm','3'),
(7,'What has keys but can\'t open locks?','A piano','A computer','A book','1'),
(8,'What comes once in a minute, twice in a moment, but never in a thousand years?','The letter M','The letter A','The letter E','1');
/*!40000 ALTER TABLE `puzzles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `special` tinyint(1) DEFAULT NULL,
  `puzzle` varchar(255) DEFAULT NULL,
  `trap` varchar(255) DEFAULT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `puzzle_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `puzzle_id` (`puzzle_id`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`puzzle_id`) REFERENCES `puzzles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES
(1,1,'1',NULL,'Karim Du 93',1),
(2,0,NULL,'Beware of the hidden pit trap!',NULL,NULL),
(3,1,'2',NULL,'Bob the Merchant',2),
(4,1,NULL,NULL,'Paqueta',NULL),
(5,0,NULL,NULL,NULL,NULL),
(6,1,'3',NULL,'Bob the Merchant',3),
(7,0,NULL,'Hidden pit trap under the floor',NULL,NULL),
(8,1,NULL,NULL,'Karim Du 93',NULL),
(9,0,NULL,NULL,NULL,NULL),
(10,1,'5',NULL,'Paqueta ',5),
(11,0,NULL,'Hidden pit trap under the floor',NULL,NULL),
(12,1,NULL,NULL,'Bob The Merchant',NULL),
(13,0,NULL,'Swinging blade trap across the doorway',NULL,NULL),
(14,1,'4',NULL,'Bob The Merchant',4),
(15,1,NULL,NULL,'Friendly Goblin Shopkeeper',NULL),
(16,1,NULL,'Poisonous gas fills the room',NULL,NULL),
(17,1,NULL,NULL,'Karim Du 93',NULL),
(18,1,NULL,NULL,'',NULL),
(19,0,'1',NULL,'',1),
(20,1,'1',NULL,'Karim Du 93',1);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weapons`
--

DROP TABLE IF EXISTS `weapons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weapons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level_required` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weapons`
--

LOCK TABLES `weapons` WRITE;
/*!40000 ALTER TABLE `weapons` DISABLE KEYS */;
INSERT INTO `weapons` VALUES
(1,'Sword of Beginner',1,10,'A basic sword for beginners'),
(2,'Axe of the Warrior',5,20,'A powerful axe for seasoned warriors'),
(3,'Staff of the Mage',10,15,'A magical staff for mages');
/*!40000 ALTER TABLE `weapons` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-24 16:31:47
