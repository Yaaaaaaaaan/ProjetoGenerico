use PGDB;
drop database PGDB;
create database PGDB;
use PGDB;
create table usuario(
	idUsuario int(11) not null auto_increment primary key,
	nomeUsuario varchar(100) not null,
	nickUsuario varchar(40) not null unique,
	emailUsuario varchar(150) not null unique,
	senhaUsuario varchar(32) not null,
	dataCad datetime default current_timestamp,
	dataAlt datetime default current_timestamp
);
create table dadosUsuario(
	codDadosU int(11) not null  auto_increment primary key,
	idDadosUFk int(11) not null unique,
	cpfDadosU varchar(32) null unique,
	rgDadosU varchar(32) null unique,
	rankDados int(1) not null,
	foreign key (idDadosUFk) references usuario (idUsuario)
);
create table produto(
	codProd int(11) not null auto_increment primary key,
	statusProd varchar(1) not null default 'A',
	descProd varchar(50) null default null,
	tamProd varchar(5) null default null,
	estMinProd int(11) null default null,
	estMaxProd int(11) null default null,
	classeProd varchar(20) not null,
	idUsuarioFkProd int(11) not null,
	foreign key (idUsuarioFkProd) references usuario (idUsuario)
);
create table entradaProduto(
	codEntProd INT(11) NOT NULL AUTO_INCREMENT primary key,
	codProdFkEnt INT(11) NULL DEFAULT NULL,
	qtde INT(11) NULL DEFAULT NULL,
	vlrUnit DECIMAL(9,2) NULL DEFAULT  '0.00' ,
	dataEnt datetime default current_timestamp,
	idUsuarioFkEnt int(11),
	foreign key (codProdFkEnt) references produto (codProd),
	foreign key (idUsuarioFkEnt) references usuario (idUsuario)
);
create table estoque(
	codEst int(11) not null AUTO_INCREMENT primary key,
	codProdFkEst  INT(11) UNIQUE,
	qtde  INT(11) NULL DEFAULT NULL,
	vlrUnitCom  DECIMAL(9,2) NULL DEFAULT '0.00',
	vlrUnitVen  DECIMAL(9,2) NULL DEFAULT '0.00',
	foreign key (codProdFkEst) references produto (codProd)
);
create table saidaProduto (
	codSaiProd INT(11) NOT NULL AUTO_INCREMENT primary key,
	codProdFkSai INT(11) NULL DEFAULT NULL,
	qtde INT(11) NULL DEFAULT NULL,
	dataSai datetime default current_timestamp,
	vlrUnit DECIMAL(9,2) NULL DEFAULT '0.00',
	idUsuarioFkSai int(11),
	foreign key (codProdFkSai) references produto (codProd),
	foreign key (idUsuarioFkSai) references usuario (idUsuario)
);
create table transacao(
	codTransacao Int(11) not null auto_increment primary key,
	
);
create table docs(
	codDocs int(11) not null auto_increment primary key,
	nomeDocs varchar(255) not null unique,
	dataInclusaoDocs datetime default current_timestamp,
	codProdFkDocs INT(11)null default null,
	foreign key (codProdFkDocs) references produto (codProd)
);  
create table configUsuario(
	codConfigUsuario int(11) not null auto_increment primary key,
	idUsuarioFkConf int(11) not null unique,
	layoutUsuarioConf varchar(255) not null,
	codImgPrincUsuarioConf int(11) not null,
	foreign key (idUsuarioFkConf) references usuario (idUsuario),
	foreign key (codImgPrincUsuarioConf) references docs (codDocs)
);
create table historico(
	codHist int(11) not null auto_increment primary key,
	nomeTablHist varchar(255) not null,
	codLinhaInfoHist int(11) not null,
	descHist varchar(255) not null,
	idUsuarioFkHist int(11) not null,
	dataHist datetime default current_timestamp,
	foreign key (idUsuarioFkHist) references usuario (idUsuario)
);
