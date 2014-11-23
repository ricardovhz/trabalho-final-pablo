create database consecionaria;

use concecionaria;

create table usuario (
	nome_usuario varchar(50) NOT NULL,
	senha varchar(50) NOT NULL,
	id_vendedor int(6) NOT NULL,
	primary key (nome_usuario),
	foreign key (id_vendedor) references vendedor(codigo)
);

create table pessoa (
	codigo    int(6) NOT NULL AUTO_INCREMENT,
	nome      varchar(50) NOT NULL,
	rg        int(11) NOT NULL,
	cpf       int(14) NOT NULL,
	endereco  varchar(150) NOT NULL,
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

--inserções iniciares
insert into vendedor (nome,cargo,turno,data_adm) values ('RICARDO VANHOZ RIBEIRO', 'VENDEDOR', 'DIURNO', '2014-01-01');

-- senha do usuario é '123456' (sem aspas)
insert into usuario (nome_usuario,senha,id_vendedor) values ('ricardovhz','7c4a8d09ca3762af61e59520943dc26494f8941b',1);

