## API - FazPay

Api para teste da FazPay, com gerenciamento de:

- Produtos
- Usuários

## Instalação

- Clone o repositório
- Execute o comando `composer install`
- Crie um arquivo `.env` na raiz do projeto, copie o conteúdo do arquivo `.env.example` e configure as variáveis de ambiente
- Execute o comando `php artisan key:generate`
- Execute o comand `docker-compose up -d` para subir o Docker com o banco de dados
- Execute o comando `php artisan migrate` para criar as tabelas no banco de dados
- Execute o comando `php artisan scribe:generate` para gerar a documentação da API

## Documentação

A documentação da API pode ser acessada em `http://localhost:8880/docs`
