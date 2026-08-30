/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for Linux (x86_64)
--
-- Host: db    Database: clinica
-- ------------------------------------------------------
-- Server version	8.4.10

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
-- Table structure for table `assinaturas`
--

DROP TABLE IF EXISTS `assinaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `assinaturas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `clinica_id` bigint unsigned NOT NULL,
  `plano_id` bigint unsigned NOT NULL,
  `status` enum('trial','ativa','inadimplente','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'trial',
  `trial_ends_at` datetime DEFAULT NULL,
  `proxima_cobranca` datetime DEFAULT NULL,
  `gateway` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'asaas',
  `subscription_gateway_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assinaturas_clinica_id_foreign` (`clinica_id`),
  KEY `assinaturas_plano_id_foreign` (`plano_id`),
  CONSTRAINT `assinaturas_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assinaturas_plano_id_foreign` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assinaturas`
--

LOCK TABLES `assinaturas` WRITE;
/*!40000 ALTER TABLE `assinaturas` DISABLE KEYS */;
INSERT INTO `assinaturas` VALUES
(1,11,2,'ativa',NULL,'2026-09-29 03:41:48','asaas',NULL,'2026-08-30 03:41:48','2026-08-30 03:41:48');
/*!40000 ALTER TABLE `assinaturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES
('clinica-vida-saudavel-cache-3d0f267abf77adda8bbc74034f4a598b78a08517','i:1;',1788061429),
('clinica-vida-saudavel-cache-3d0f267abf77adda8bbc74034f4a598b78a08517:timer','i:1788061429;',1788061429);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinicas`
--

DROP TABLE IF EXISTS `clinicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clinicas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnpj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cor_primaria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '#059669',
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clinicas_cnpj_unique` (`cnpj`),
  UNIQUE KEY `clinicas_slug_unique` (`slug`),
  UNIQUE KEY `clinicas_custom_domain_unique` (`custom_domain`),
  KEY `clinicas_user_id_foreign` (`user_id`),
  CONSTRAINT `clinicas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinicas`
--

LOCK TABLES `clinicas` WRITE;
/*!40000 ALTER TABLE `clinicas` DISABLE KEYS */;
INSERT INTO `clinicas` VALUES
(11,'Clínica Vida Saudável','Av. Paulista, 1000 - Bela Vista, São Paulo - SP','11999998888','12.345.678/0001-99','clinica-vida-saudavel','agendar.clinicadasilva.com.br','#9141ac','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkVexxzbg3jvRGCioSPljjTfsjn7CWC45h3L40QZwXjQ&s=10','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkVexxzbg3jvRGCioSPljjTfsjn7CWC45h3L40QZwXjQ&s=10','Atendimento médico especializado de alta qualidade com agendamento e suporte humanizado.',15,'2026-08-30 03:41:48','2026-08-30 04:15:09');
/*!40000 ALTER TABLE `clinicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data_hora_inicio` datetime NOT NULL,
  `data_hora_fim` datetime DEFAULT NULL,
  `valor` decimal(8,2) NOT NULL,
  `clinica_id` bigint unsigned NOT NULL,
  `medico_id` bigint unsigned NOT NULL,
  `paciente_id` bigint unsigned NOT NULL,
  `convenio_id` bigint unsigned DEFAULT NULL,
  `status` enum('agendada','confirmada','realizada','cancelada','faltou') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'agendada',
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `pago` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultas_clinica_id_foreign` (`clinica_id`),
  KEY `consultas_medico_id_foreign` (`medico_id`),
  KEY `consultas_paciente_id_foreign` (`paciente_id`),
  KEY `consultas_convenio_id_foreign` (`convenio_id`),
  CONSTRAINT `consultas_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `consultas_convenio_id_foreign` FOREIGN KEY (`convenio_id`) REFERENCES `convenios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `consultas_medico_id_foreign` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `consultas_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `convenio_paciente`
--

DROP TABLE IF EXISTS `convenio_paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `convenio_paciente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `clinica_id` bigint unsigned NOT NULL,
  `paciente_id` bigint unsigned NOT NULL,
  `convenio_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `convenio_paciente_paciente_id_convenio_id_clinica_id_unique` (`paciente_id`,`convenio_id`,`clinica_id`),
  KEY `convenio_paciente_clinica_id_foreign` (`clinica_id`),
  KEY `convenio_paciente_convenio_id_foreign` (`convenio_id`),
  CONSTRAINT `convenio_paciente_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `convenio_paciente_convenio_id_foreign` FOREIGN KEY (`convenio_id`) REFERENCES `convenios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `convenio_paciente_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `convenio_paciente`
--

LOCK TABLES `convenio_paciente` WRITE;
/*!40000 ALTER TABLE `convenio_paciente` DISABLE KEYS */;
/*!40000 ALTER TABLE `convenio_paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `convenios`
--

DROP TABLE IF EXISTS `convenios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `convenios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentual_desconto` decimal(5,2) NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clinica_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `convenios_codigo_clinica_id_unique` (`codigo`,`clinica_id`),
  KEY `convenios_clinica_id_foreign` (`clinica_id`),
  CONSTRAINT `convenios_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `convenios`
--

LOCK TABLES `convenios` WRITE;
/*!40000 ALTER TABLE `convenios` DISABLE KEYS */;
/*!40000 ALTER TABLE `convenios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidades`
--

DROP TABLE IF EXISTS `especialidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `especialidades_nome_unique` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades`
--

LOCK TABLES `especialidades` WRITE;
/*!40000 ALTER TABLE `especialidades` DISABLE KEYS */;
INSERT INTO `especialidades` VALUES
(2,'Clínica Geral','2026-08-30 03:41:49','2026-08-30 03:41:49');
/*!40000 ALTER TABLE `especialidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faturas`
--

DROP TABLE IF EXISTS `faturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `faturas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `assinatura_id` bigint unsigned NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status` enum('pendente','paga','vencida','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendente',
  `data_vencimento` datetime NOT NULL,
  `data_pagamento` datetime DEFAULT NULL,
  `pdf_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pix_qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faturas_assinatura_id_foreign` (`assinatura_id`),
  CONSTRAINT `faturas_assinatura_id_foreign` FOREIGN KEY (`assinatura_id`) REFERENCES `assinaturas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faturas`
--

LOCK TABLES `faturas` WRITE;
/*!40000 ALTER TABLE `faturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `faturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicos`
--

DROP TABLE IF EXISTS `medicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtd_consultas` int NOT NULL DEFAULT '0',
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clinica_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `especialidade_id` bigint unsigned NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fim` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicos_crm_clinica_id_unique` (`crm`,`clinica_id`),
  KEY `medicos_clinica_id_foreign` (`clinica_id`),
  KEY `medicos_user_id_foreign` (`user_id`),
  KEY `medicos_especialidade_id_foreign` (`especialidade_id`),
  CONSTRAINT `medicos_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medicos_especialidade_id_foreign` FOREIGN KEY (`especialidade_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medicos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicos`
--

LOCK TABLES `medicos` WRITE;
/*!40000 ALTER TABLE `medicos` DISABLE KEYS */;
INSERT INTO `medicos` VALUES
(2,'Dr. Carlos Silva','CRM/SP 123456',0,'11977776666',11,17,2,'08:00:00','18:00:00','2026-08-30 03:41:49','2026-08-30 03:41:49');
/*!40000 ALTER TABLE `medicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_02_24_204933_create_pacientes_table',1),
(5,'2026_03_05_233950_add_qtd_consultas_in_medicos',1),
(6,'2026_04_01_000713_alter_pago_consultas',1),
(7,'2026_04_02_175226_create_system_log_table',1),
(8,'2026_04_02_194725_alter_entidade_system_log',1),
(9,'2026_04_30_231611_alter_status_consultas',1),
(10,'2026_05_01_000000_create_whatsapp_instancias_table',1),
(11,'2026_05_02_000000_create_saas_billing_tables',1),
(12,'2026_08_30_030000_add_slug_and_domain_to_clinicas_table',1),
(13,'2026_08_30_031529_add_customization_and_phone_fields',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pacientes`
--

DROP TABLE IF EXISTS `pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pacientes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `clinica_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pacientes_cpf_clinica_id_unique` (`cpf`,`clinica_id`),
  KEY `pacientes_clinica_id_foreign` (`clinica_id`),
  CONSTRAINT `pacientes_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pacientes`
--

LOCK TABLES `pacientes` WRITE;
/*!40000 ALTER TABLE `pacientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `pacientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planos`
--

DROP TABLE IF EXISTS `planos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `planos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `preco_mensal` decimal(10,2) NOT NULL,
  `max_medicos` int NOT NULL DEFAULT '1',
  `max_recepcionistas` int NOT NULL DEFAULT '2',
  `max_consultas_mes` int NOT NULL DEFAULT '100',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `planos_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planos`
--

LOCK TABLES `planos` WRITE;
/*!40000 ALTER TABLE `planos` DISABLE KEYS */;
INSERT INTO `planos` VALUES
(1,'Starter','starter','Para consultórios individuais',149.00,1,1,100,1,'2026-08-30 03:41:47','2026-08-30 03:42:11'),
(2,'Clínica Pro','pro','Para clínicas em crescimento',299.00,5,3,9999,1,'2026-08-30 03:41:47','2026-08-30 03:42:11'),
(3,'Enterprise','enterprise','Para redes e centros médicos',599.00,999,999,99999,1,'2026-08-30 03:41:47','2026-08-30 03:42:11');
/*!40000 ALTER TABLE `planos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('Akfo8NWfBp8JQdjZmrYY79CdmFrV864JuPreAoEl',15,'192.168.96.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZHduZ01jcG1kdGd1WWF2Q3dKd3FpNVlDdXNtdENoMEY5NVdaVU9OdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MC9tZSI7czo1OiJyb3V0ZSI7czoyOiJtZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE1O30=',1788063309),
('GIahn2zaeBImde1QvbTp72NcB1Zuyuog4cd6HLhw',NULL,'127.0.0.1','Symfony','YTozOntzOjY6Il90b2tlbiI7czo0MDoib3NwR3ZiU21QVTlqb29PMXhoWGVvMVN3ZzAwajh2anZPOGoyeG1yTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MCI7czo1OiJyb3V0ZSI7czo1OiJpbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1788061213);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_log`
--

DROP TABLE IF EXISTS `system_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `tipo_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entidade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entidade_id` bigint unsigned DEFAULT NULL,
  `rota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metodo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dados_anteriores` text COLLATE utf8mb4_unicode_ci,
  `dados_novos` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `system_log_user_id_foreign` (`user_id`),
  CONSTRAINT `system_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_log`
--

LOCK TABLES `system_log` WRITE;
/*!40000 ALTER TABLE `system_log` DISABLE KEYS */;
INSERT INTO `system_log` VALUES
(41,'2026-08-30 03:41:47','2026-08-30 03:41:47',NULL,NULL,'CREATE','Plano',1,'/','GET',NULL,'{\"id\":1,\"nome\":\"Starter\",\"slug\":\"starter\",\"descricao\":\"Para consult\\u00f3rios individuais\",\"preco_mensal\":149,\"max_medicos\":1,\"max_recepcionistas\":1,\"max_consultas_mes\":100,\"ativo\":true,\"updated_at\":\"2026-08-30 03:41:47\",\"created_at\":\"2026-08-30 03:41:47\"}','127.0.0.1','Symfony','2026-08-30 03:41:47'),
(42,'2026-08-30 03:41:47','2026-08-30 03:41:47',NULL,NULL,'CREATE','Plano',2,'/','GET',NULL,'{\"id\":2,\"nome\":\"Cl\\u00ednica Pro\",\"slug\":\"pro\",\"descricao\":\"Para cl\\u00ednicas em crescimento\",\"preco_mensal\":299,\"max_medicos\":5,\"max_recepcionistas\":3,\"max_consultas_mes\":9999,\"ativo\":true,\"updated_at\":\"2026-08-30 03:41:47\",\"created_at\":\"2026-08-30 03:41:47\"}','127.0.0.1','Symfony','2026-08-30 03:41:47'),
(43,'2026-08-30 03:41:47','2026-08-30 03:41:47',NULL,NULL,'CREATE','Plano',3,'/','GET',NULL,'{\"id\":3,\"nome\":\"Enterprise\",\"slug\":\"enterprise\",\"descricao\":\"Para redes e centros m\\u00e9dicos\",\"preco_mensal\":599,\"max_medicos\":999,\"max_recepcionistas\":999,\"max_consultas_mes\":99999,\"ativo\":true,\"updated_at\":\"2026-08-30 03:41:47\",\"created_at\":\"2026-08-30 03:41:47\"}','127.0.0.1','Symfony','2026-08-30 03:41:47'),
(44,'2026-08-30 03:41:48','2026-08-30 03:41:48',NULL,NULL,'CREATE','User',15,'/','GET',NULL,'{\"email\":\"admin@clinica.com\",\"name\":\"Administrador da Cl\\u00ednica\",\"password\":\"$2y$12$AQKnCxSic0u5Em\\/0qKBnMul\\/UKkItGgWgrPNEtbinHBiYG4P5fyyW\",\"role\":\"admin\",\"telefone\":\"11999998888\",\"updated_at\":\"2026-08-30 03:41:48\",\"created_at\":\"2026-08-30 03:41:48\",\"id\":15}','127.0.0.1','Symfony','2026-08-30 03:41:48'),
(45,'2026-08-30 03:41:48','2026-08-30 03:41:48',NULL,NULL,'CREATE','Clinica',11,'/','GET',NULL,'{\"user_id\":15,\"nome\":\"Cl\\u00ednica Vida Saud\\u00e1vel\",\"endereco\":\"Av. Paulista, 1000 - Bela Vista, S\\u00e3o Paulo - SP\",\"telefone\":\"11999998888\",\"cnpj\":\"12.345.678\\/0001-99\",\"slug\":\"clinica-vida-saudavel\",\"cor_primaria\":\"#059669\",\"descricao\":\"Atendimento m\\u00e9dico especializado de alta qualidade com agendamento e suporte humanizado.\",\"updated_at\":\"2026-08-30 03:41:48\",\"created_at\":\"2026-08-30 03:41:48\",\"id\":11}','127.0.0.1','Symfony','2026-08-30 03:41:48'),
(46,'2026-08-30 03:41:48','2026-08-30 03:41:48',NULL,NULL,'UPDATE','User',15,'/','GET','{\"email\":\"admin@clinica.com\",\"name\":\"Administrador da Cl\\u00ednica\",\"password\":\"$2y$12$AQKnCxSic0u5Em\\/0qKBnMul\\/UKkItGgWgrPNEtbinHBiYG4P5fyyW\",\"role\":\"admin\",\"telefone\":\"11999998888\",\"updated_at\":\"2026-08-30T03:41:48.000000Z\",\"created_at\":\"2026-08-30T03:41:48.000000Z\",\"id\":15}','{\"clinica_id\":11}','127.0.0.1','Symfony','2026-08-30 03:41:48'),
(47,'2026-08-30 03:41:48','2026-08-30 03:41:48',NULL,NULL,'CREATE','Assinatura',1,'/','GET',NULL,'{\"clinica_id\":11,\"plano_id\":2,\"status\":\"ativa\",\"proxima_cobranca\":\"2026-09-29T03:41:48.083820Z\",\"gateway\":\"asaas\",\"updated_at\":\"2026-08-30 03:41:48\",\"created_at\":\"2026-08-30 03:41:48\",\"id\":1}','127.0.0.1','Symfony','2026-08-30 03:41:48'),
(48,'2026-08-30 03:41:48','2026-08-30 03:41:48',NULL,NULL,'CREATE','User',16,'/','GET',NULL,'{\"email\":\"recepcao@clinica.com\",\"name\":\"Mariana Recepcionista\",\"password\":\"$2y$12$B3SRcfIeG19hXhanRQGpJuQKBMJV87rP3u2wHUJpzNTzXhsopHrlO\",\"role\":\"recepcionista\",\"telefone\":\"11988887777\",\"clinica_id\":11,\"updated_at\":\"2026-08-30 03:41:48\",\"created_at\":\"2026-08-30 03:41:48\",\"id\":16}','127.0.0.1','Symfony','2026-08-30 03:41:48'),
(49,'2026-08-30 03:41:49','2026-08-30 03:41:49',NULL,NULL,'CREATE','User',17,'/','GET',NULL,'{\"email\":\"medico@clinica.com\",\"name\":\"Dr. Carlos Silva\",\"password\":\"$2y$12$7VkHuSQa4Qft1TekWIr5p.pN6TmqjffijNAIa2o2z1K6QoK3rQs5u\",\"role\":\"medico\",\"telefone\":\"11977776666\",\"clinica_id\":11,\"updated_at\":\"2026-08-30 03:41:49\",\"created_at\":\"2026-08-30 03:41:49\",\"id\":17}','127.0.0.1','Symfony','2026-08-30 03:41:49'),
(50,'2026-08-30 03:41:49','2026-08-30 03:41:49',NULL,NULL,'CREATE','Especialidade',2,'/','GET',NULL,'{\"nome\":\"Cl\\u00ednica Geral\",\"updated_at\":\"2026-08-30 03:41:49\",\"created_at\":\"2026-08-30 03:41:49\",\"id\":2}','127.0.0.1','Symfony','2026-08-30 03:41:49'),
(51,'2026-08-30 03:41:49','2026-08-30 03:41:49',NULL,NULL,'CREATE','Medico',2,'/','GET',NULL,'{\"user_id\":17,\"clinica_id\":11,\"especialidade_id\":2,\"nome\":\"Dr. Carlos Silva\",\"crm\":\"CRM\\/SP 123456\",\"telefone\":\"11977776666\",\"horario_inicio\":\"08:00\",\"horario_fim\":\"18:00\",\"updated_at\":\"2026-08-30 03:41:49\",\"created_at\":\"2026-08-30 03:41:49\",\"id\":2}','127.0.0.1','Symfony','2026-08-30 03:41:49'),
(52,'2026-08-30 03:42:11','2026-08-30 03:42:11',NULL,NULL,'UPDATE','Plano',1,'/','GET','{\"id\":1,\"nome\":\"Starter\",\"slug\":\"starter\",\"descricao\":\"Para consult\\u00f3rios individuais\",\"preco_mensal\":\"149.00\",\"max_medicos\":1,\"max_recepcionistas\":1,\"max_consultas_mes\":100,\"ativo\":1,\"created_at\":\"2026-08-30T03:41:47.000000Z\",\"updated_at\":\"2026-08-30T03:41:47.000000Z\"}','{\"preco_mensal\":149,\"ativo\":true,\"updated_at\":\"2026-08-30 03:42:11\"}','127.0.0.1','Symfony','2026-08-30 03:42:11'),
(53,'2026-08-30 03:42:11','2026-08-30 03:42:11',NULL,NULL,'UPDATE','Plano',2,'/','GET','{\"id\":2,\"nome\":\"Cl\\u00ednica Pro\",\"slug\":\"pro\",\"descricao\":\"Para cl\\u00ednicas em crescimento\",\"preco_mensal\":\"299.00\",\"max_medicos\":5,\"max_recepcionistas\":3,\"max_consultas_mes\":9999,\"ativo\":1,\"created_at\":\"2026-08-30T03:41:47.000000Z\",\"updated_at\":\"2026-08-30T03:41:47.000000Z\"}','{\"preco_mensal\":299,\"ativo\":true,\"updated_at\":\"2026-08-30 03:42:11\"}','127.0.0.1','Symfony','2026-08-30 03:42:11'),
(54,'2026-08-30 03:42:11','2026-08-30 03:42:11',NULL,NULL,'UPDATE','Plano',3,'/','GET','{\"id\":3,\"nome\":\"Enterprise\",\"slug\":\"enterprise\",\"descricao\":\"Para redes e centros m\\u00e9dicos\",\"preco_mensal\":\"599.00\",\"max_medicos\":999,\"max_recepcionistas\":999,\"max_consultas_mes\":99999,\"ativo\":1,\"created_at\":\"2026-08-30T03:41:47.000000Z\",\"updated_at\":\"2026-08-30T03:41:47.000000Z\"}','{\"preco_mensal\":599,\"ativo\":true,\"updated_at\":\"2026-08-30 03:42:11\"}','127.0.0.1','Symfony','2026-08-30 03:42:11'),
(55,'2026-08-30 03:42:50','2026-08-30 03:42:50',15,'admin','CREATE',NULL,NULL,'store_login','POST',NULL,NULL,'192.168.96.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','2026-08-30 03:42:50'),
(56,'2026-08-30 03:43:35','2026-08-30 03:43:35',15,'admin','UPDATE','Clinica',11,'admin/clinica/update','POST','{\"id\":11,\"nome\":\"Cl\\u00ednica Vida Saud\\u00e1vel\",\"endereco\":\"Av. Paulista, 1000 - Bela Vista, S\\u00e3o Paulo - SP\",\"telefone\":\"11999998888\",\"cnpj\":\"12.345.678\\/0001-99\",\"slug\":\"clinica-vida-saudavel\",\"custom_domain\":null,\"cor_primaria\":\"#059669\",\"logo_url\":null,\"banner_url\":null,\"descricao\":\"Atendimento m\\u00e9dico especializado de alta qualidade com agendamento e suporte humanizado.\",\"user_id\":15,\"created_at\":\"2026-08-30T03:41:48.000000Z\",\"updated_at\":\"2026-08-30T03:41:48.000000Z\"}','{\"cor_primaria\":\"#9141ac\",\"logo_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQkVexxzbg3jvRGCioSPljjTfsjn7CWC45h3L40QZwXjQ&s=10\",\"banner_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQkVexxzbg3jvRGCioSPljjTfsjn7CWC45h3L40QZwXjQ&s=10\",\"updated_at\":\"2026-08-30 03:43:35\"}','192.168.96.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','2026-08-30 03:43:35'),
(57,'2026-08-30 03:43:35','2026-08-30 03:43:35',15,'admin','CREATE',NULL,NULL,'admin/clinica/update','POST',NULL,NULL,'192.168.96.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','2026-08-30 03:43:35'),
(58,'2026-08-30 04:12:50','2026-08-30 04:12:50',15,'admin','CREATE','WhatsappInstancia',1,'whatsapp','GET',NULL,'{\"clinica_id\":11,\"instance_id\":\"EVOLUTION_TENANT_11\",\"token\":\"EVOLUTION_APIKEY_2253\",\"client_token\":\"CLIENT_TOKEN_EVOLUTION\",\"status\":\"aguardando_qr\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=260x260&data=EVOLUTION-API-SAAS-EVOLUTION_TENANT_11-ACTIVE\",\"updated_at\":\"2026-08-30 04:12:50\",\"created_at\":\"2026-08-30 04:12:50\",\"id\":1}','192.168.96.1','Mozilla/5.0 (iPad; CPU OS 18_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0 Mobile/15E148 Safari/604.1','2026-08-30 04:12:50'),
(59,'2026-08-30 04:15:09','2026-08-30 04:15:09',15,'admin','UPDATE','Clinica',11,'admin/clinica/update','POST','{\"id\":11,\"nome\":\"Cl\\u00ednica Vida Saud\\u00e1vel\",\"endereco\":\"Av. Paulista, 1000 - Bela Vista, S\\u00e3o Paulo - SP\",\"telefone\":\"11999998888\",\"cnpj\":\"12.345.678\\/0001-99\",\"slug\":\"clinica-vida-saudavel\",\"custom_domain\":null,\"cor_primaria\":\"#9141ac\",\"logo_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQkVexxzbg3jvRGCioSPljjTfsjn7CWC45h3L40QZwXjQ&s=10\",\"banner_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQkVexxzbg3jvRGCioSPljjTfsjn7CWC45h3L40QZwXjQ&s=10\",\"descricao\":\"Atendimento m\\u00e9dico especializado de alta qualidade com agendamento e suporte humanizado.\",\"user_id\":15,\"created_at\":\"2026-08-30T03:41:48.000000Z\",\"updated_at\":\"2026-08-30T03:43:35.000000Z\"}','{\"custom_domain\":\"agendar.clinicadasilva.com.br\",\"updated_at\":\"2026-08-30 04:15:09\"}','192.168.96.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','2026-08-30 04:15:09'),
(60,'2026-08-30 04:15:09','2026-08-30 04:15:09',15,'admin','CREATE',NULL,NULL,'admin/clinica/update','POST',NULL,NULL,'192.168.96.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','2026-08-30 04:15:09');
/*!40000 ALTER TABLE `system_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','medico','recepcionista') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `clinica_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_clinica_id_foreign` (`clinica_id`),
  CONSTRAINT `users_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(15,'Administrador da Clínica','admin@clinica.com','11999998888',NULL,'admin','$2y$12$AQKnCxSic0u5Em/0qKBnMul/UKkItGgWgrPNEtbinHBiYG4P5fyyW',NULL,'2026-08-30 03:41:48','2026-08-30 03:41:48',11),
(16,'Mariana Recepcionista','recepcao@clinica.com','11988887777',NULL,'recepcionista','$2y$12$B3SRcfIeG19hXhanRQGpJuQKBMJV87rP3u2wHUJpzNTzXhsopHrlO',NULL,'2026-08-30 03:41:48','2026-08-30 03:41:48',11),
(17,'Dr. Carlos Silva','medico@clinica.com','11977776666',NULL,'medico','$2y$12$7VkHuSQa4Qft1TekWIr5p.pN6TmqjffijNAIa2o2z1K6QoK3rQs5u',NULL,'2026-08-30 03:41:49','2026-08-30 03:41:49',11);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp_instancias`
--

DROP TABLE IF EXISTS `whatsapp_instancias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_instancias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `clinica_id` bigint unsigned NOT NULL,
  `instance_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('conectado','desconectado','aguardando_qr') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'desconectado',
  `qr_code` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsapp_instancias_clinica_id_foreign` (`clinica_id`),
  CONSTRAINT `whatsapp_instancias_clinica_id_foreign` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_instancias`
--

LOCK TABLES `whatsapp_instancias` WRITE;
/*!40000 ALTER TABLE `whatsapp_instancias` DISABLE KEYS */;
INSERT INTO `whatsapp_instancias` VALUES
(1,11,'EVOLUTION_TENANT_11','EVOLUTION_APIKEY_2253','CLIENT_TOKEN_EVOLUTION','aguardando_qr','https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=EVOLUTION-API-SAAS-EVOLUTION_TENANT_11-ACTIVE','2026-08-30 04:12:50','2026-08-30 04:12:50');
/*!40000 ALTER TABLE `whatsapp_instancias` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-30  4:18:01
