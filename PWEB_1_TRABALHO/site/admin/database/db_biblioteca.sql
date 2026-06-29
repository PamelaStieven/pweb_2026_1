-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para db_pweb_pamelapaola_banco
CREATE DATABASE IF NOT EXISTS `db_pweb_pamelapaola_banco` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_pweb_pamelapaola_banco`;

-- Copiando estrutura para tabela db_pweb_pamelapaola_banco.devolucoes
CREATE TABLE IF NOT EXISTS `devolucoes` (
  `id` int NOT NULL,
  `emprestimo_id` int NOT NULL DEFAULT '0',
  `data_devolucao` date NOT NULL,
  `observacao` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela db_pweb_pamelapaola_banco.devolucoes: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela db_pweb_pamelapaola_banco.emprestimo
CREATE TABLE IF NOT EXISTS `emprestimo` (
  `id` int NOT NULL,
  `livro_id` int DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `data_emprestimo` date DEFAULT NULL,
  `data_devolucao` date DEFAULT NULL,
  `multa` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela db_pweb_pamelapaola_banco.emprestimo: ~3 rows (aproximadamente)
INSERT INTO `emprestimo` (`id`, `livro_id`, `usuario_id`, `data_emprestimo`, `data_devolucao`, `multa`) VALUES
	(1781574153, 1781576064, 3, '2026-06-16', '2026-06-16', NULL),
	(1782155554, 1782139430, 6, '2026-06-22', '2026-06-22', NULL),
	(1782155612, 1781576064, 4, '2026-06-01', '2026-06-22', NULL);

-- Copiando estrutura para tabela db_pweb_pamelapaola_banco.livros
CREATE TABLE IF NOT EXISTS `livros` (
  `id` int NOT NULL,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `autor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `genero` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela db_pweb_pamelapaola_banco.livros: ~9 rows (aproximadamente)
INSERT INTO `livros` (`id`, `titulo`, `autor`, `genero`) VALUES
	(1781576064, 'Harry Potter', 'J.K. Rolling', 'Fantasia e magia'),
	(1782139315, 'O primeiro a morrer no final', 'Adam Silveira', 'ficção e romance '),
	(1782139336, 'O sobrevivente quer morrer no final', 'Adam Silveira', 'ficção e romance '),
	(1782139385, 'Casas Estranhas', 'Uketsu', 'Mistério e Terror '),
	(1782139402, 'Casas Estranhas 2', 'Uketsu', 'Mistério e Terror '),
	(1782139430, 'Imagens Estranhas', 'Uketsu', 'Mistério e Terror '),
	(1782676426, 'Os dois morrem no final', 'J.K. Rolling', 'Mistério e Terror '),
	(1782743272, 'a cinco passos de você', 'collin hover', 'romance'),
	(1782761779, 'o pequeno principe', 'J.K. Rolling', 'Mistério e Terror ');

-- Copiando estrutura para tabela db_pweb_pamelapaola_banco.multas
CREATE TABLE IF NOT EXISTS `multas` (
  `id` int NOT NULL,
  `emprestimo_id` int NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `motivo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela db_pweb_pamelapaola_banco.multas: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela db_pweb_pamelapaola_banco.reservas
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int NOT NULL,
  `livro_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `data_reserva` date NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela db_pweb_pamelapaola_banco.reservas: ~2 rows (aproximadamente)
INSERT INTO `reservas` (`id`, `livro_id`, `usuario_id`, `data_reserva`, `status`) VALUES
	(6, 1781576064, 3, '2026-06-28', 'pendente'),
	(7, 1782139385, 3, '2026-06-29', 'pendente');

-- Copiando estrutura para tabela db_pweb_pamelapaola_banco.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `nome` varchar(100) NOT NULL DEFAULT '',
  `id` int NOT NULL,
  `sobrenome` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telefone` varchar(100) NOT NULL DEFAULT '',
  `login` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senha` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela db_pweb_pamelapaola_banco.usuario: ~4 rows (aproximadamente)
INSERT INTO `usuario` (`nome`, `id`, `sobrenome`, `email`, `telefone`, `login`, `senha`) VALUES
	('pami', 3, 'stieven', 'pami@gmail.com', '00000000000', 'ps', '123'),
	('Administrador', 4, 'adm', 'adm@gmail.com', '4999999999', 'adm', '123'),
	('Administrador', 5, 'adm', 'admin@ifsc.com', '49999999999', 'admin', '123'),
	('ADM-', 6, 'Administrador', 'adm@gmail.com', '00 0000-0000', 'adm', '123');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
