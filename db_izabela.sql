DROP DATABASE IF EXISTS izabela;
CREATE DATABASE izabela;
USE izabela;

CREATE TABLE tbl_status(
cod_status INT UNSIGNED AUTO_INCREMENT NOT NULL,
titulo VARCHAR(100) NOT NULL,
PRIMARY KEY(cod_status)
);

INSERT INTO tbl_status VALUES(NULL, 'Análise da foto');
INSERT INTO tbl_status VALUES(NULL, 'Fabricação');
INSERT INTO tbl_status VALUES(NULL, 'Conferência');
INSERT INTO tbl_status VALUES(NULL, 'Disponível para entrega');

CREATE TABLE tbl_modelos(
cod_modelo INT UNSIGNED AUTO_INCREMENT NOT NULL,
titulo VARCHAR(100) NOT NULL,
PRIMARY KEY(cod_modelo)
);

CREATE TABLE tbl_usuarios(
cod_usuario INT UNSIGNED AUTO_INCREMENT NOT NULL,
matricula VARCHAR(14) NOT NULL,
cpf VARCHAR(14) NOT NULL,
nome VARCHAR(100) NOT NULL,
PRIMARY KEY(cod_usuario)
);

CREATE TABLE tbl_solicitacoes(
cod_solicitacao INT UNSIGNED AUTO_INCREMENT NOT NULL,
foto VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
tbl_status_cod_status INT UNSIGNED NOT NULL,
tbl_modelos_cod_modelo INT UNSIGNED NOT NULL,
tbl_usuarios_cod_usuario INT UNSIGNED NOT NULL,
PRIMARY KEY(cod_solicitacao),
FOREIGN KEY(tbl_status_cod_status) REFERENCES tbl_status(cod_status),
FOREIGN KEY(tbl_modelos_cod_modelo) REFERENCES tbl_modelos(cod_modelo),
FOREIGN KEY(tbl_usuarios_cod_usuario) REFERENCES tbl_usuarios(cod_usuario)
);

CREATE TABLE tbl_avisos(
cod_aviso INT UNSIGNED AUTO_INCREMENT NOT NULL,
assunto VARCHAR(255) NOT NULL,
remetente VARCHAR(100) NOT NULL,
mensagem TEXT NOT NULL,
lido BOOL DEFAULT 0,
tbl_usuarios_cod_usuario INT UNSIGNED NOT NULL,
PRIMARY KEY(cod_aviso),
FOREIGN KEY(tbl_usuarios_cod_usuario) REFERENCES tbl_usuarios(cod_usuario)
);