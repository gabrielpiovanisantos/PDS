/* cria banco de dados */
create database pds
default character set utf8
default collate utf8_general_ci;

use pds;

drop table usuarios;

/* cria tabela de usuarios */
create table usuarios (
	id int(11) not null auto_increment,
    cnpj varchar(18) not null unique,
    nome varchar(256) not null,
    email varchar(256) not null unique,
    senha varchar(256) not null,
    primary key (id)
) default charset = utf8;

create table boletos (
	id int(11) not null auto_increment,
    userid int(11) not null,
    boleto varchar(256) not null,
    tipo varchar(256) not null,
    status varchar(256),
    data datetime not null,
    primary key (id)
);