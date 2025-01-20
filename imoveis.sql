-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 20/01/2025 às 01:26
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `imoveis`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `CD_CLIENTE` int(11) NOT NULL,
  `NOME` varchar(90) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `TELEFONE` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`CD_CLIENTE`, `NOME`, `CPF`, `TELEFONE`) VALUES
(27, 'Mariana Souza Oliveira', '22023344556', '21923456781'),
(28, 'Felipe Gomes Costa', '33034455667', '(31) 93456-7890'),
(29, 'Isabela Pereira Santos', '44045566778', '(41) 94567-8901'),
(30, 'Eduardo Oliveira Lima', '55056677889', '(51) 95678-9012'),
(31, 'Laura Martins Silva', '66067788990', '(61) 96789-0123'),
(33, 'Ana Carolina Almeida', '88089900112', '(81) 98901-2345'),
(34, 'João Paulo Ferreira', '99090011223', '(91) 99012-3456'),
(35, 'Viviane Rocha Silva', '10101122334', '(31) 10023-4567'),
(36, 'Thiago Costa Lima', '11112233445', '(41) 11134-5678'),
(37, 'Mariana Alves Barbosa', '12123344556', '(51) 12245-6789'),
(38, 'Ricardo Silva Souza', '13134455667', '(61) 13356-7890'),
(39, 'Bruna Pereira Costa', '14145566778', '71144678902'),
(40, 'Felipe Souza Rocha', '15156677889', '(81) 15578-9012'),
(41, 'Jessica Oliveira Lima', '16167788990', '(91) 16689-0123'),
(43, 'Gabriela Costa Almeida', '18189900112', '(41) 18801-2345'),
(44, 'Daniela Ferreira Barbosa', '19190011223', '(51) 19912-3456'),
(45, 'Ricardo Lima Souza', '20201122334', '(61) 20023-4567');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imovel`
--

CREATE TABLE `imovel` (
  `CD_IMOVEL` int(11) NOT NULL,
  `DT_CADASTRO` timestamp NOT NULL DEFAULT current_timestamp(),
  `DESCRICAO` text NOT NULL,
  `LOCALIZACAO` varchar(150) NOT NULL,
  `VALOR` double NOT NULL,
  `SITUACAO` tinyint(2) NOT NULL DEFAULT 1,
  `CD_CLIENTE` int(11) DEFAULT NULL,
  `DT_VENDA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imovel`
--

INSERT INTO `imovel` (`CD_IMOVEL`, `DT_CADASTRO`, `DESCRICAO`, `LOCALIZACAO`, `VALOR`, `SITUACAO`, `CD_CLIENTE`, `DT_VENDA`) VALUES
(44, '2025-01-12 17:59:21', 'Casa com 3 quartos e quintal grande para lazer', 'Rua dos Eucaliptos, 250, Salvador', 123123, 1, 39, '2024-12-17 17:52:39'),
(46, '2025-01-12 17:59:21', 'Cobertura de 2 andares com 4 quartos e piscina', 'Avenida das Américas, 1001, Rio de Janeiro', 2500000, 2, 34, '2025-02-07 17:52:39'),
(47, '2025-01-12 17:59:21', 'Casa de campo com 5 quartos e área de lazer completa', 'Estrada do Café, 1800, Campinas', 158000, 2, 44, '2024-09-10 17:52:39'),
(48, '2025-01-12 17:59:21', 'Apartamento de luxo com 2 quartos e área de lazer exclusiva', 'Rua das Palmeiras, 208, São Paulo', 950000, 2, 36, '2025-01-17 23:49:03'),
(53, '2024-06-03 03:00:00', 'Apartamento de 3 quartos, 2 banheiros, com varanda e garagem.', 'Bairro Bom Fim, Porto Alegre', 200050, 3, NULL, '2024-06-20 00:00:00'),
(54, '2024-06-05 03:00:00', 'Casa de 4 quartos, ampla sala e área de lazer.', 'Bairro Vila Ipiranga, Porto Alegre', 450000, 1, NULL, '2024-06-22 00:00:00'),
(55, '2024-06-10 03:00:00', 'Apartamento compacto de 1 quarto, ideal para solteiros.', 'Bairro Menino Deus, Porto Alegre', 150000, 1, NULL, '2024-06-25 00:00:00'),
(56, '2024-06-15 03:00:00', 'Casa com 3 quartos, cozinha ampla e quintal.', 'Bairro Glória, Porto Alegre', 280000, 2, 37, '2025-01-17 23:48:57'),
(57, '2024-06-18 03:00:00', 'Apartamento de 2 quartos, cozinha americana e varanda.', 'Bairro Santana, Porto Alegre', 200000, 2, 39, '2025-01-17 23:48:42'),
(58, '2024-06-20 03:00:00', 'Imóvel de luxo, 5 quartos, piscina e churrasqueira.', 'Bairro Petrópolis, Porto Alegre', 1200000, 1, NULL, '2024-07-05 00:00:00'),
(59, '2024-06-25 03:00:00', 'Apartamento com 2 quartos, 1 banheiro e área de lazer.', 'Bairro Mário Quintana, Porto Alegre', 180000, 2, 33, '2025-01-17 23:48:51'),
(60, '2024-06-30 03:00:00', 'Casa com 3 quartos e garagem para 2 carros.', 'Bairro Auxiliadora, Porto Alegre', 320000, 2, 34, '2025-01-17 23:48:37'),
(61, '2024-07-02 03:00:00', 'Sobrado com 4 quartos e sala ampla.', 'Bairro São João, Porto Alegre', 400000, 1, NULL, '2024-07-20 00:00:00'),
(62, '2024-07-05 03:00:00', 'Apartamento de 3 quartos, 2 banheiros, cozinha equipada.', 'Bairro Bom Fim, Porto Alegre', 350000, 1, 34, '2024-07-25 00:00:00'),
(63, '2024-07-08 03:00:00', 'Casa de campo com 5 quartos e piscina.', 'Bairro Belém Novo, Porto Alegre', 900000, 3, NULL, '2024-07-30 00:00:00'),
(64, '2024-07-12 03:00:00', 'Apartamento no centro, 2 quartos e área de serviço.', 'Centro Histórico, Porto Alegre', 220000, 1, NULL, '2024-08-02 00:00:00'),
(65, '2024-07-15 03:00:00', 'Casa grande com 3 quartos e quintal.', 'Bairro Boa Vista, Porto Alegre', 350000, 1, NULL, '2024-08-05 00:00:00'),
(66, '2024-07-18 03:00:00', 'Apartamento novo com 2 quartos e 1 banheiro.', 'Bairro Tristeza, Porto Alegre', 240000, 3, NULL, '2024-08-10 00:00:00'),
(67, '2024-07-22 03:00:00', 'Imóvel comercial, ideal para loja ou escritório.', 'Bairro Rio Branco, Porto Alegre', 500000, 2, 38, '2025-01-17 23:49:55'),
(68, '2024-07-25 03:00:00', 'Casa de 2 andares com 4 quartos e jardim.', 'Bairro Camaquã, Porto Alegre', 460000, 2, 33, '2025-01-19 16:20:26'),
(69, '2024-07-30 03:00:00', 'Apartamento com 1 quarto, ideal para casal.', 'Bairro Partenon, Porto Alegre', 180000, 2, 40, '2025-01-19 16:20:00'),
(70, '2024-08-02 03:00:00', 'Casa de campo, 4 quartos e grande área externa.', 'Bairro Lomba do Pinheiro, Porto Alegre', 750000, 2, 36, '2025-01-17 23:50:01'),
(71, '2024-08-05 03:00:00', 'Apartamento com 2 quartos, bem localizado e amplo.', 'Bairro Ipanema, Porto Alegre', 270000, 2, 34, '2025-01-17 23:50:11'),
(72, '2024-08-08 03:00:00', 'Sobrado de luxo, 3 quartos e espaço gourmet.', 'Bairro Jardim Botânico, Porto Alegre', 600000, 2, 41, '2025-01-19 16:17:58'),
(73, '2024-08-12 03:00:00', 'Apartamento novo, 2 quartos e varanda.', 'Bairro São Sebastião, Porto Alegre', 250000, 2, 40, '2025-01-18 22:07:10'),
(74, '2024-08-15 03:00:00', 'Casa espaçosa com 3 quartos e 2 banheiros.', 'Bairro Vila São José, Porto Alegre', 300000, 2, 33, '2025-01-18 22:05:30'),
(75, '2024-08-20 03:00:00', 'Imóvel para investimento, com 2 apartamentos.', 'Bairro Cruzeiro, Porto Alegre', 550000, 2, 35, '2025-01-17 23:50:06'),
(76, '2024-08-25 03:00:00', 'Apartamento com 1 quarto e ótima localização.', 'Bairro Azenha, Porto Alegre', 180000, 2, 39, '2025-01-18 19:43:24'),
(77, '2024-08-28 03:00:00', 'Casa de 4 quartos e piscina.', 'Bairro Higienópolis, Porto Alegre', 700000, 1, NULL, '2024-10-05 00:00:00'),
(78, '2024-09-02 03:00:00', 'Apartamento de 2 quartos com 1 banheiro.', 'Bairro Bela Vista, Porto Alegre', 210000, 1, NULL, '2024-10-10 00:00:00'),
(79, '2024-09-05 03:00:00', 'Casa com 3 quartos e escritório.', 'Bairro São Geraldo, Porto Alegre', 350000, 1, NULL, '2024-10-15 00:00:00'),
(80, '2024-09-08 03:00:00', 'Imóvel comercial com grande espaço.', 'Bairro Bom Jesus, Porto Alegre', 800000, 1, NULL, '2024-10-20 00:00:00'),
(81, '2024-09-12 03:00:00', 'Apartamento de 3 quartos e 2 banheiros.', 'Bairro Santa Teresa, Porto Alegre', 380000, 3, NULL, '2024-10-25 00:00:00'),
(82, '2024-09-15 03:00:00', 'Casa com 2 quartos e quintal.', 'Bairro Lomba do Pinheiro, Porto Alegre', 220000, 3, NULL, '2024-10-30 00:00:00'),
(83, '2024-09-18 03:00:00', 'Apartamento compacto de 1 quarto.', 'Bairro Teresópolis, Porto Alegre', 140000, 1, NULL, '2024-11-05 00:00:00'),
(84, '2024-09-22 03:00:00', 'Sobrado com 4 quartos e jardim.', 'Bairro Petrópolis, Porto Alegre', 500000, 1, NULL, '2024-11-10 00:00:00'),
(85, '2024-09-25 03:00:00', 'Imóvel de luxo, 6 quartos e piscina.', 'Bairro Jardim Planalto, Porto Alegre', 1500000, 1, NULL, '2024-11-15 00:00:00'),
(86, '2024-09-30 03:00:00', 'Apartamento de 2 quartos e 1 banheiro.', 'Bairro Navegantes, Porto Alegre', 200000, 1, NULL, '2024-11-20 00:00:00'),
(87, '2024-10-02 03:00:00', 'Casa com 5 quartos e grande área externa.', 'Bairro Vila Nova, Porto Alegre', 950000, 3, NULL, '2024-11-25 00:00:00'),
(88, '2024-10-05 03:00:00', 'Apartamento novo, 3 quartos e 2 banheiros.', 'Bairro Hípica, Porto Alegre', 370000, 1, NULL, '2024-12-01 00:00:00'),
(89, '2024-10-08 03:00:00', 'Imóvel para investidores, 2 apartamentos.', 'Bairro Glória, Porto Alegre', 620000, 3, NULL, '2024-12-05 00:00:00'),
(90, '2024-10-12 03:00:00', 'Casa de campo, 3 quartos e grande área.', 'Bairro Camaquã, Porto Alegre', 800000, 3, NULL, '2024-12-10 00:00:00'),
(91, '2024-10-15 03:00:00', 'Apartamento de 2 quartos e área de lazer.', 'Bairro São João, Porto Alegre', 250000, 3, NULL, '2024-12-15 00:00:00'),
(92, '2024-10-18 03:00:00', 'Casa com 4 quartos e garagem para 3 carros.', 'Bairro Teresópolis, Porto Alegre', 450000, 3, NULL, '2024-12-20 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `CD_USUARIO` int(11) NOT NULL,
  `USUARIO` varchar(25) NOT NULL,
  `NOME` varchar(90) NOT NULL,
  `GRUPO` char(1) NOT NULL DEFAULT 'U',
  `SENHA` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`CD_USUARIO`, `USUARIO`, `NOME`, `GRUPO`, `SENHA`) VALUES
(1, 'dossantos', 'João Pedro', 'C', '123'),
(2, 'admin', 'Manda Chuva', 'C', 'admin'),
(44, 'peterjohnson', 'Peter Johnson', 'F', '123'),
(45, 'lucasgarcia', 'Lucas Garcia', 'C', '123'),
(46, 'emilybrown', 'Emily Brown', 'A', '123'),
(47, 'danielmartinez', 'Daniel Martinez', 'V', '123'),
(48, 'oliviawilliams', 'Olivia Williams', 'F', '123'),
(49, 'jameslee', 'James Lee', 'C', '123'),
(50, 'sophiaanderson', 'Sophia Anderson', 'A', '123'),
(51, 'matthewdavis', 'Matthew Davis', 'V', '123'),
(52, 'isabellacarter', 'Isabella Carter', 'F', '123'),
(53, 'noahwilson', 'Noah Wilson', 'C', '123'),
(55, 'ethangreen', 'Ethan Green', 'V', '123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`CD_CLIENTE`);

--
-- Índices de tabela `imovel`
--
ALTER TABLE `imovel`
  ADD PRIMARY KEY (`CD_IMOVEL`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`CD_USUARIO`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `CD_CLIENTE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `imovel`
--
ALTER TABLE `imovel`
  MODIFY `CD_IMOVEL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `CD_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
