CREATE DATABASE  IF NOT EXISTS `borrow_my_skill` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `borrow_my_skill`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: borrow_my_skill
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$KMBR9/3OJ6AFihYOqvVKVe2nfVA8gD.GaYAdGGDhky2hPn6m5ubJy','2025-12-14 10:20:36');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchanges`
--

DROP TABLE IF EXISTS `exchanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exchanges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `skill_id` int NOT NULL,
  `requester_id` int NOT NULL,
  `status` enum('pending','ongoing','completed','cancelled') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `skill_id` (`skill_id`),
  KEY `requester_id` (`requester_id`),
  CONSTRAINT `exchanges_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exchanges_ibfk_2` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchanges`
--

LOCK TABLES `exchanges` WRITE;
/*!40000 ALTER TABLE `exchanges` DISABLE KEYS */;
INSERT INTO `exchanges` VALUES (1,1,2,'pending','2025-12-14 10:20:06'),(3,3,10,'pending','2025-12-14 11:34:00'),(5,10,10,'completed','2025-12-15 12:29:02'),(6,14,10,'ongoing','2025-12-28 13:03:19'),(7,7,10,'pending','2025-12-29 00:00:50'),(9,13,1,'pending','2025-12-31 16:37:04');
/*!40000 ALTER TABLE `exchanges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exchange_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `exchange_id` (`exchange_id`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`exchange_id`) REFERENCES `exchanges` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,2,'Hi Alice, can we schedule a coding session this week?','2025-12-14 10:20:26');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exchange_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `exchange_id` (`exchange_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`exchange_id`) REFERENCES `exchanges` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,2,5,'Alice was very helpful with coding!','2025-12-14 10:20:16'),(2,5,10,5,'I had an amazing time working with this contract, very seamless and delivered before time','2025-12-31 16:26:47');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,1,'Coding Help','I can help with Python, JavaScript, and HTML/CSS.','Coding','2025-12-14 10:19:04'),(2,2,'Graphic Design','I can design posters and social media graphics.','Drawing','2025-12-14 10:19:04'),(3,3,'Math Tutoring','I can tutor calculus and linear algebra.','Mathematics','2025-12-14 10:19:04'),(7,2,'Language Tutoring','I can teach English, Spanish, or French basics.','Languages','2025-12-14 13:00:32'),(8,3,'Note Summarizing','I can summarize lecture notes and create study guides.','Academics','2025-12-14 13:00:32'),(9,10,'Presentation Skills','I can help with public speaking and slide preparation.','Presentation','2025-12-14 13:00:32'),(10,1,'Cooking','I can teach simple meals, baking, and healthy cooking.','Cooking','2025-12-14 13:00:40'),(11,2,'Hair Styling','I can do haircuts, braiding, and styling for events.','Hair','2025-12-14 13:00:40'),(12,3,'CV & Resume Help','I can help you write and polish CVs and cover letters.','Resume','2025-12-14 13:00:40'),(13,10,'Networking Tips','I can guide you on professional networking and LinkedIn usage.','Life Skills','2025-12-14 13:00:40'),(14,1,'Phone & Laptop Repair','I can fix common hardware and software issues.','Repairs','2025-12-14 13:00:40'),(15,1,'Graphic Design','I can create posters, social media graphics, and logos.','Graphic Design','2025-12-14 13:00:49'),(16,2,'Photography','I can help with taking and editing photos.','Photography','2025-12-14 13:00:49'),(17,3,'Video Editing','I can edit videos for YouTube, projects, or presentations.','Video Editing','2025-12-14 13:00:49'),(18,10,'Music Production','I can create beats, mix, and edit audio.','Music','2025-12-14 13:00:49'),(19,1,'Math Tutoring','I can tutor calculus, algebra, and statistics.','Mathematics','2025-12-14 13:00:59'),(20,2,'Physics Tutoring','I can help with mechanics, electricity, and magnetism.','Physics','2025-12-14 13:00:59'),(21,3,'Chemistry Tutoring','I can assist with organic and inorganic chemistry topics.','Chemistry','2025-12-14 13:00:59'),(22,10,'Essay Writing','I can help you structure essays, edit, and improve clarity.','Writing','2025-12-14 13:00:59'),(23,1,'Python Programming','I can help you with Python projects, scripts, and debugging.','coding','2025-12-14 13:01:10'),(24,2,'Web Development','I can help with HTML, CSS, and JavaScript projects.','Web Developing','2025-12-14 13:01:10'),(25,3,'App Development','I can assist with Android and iOS app basics.','Web Developing','2025-12-14 13:01:10'),(26,10,'Computer Repair','I can troubleshoot and repair PCs and laptops.','Repairs','2025-12-14 13:01:10'),(27,10,'Time Management Coaching','I can help you plan yout schedule snd improve productivity','Time','2025-12-14 13:05:40');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alice','alice@gmail.com','$2y$10$jHZpMhd2VGpa7.4H8XE5h.H7oJO4AlFKjqS64DTYVEY6n/rUf7rxq','2025-12-14 10:19:04'),(2,'Bob','bob@gmail.com','$2y$10$LjoL7LmSEw3xwQqGg0d8muwsMfOXFbpHWUl17XKggZv.bZMv3l7G2','2025-12-14 10:19:04'),(3,'Charlie','charlie@gmail.com','$2y$10$X/Gee1uecY44xe//gJiype05pfuvzJGePCoa6z.8cu8/OEbpRd7ym','2025-12-14 10:19:04'),(10,'Mark','kiritim48@gmail.com','$2y$12$ACbac/wWwanNq0CV/4ayqebFgSjVGp.JCp1Cj8mRzjwdT5UWpqiQ2','2025-12-14 10:21:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-31 19:58:20
