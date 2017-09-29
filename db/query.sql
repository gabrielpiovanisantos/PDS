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

insert into usuarios values
(default, '00.000.000/0001-00', 'Trash Sofware', 'luciane.silva@msn.com', 'senha');

SELECT * FROM usuarios WHERE email = 'luciane.silva@msn.com' AND senha = 'senha';
SELECT * FROM usuarios;
