# CRUD de endereços com autenticação desenvolvido em Laravel

Projeto desenvolvido para um teste de desenvolvedor back end júnior.

A proposta era desenvolver o backend de um CRUD de endereços com Laravel, com as funcionalidades:

* Criar, Ler, Atualizar e Deletar um endereço
* O endereço deveria ter os campos: logradouro, número, bairro e o ID da cidade
* Criar comando no artisan para importar cidades de um estado através da integração com API do IBGE

Foram utilizados conceitos como:

* Migrations
* Rotas
* Models
* Controllers
* Autenticação com Sanctum
* Laravel Console
* Integração com API externa
* Teste básicos com PHPUnit

Comando para importar municípios usando o artisan:
``php artisan municipios:import {uf}``

Rotas da API:

| Method | Route                 | Description               |
| ------ | --------------------- | ------------------------  |
| POST   | /api/register         | Cria usuário              |
| POST   | /api/login            | Login de usuário          |
| GET    | /api/profile          | Retorna dados do usuário  |
| POST   | /api/logout           | desloga usuário           |
| GET    | /api/enderecos        | lista todos os endereços  |
| GET    | /api/enderecos/:id    | mostra dados do endereço  |
| POST   | /api/enderecos        | cria um novo endereço     |
| PUT    | /api/enderecos/:id    | atualiza dados do endereço|
| DEL    | /api/enderecos/:id    | Excluir o endereço        |

