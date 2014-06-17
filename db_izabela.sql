-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Máquina: 127.0.0.1
-- Data de Criação: 13-Jun-2014 às 22:40
-- Versão do servidor: 5.5.32
-- versão do PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `izabela`
--
CREATE DATABASE IF NOT EXISTS `izabela` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `izabela`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_avisos`
--

CREATE TABLE IF NOT EXISTS `tbl_avisos` (
  `cod_aviso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `assunto` varchar(255) NOT NULL,
  `remetente` varchar(100) NOT NULL,
  `mensagem` text NOT NULL,
  `lido` tinyint(1) DEFAULT '0',
  `tbl_usuarios_cod_usuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cod_aviso`),
  KEY `tbl_usuarios_cod_usuario` (`tbl_usuarios_cod_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tbl_avisos`
--

INSERT INTO `tbl_avisos` (`cod_aviso`, `assunto`, `remetente`, `mensagem`, `lido`, `tbl_usuarios_cod_usuario`) VALUES
(2, 'Meu nome é', 'Wallace', 'minha mensagem é bonta', 1, 1),
(3, 'Foto reprovada', 'Grupo TMT', 'A sua foto de carteira estudantil foi reprovada! Envie a solicitação novamente.', 1, 1),
(4, 'Solicitação realizada', 'Grupo TMT', 'A sua solicitação de carteira estudantil foi enviada com sucesso! Aguarde pela aprovação de sua foto.', 1, 1),
(5, 'Solicitação realizada', 'Grupo TMT', 'A sua solicitação de carteira estudantil foi enviada com sucesso! Aguarde pela aprovação de sua foto.', 1, 1),
(6, 'Foto aprovada', 'Grupo TMT', 'A sua foto de carteira estudantil foi aprovada!', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_modelos`
--

CREATE TABLE IF NOT EXISTS `tbl_modelos` (
  `cod_modelo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_modelo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `tbl_modelos`
--

INSERT INTO `tbl_modelos` (`cod_modelo`, `titulo`) VALUES
(1, 'Aluno');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_niveis`
--

CREATE TABLE IF NOT EXISTS `tbl_niveis` (
  `cod_nivel` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tbl_niveis`
--

INSERT INTO `tbl_niveis` (`cod_nivel`, `titulo`) VALUES
(1, 'Aluno'),
(2, 'Administrador TMT'),
(3, 'Izabela');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_solicitacoes`
--

CREATE TABLE IF NOT EXISTS `tbl_solicitacoes` (
  `cod_solicitacao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foto` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `via` int(11) NOT NULL DEFAULT '1',
  `tbl_status_cod_status` int(10) unsigned NOT NULL,
  `tbl_modelos_cod_modelo` int(10) unsigned NOT NULL,
  `tbl_usuarios_cod_usuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cod_solicitacao`),
  KEY `tbl_status_cod_status` (`tbl_status_cod_status`),
  KEY `tbl_modelos_cod_modelo` (`tbl_modelos_cod_modelo`),
  KEY `tbl_usuarios_cod_usuario` (`tbl_usuarios_cod_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tbl_solicitacoes`
--

INSERT INTO `tbl_solicitacoes` (`cod_solicitacao`, `foto`, `email`, `via`, `tbl_status_cod_status`, `tbl_modelos_cod_modelo`, `tbl_usuarios_cod_usuario`) VALUES
(3, '111111.jpg', 'cara@sou.eu', 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_status`
--

CREATE TABLE IF NOT EXISTS `tbl_status` (
  `cod_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `tbl_status`
--

INSERT INTO `tbl_status` (`cod_status`, `titulo`) VALUES
(1, 'Análise da foto'),
(2, 'Fabricação'),
(3, 'Conferência'),
(4, 'Disponível para entrega');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_usuarios`
--

CREATE TABLE IF NOT EXISTS `tbl_usuarios` (
  `cod_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `matricula` varchar(14) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `curso` varchar(255) NOT NULL,
  `tbl_niveis_cod_nivel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cod_usuario`),
  KEY `tbl_niveis_cod_nivel` (`tbl_niveis_cod_nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`cod_usuario`, `matricula`, `cpf`, `nome`, `curso`, `tbl_niveis_cod_nivel`) VALUES
(1, '111111', '11111111111', 'Gustavo Carmo', '', 1),
(2, '111122', '11111111122', 'Gustavo Carmo', '', 2),
(13, '222222', '9405098659', 'Wallace de Souza', 'Programador em PHP', 1),
(14, '333333', '9405098659', 'Richard da Silva', 'Desenvolvedor Web', 1);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tbl_avisos`
--
ALTER TABLE `tbl_avisos`
  ADD CONSTRAINT `tbl_avisos_ibfk_1` FOREIGN KEY (`tbl_usuarios_cod_usuario`) REFERENCES `tbl_usuarios` (`cod_usuario`);

--
-- Limitadores para a tabela `tbl_solicitacoes`
--
ALTER TABLE `tbl_solicitacoes`
  ADD CONSTRAINT `tbl_solicitacoes_ibfk_1` FOREIGN KEY (`tbl_status_cod_status`) REFERENCES `tbl_status` (`cod_status`),
  ADD CONSTRAINT `tbl_solicitacoes_ibfk_2` FOREIGN KEY (`tbl_modelos_cod_modelo`) REFERENCES `tbl_modelos` (`cod_modelo`),
  ADD CONSTRAINT `tbl_solicitacoes_ibfk_3` FOREIGN KEY (`tbl_usuarios_cod_usuario`) REFERENCES `tbl_usuarios` (`cod_usuario`);

--
-- Limitadores para a tabela `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`tbl_niveis_cod_nivel`) REFERENCES `tbl_niveis` (`cod_nivel`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
