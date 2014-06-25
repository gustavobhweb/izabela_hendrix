DROP DATABASE IF EXISTS izabela;
CREATE DATABASE izabela;

USE izabela;

CREATE TABLE tbl_avisos(
cod_aviso int(10) unsigned NOT NULL AUTO_INCREMENT,
assunto varchar(255) NOT NULL,
remetente varchar(100) NOT NULL,
mensagem text NOT NULL,
lido tinyint(1) DEFAULT '0',
tbl_usuarios_cod_usuario int(10) unsigned NOT NULL,
PRIMARY KEY (cod_aviso),
KEY tbl_usuarios_cod_usuario (tbl_usuarios_cod_usuario)
);

CREATE TABLE IF NOT EXISTS tbl_modelos (
cod_modelo int(10) unsigned NOT NULL AUTO_INCREMENT,
titulo varchar(100) NOT NULL,
PRIMARY KEY(cod_modelo)
);

INSERT INTO tbl_modelos(cod_modelo, titulo) 
VALUES (1, 'Aluno');

CREATE TABLE IF NOT EXISTS tbl_niveis(
cod_nivel int(10) unsigned NOT NULL AUTO_INCREMENT,
titulo varchar(100) NOT NULL,
PRIMARY KEY (cod_nivel)
);

INSERT INTO tbl_niveis (cod_nivel, titulo) VALUES
(1, 'Aluno'),
(2, 'Administrador TMT'),
(3, 'Izabela');

CREATE TABLE IF NOT EXISTS tbl_solicitacoes(
cod_solicitacao int(10) unsigned NOT NULL AUTO_INCREMENT,
foto varchar(100) NOT NULL,
email varchar(100) NOT NULL,
via int(11) NOT NULL DEFAULT '1',
tbl_status_cod_status int(10) unsigned NOT NULL,
tbl_modelos_cod_modelo int(10) unsigned NOT NULL,
tbl_usuarios_cod_usuario int(10) unsigned NOT NULL,
PRIMARY KEY (cod_solicitacao),
KEY tbl_status_cod_status (tbl_status_cod_status),
KEY tbl_modelos_cod_modelo (tbl_modelos_cod_modelo),
KEY tbl_usuarios_cod_usuario (tbl_usuarios_cod_usuario)
);

CREATE TABLE IF NOT EXISTS tbl_status(
cod_status int(10) unsigned NOT NULL AUTO_INCREMENT,
titulo varchar(100) NOT NULL,
PRIMARY KEY (cod_status)
);

INSERT INTO tbl_status (cod_status, titulo) VALUES
(1, 'Análise da foto'),
(2, 'Fabricação'),
(3, 'Conferência'),
(4, 'Disponível para entrega');

CREATE TABLE IF NOT EXISTS tbl_usuarios (
  cod_usuario int(10) unsigned NOT NULL AUTO_INCREMENT,
  matricula varchar(14) NOT NULL,
  cpf varchar(14) NOT NULL,
  nome varchar(100) NOT NULL,
  curso varchar(255) NOT NULL,
  tbl_niveis_cod_nivel int(10) unsigned NOT NULL,
  PRIMARY KEY (cod_usuario),
  KEY tbl_niveis_cod_nivel (tbl_niveis_cod_nivel)
);

ALTER TABLE `tbl_avisos`
  ADD CONSTRAINT `tbl_avisos_ibfk_1` FOREIGN KEY (`tbl_usuarios_cod_usuario`) REFERENCES `tbl_usuarios` (`cod_usuario`);

ALTER TABLE `tbl_solicitacoes`
  ADD CONSTRAINT `tbl_solicitacoes_ibfk_1` FOREIGN KEY (`tbl_status_cod_status`) REFERENCES `tbl_status` (`cod_status`),
  ADD CONSTRAINT `tbl_solicitacoes_ibfk_2` FOREIGN KEY (`tbl_modelos_cod_modelo`) REFERENCES `tbl_modelos` (`cod_modelo`),
  ADD CONSTRAINT `tbl_solicitacoes_ibfk_3` FOREIGN KEY (`tbl_usuarios_cod_usuario`) REFERENCES `tbl_usuarios` (`cod_usuario`);

ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`tbl_niveis_cod_nivel`) REFERENCES `tbl_niveis` (`cod_nivel`);
