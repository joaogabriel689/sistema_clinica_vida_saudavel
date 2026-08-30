-- Schema inicial e otimizações de tabela para o ambiente multi-tenant
CREATE DATABASE IF NOT EXISTS `clinica`;
CREATE DATABASE IF NOT EXISTS `evolution`;
GRANT ALL PRIVILEGES ON `evolution`.* TO 'clinica_user'@'%';
FLUSH PRIVILEGES;

USE `clinica`;

SELECT 'Banco de dados inicializado com sucesso.' AS status;
