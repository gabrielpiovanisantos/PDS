/* cria banco de dados */
create database pds
default character set utf8
default collate utf8_general_ci;

use pds;

/* cria tabela de usuarios */
create table users (
	id int not null auto_increment,
    cnpj varchar(11) not null unique,
    email varchar(50) not null unique,
    pass varchar(20) not null,
    primary key (id)
) default charset = utf8;

insert into users values
(default, 'luciane.silva@msn.com', 'senha');

SELECT * FROM users WHERE email = 'luciane.silva@msn.com' AND pass = 'senha';
