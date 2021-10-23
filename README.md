<h1 align="center">Vuejs Lumen Deshboard para Loja</h1>
<br>

<p align="center">Guia Rápido para iniciar o projeto em seu hambiente </p>
<br>

1. Crie um banco de dados

2. Atualizze o nome do arquivo **./backend/.env example** para  **./backend/.env**..

3. Depois do banco de dados criado vamos realizar as devidas modificações no arquivo **./backend/.env**.

3.  `DB_CONNECTION=mysql`     // Banco de dados <br>
  	`DB_HOST=127.0.0.1`     // HOST Banco de Dados <br>
  	`DB_PORT=3306`   // PORTA Banco de Dados <br>
  	`DB_DATABASE=nome_banco`   // Nome do Banco de Dados <br>
    `DB_USERNAME=usuario_banco`   // Usuario do Banco de Dados <br>
    `DB_PASSWORD=senha_banco`   // Senha do Banco de Dados <br>

<hr>
<p align="center">UML da Estrutura Básica do Banco de Dados </p>
<br>

![alt text](https://github.com/jeffersonrucu/Sistema-Para-Pizzaria/blob/master/UML.png?raw=true)

<br>

<p align="center">SQL para criar o bando de dados </p>

```sql
CREATE DATABASE Pizzaria;

USE Pizzaria;

CREATE TABLE client (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone  VARCHAR(19) NOT NULL,
  telephone  VARCHAR(18) NOT NULL,
  address VARCHAR(150) NOT NULL,
  district VARCHAR(50) NOT NULL,
  zip_code VARCHAR(10) NOT NULL,
  city VARCHAR(50) NOT NULL,
  state VARCHAR(50) NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `permission` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE `product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `unitary_value` DOUBLE(200),
  `image` VARCHAR(255),
  `amount` INT,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY (id)
  );
  
  CREATE TABLE `sold` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_product` INT NOT NULL,
  `amount` INT,
  `sale_value` DOUBLE,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  FOREIGN KEY (`id_product`) REFERENCES `product`(`id`),
  PRIMARY KEY (id)
);
```