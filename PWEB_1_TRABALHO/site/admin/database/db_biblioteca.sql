
CREATE DATABASE IF NOT EXISTS `db_pweb_pamelapaola_banco`;
USE `db_pweb_pamelapaola_banco`;

CREATE TABLE IF NOT EXISTS `devolucoes` (
  `id` int NOT NULL,
  `emprestimo_id` int NOT NULL DEFAULT '0',
  `data_devolucao` date NOT NULL,
  `observacao` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `emprestimo` (
  `id` int NOT NULL,
  `livro_id` int DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `data_emprestimo` date DEFAULT NULL,
  `data_devolucao` date DEFAULT NULL,
  `multa` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `emprestimo` (`id`, `livro_id`, `usuario_id`, `data_emprestimo`, `data_devolucao`, `multa`) VALUES
	(1781410221, 1781525670, 2, '2026-06-01', '2026-06-15', 0),
	(1781527088, 1781525670, 1, '2026-05-14', '2026-06-15', 85),
	(1781574153, 1781408313, 3, '2026-06-16', '2026-06-16', NULL),
	(1781574187, 1781408313, 3, '2026-06-16', '2026-06-23', NULL);


CREATE TABLE IF NOT EXISTS `livros` (
  `id` int NOT NULL,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `autor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `ano_publicacao` int NOT NULL DEFAULT '0',
  `genero` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `livros` (`id`, `titulo`, `autor`, `ano_publicacao`, `genero`) VALUES
	(1781408313, 'Vingadores 1', 'Vicenzo 3', 0, 'Musical 4'),
	(1781525670, 'Vingadores 2', 'Vicenzo ', 0, 'Musical ');

CREATE TABLE IF NOT EXISTS `multas` (
  `id` int NOT NULL,
  `emprestimo_id` int NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `motivo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int NOT NULL,
  `livro_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `data_reserva` date NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `reservas` (`id`, `livro_id`, `usuario_id`, `data_reserva`, `status`) VALUES
	(4, 1781408313, 3, '2026-06-16', 'pendente'),
	(5, 1781408313, 2, '2026-06-14', 'pendente');

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

INSERT INTO `usuario` (`nome`, `id`, `sobrenome`, `email`, `telefone`, `login`, `senha`) VALUES
	('Administrador', 2, 'adm', 'admin@ifsc.com', '49999999999', 'admin', '123'),
	('pami', 3, 'stieven', 'pami@gmail.com', '00000000000', 'ps', '123');

