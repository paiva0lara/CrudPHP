create database  dbanco;
use dbanco;
create table tbCadastro(
id int auto_increment primary key,
nome varchar(40) not null,
email varchar(40) not null,
senha varchar(8),
sexo varchar(1),
dtna datetime);

select * from tbCadastro;