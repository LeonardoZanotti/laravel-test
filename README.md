# laravel-test
CRUDs feitas em [laravel](https://laravel.com/), tendo relacionamento entra elas (1:1, 1:N e N:N) além de sistema de autenticação feito com [passport](https://laravel.com/docs/7.x/passport), com login, registro e logout. Está definido o privilégio de admin para um usuário padrão e foi usado Seeders para preencher as tabelas.

# Requisitos
* Estou me baseando em usuários Linux, então seria bom usá-lo. Para Windows os processos são diferentes.
* Laravel 5.7.29
* Composer
* MariaDB 10.4
* PHP 7.3
* Git

# Instalação:

```
composer install

sudo mysql -u root

create database laravel_test_db;

CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'user_password';
// substituir newuser pelo seu usuario e password pela senha

GRANT ALL PRIVILEGES ON *.* TO 'newuser'@'localhost';

exit

cp .env.example .env

nano .env
//configurar seu .env com seu DB_USERNAME = seu_usuario, DB_DATABASE =  laravel_test_db e DB_PASSWORD = sua_senha

php artisan key:generate

php artisan migrate:fresh
// use 'php artisan migrate:fresh --seed' para semear o banco de dados	

php artisan passport:install
// talvez seja necessário usar um require antes com a versão do passport

php artisan passport:client --personal
// Setar nome de client para poder cadastrar usuários

php artisan serve
// seu projeto estará em localhost:8000

```

O usuário admin está definido no seeder, logue com ele para ter acesso as demais funções.
ALém disso é necessário passar o token no header das requisições: **Authorization | Bearer + token**. Isso fará a autenticação dos usuários logados.

# Testes
Acredito que usando o [postman](https://www.postman.com/) e definindo as rotas dê pra testar tranquilo. [Insomnia](https://insomnia.rest/) também deve servir.

# LeonardoZanotti