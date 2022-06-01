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
create table fornecedor(
	codFornecedor int(11) not null auto_increment primary key,
	nomeFornecedor varchar(100) not null unique,
	dataCad datetime default current_timestamp,
	dataAlt datetime default current_timestamp
);
create table dadosUsFo(
	codDadosUsFo int(11) not null  auto_increment primary key,
	idDadosUsFoFk int(11) null unique,
	codDadosUsFoFk int(11) null unique,
	cpfDadosUsFo varchar(32) null unique,
	rgDadosUsFo varchar(32) null unique,
	CNPJDadosUsFo varchar(32) null unique,
	dataNasc date null,
	rankDados int(1) null,
	foreign key (idDadosUsFoFk) references usuario (idUsuario),
	foreign key (codDadosUsFoFk) references fornecedor (codFornecedor)
);
create table classeProd(
	codClasseProd int(11) not null auto_increment primary key,
	classeBase varchar(255) not null, /* Ex: Alimenticio, Vestuario */
	classeDivisao varchar(255) not null, /* Ex: Perecivel, não Perecivel, Camisa, Cueca */
	idUsuarioFkClass int(11) not null,
	foreign key (idUsuarioFkClass) references usuario (idUsuario)
);
create table produto(
	codProd int(11) not null auto_increment primary key,
	statusProd varchar(1) not null default 'A',
	descProd varchar(50) null default null,
	tamProd varchar(5) null default null,
	estMinProd int(11) null default null,
	estMaxProd int(11) null default null,
	classeProd int(11) not null,
	idUsuarioFkProd int(11) not null,
	foreign key (idUsuarioFkProd) references usuario (idUsuario),
	foreign key (classeProd) references classeProd (codClasseProd)
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
create table baseCalc(
	codBaseCalc int(11) not null auto_increment primary key,
	baseCalc DECIMAL(9,2) null default '0.00',
	dataIncl datetime default current_timestamp,
	idUsuarioFkBasC int(11),
	foreign key (idUsuarioFkBasC) references usuario (idUsuario)
);
create table configSistema(
	codConfigSistema int(11) not null auto_increment primary key,
	descConf int(11) not null,
	idUsuarioFkConfS int(11) not null,
	foreign key (idUsuarioFkConfS) references usuario (idUsuario)
);
create table estoque(
	codEst int(11) not null AUTO_INCREMENT primary key,
	codProdFkEst  INT(11) UNIQUE,
	qtde  INT(11) NULL DEFAULT NULL,
	vlrUnitCom  DECIMAL(9,2) NULL DEFAULT '0.00',
	baseCalc DECIMAL(9,2) null default '0.00',
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
	infoAnte varchar(255) null,
	idUsuarioFkHist int(11) not null,
	dataHist datetime default current_timestamp,
	foreign key (idUsuarioFkHist) references usuario (idUsuario)
);