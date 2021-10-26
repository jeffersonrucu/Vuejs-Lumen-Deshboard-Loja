<h1 align="center">Vuejs Lumen Deshboard para Loja</h1>
<br>

<p align="center">Pré requisitos </p>
<br>

1. npm

2. composer

3. servidor local para rodar php

4. php 7.4>

<hr>

<p align="center">Guia Rápido para iniciar o projeto em seu hambiente </p>
<br>

1. Crie um banco de dados

2. Atualize o nome do arquivo **./backend/.env example** para  **./backend/.env**..

3. Depois do banco de dados criado vamos realizar as devidas modificações no arquivo **./backend/.env**.

4.  `DB_CONNECTION=mysql`     // Banco de dados <br>
  	`DB_HOST=127.0.0.1`     // HOST Banco de Dados <br>
  	`DB_PORT=3306`   // PORTA Banco de Dados <br>
  	`DB_DATABASE=nome_banco`   // Nome do Banco de Dados <br>
    `DB_USERNAME=usuario_banco`   // Usuario do Banco de Dados <br>
    `DB_PASSWORD=senha_banco`   // Senha do Banco de Dados <br>
		`JWT_SECRET=caminho absoluto/0_Controle_de_Vendas/backend/images`   // caminho absoluto da imagem <br>

5. Agora dentro da pasta **./backend** rodamos o seguinte comando no terminal. <br>
	5.1 composer install <br>
	5.2 php -S localhost:8010 -t public


4. Agora dentro da pasta **./frontend** rodamos o seguinte comando no terminal. <br>
	4.1 npm install <br>
	4.2 npm run serve