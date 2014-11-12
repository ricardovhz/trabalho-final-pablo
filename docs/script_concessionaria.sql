create database consecionaria;

use concecionaria;

create table pessoa (
	codigo    int(6) NOT NULL AUTO_INCREMENT,
	nome      varchar(50) NOT NULL,
	rg        int(11) NOT NULL,
	cpf       int(14) NOT NULL,
	endereco  varchar(150) NOT NULL,
	bairro    varchar(30),
	cidade    varchar(30) NOT NULL,
	uf        varchar(2) NOT NULL,
	data_nasc date NOT NULL,
	primary key (codigo)
);

create table veiculo (
	codigo    int(6) NOT NULL AUTO_INCREMENT,
	marca     varchar(50) NOT NULL,     
	modelo    varchar(100) NOT NULL,
	ano_fabri int(4),
	primary key (codigo)
);

create table venda (
	codigo    int(6) NOT NULL AUTO_INCREMENT,
	cod_pess  int(6) NOT NULL,
	cod_veic  int(6) NOT NULL,
	cod_vend  int(6) NOT NULL,
	data_vend date NOT NULL,
	vlr_venda int(10) NOT NULL,
	primary key (codigo),
	foreign key (cod_pess) references pessoa (codigo),
	foreign key (cod_veic) references veiculo (codigo),
	foreign key (cod_vend) references vendedor (codigo)
);

create table vendedor (
	codigo    int(6) NOT NULL AUTO_INCREMENT,
	nome      varchar(50) NOT NULL,
	cargo     varchar(50) NOT NULL,
	turno     varchar(30) NOT NULL,
	data_adm  date NOT NULL,
	primary key (codigo)
);
