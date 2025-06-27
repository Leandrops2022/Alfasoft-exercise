# Projeto de Gerenciamento de Contatos

Este é um projeto de aplicação web desenvolvido com Laravel, focado no gerenciamento simples e eficiente de contatos. Ele inclui funcionalidades de CRUD (Criar, Ler, Atualizar, Deletar), autenticação de usuários e validação de formulários.

## Descrição do Projeto
O objetivo principal deste projeto é fornecer uma plataforma para que usuários autenticados possam gerenciar seus contatos de forma organizada. A aplicação permite adicionar novos contatos, visualizar detalhes, editar informações existentes e remover contatos (com suporte a exclusão lógica, permitindo restauração).

## Funcionalidades
* Autenticação de Usuários: Sistema de registro, login e logout para proteger as funcionalidades do aplicativo.

    * Gerenciamento de Contatos (CRUD):

    * Criar: Adicionar novos contatos com nome, contato telefônico e endereço de e-mail.

    * Listar: Visualizar uma lista paginada de todos os contatos existentes, ordenada alfabeticamente pelo nome.

    * Visualizar Detalhes: Exibir informações completas de um contato específico.

    * Editar: Modificar os dados de um contato existente.

    * Excluir (Soft Delete): Marcar um contato como excluído sem removê-lo fisicamente do banco de dados, permitindo sua restauração posterior.

    * Restaurar: Reativar contatos que foram excluídos logicamente.

* Validação de Formulários: Implementação de validação robusta para garantir a integridade dos dados inseridos, incluindo regras para formato de e-mail, comprimento mínimo de nome e unicidade de contato/e-mail (com exceção do próprio registro ao editar).

* Rotas Protegidas: A maioria das funcionalidades de gerenciamento de contatos (criação, edição, visualização de detalhes, exclusão) é protegida por autenticação. Apenas a lista geral de contatos é acessível publicamente.

# Tecnologias Utilizadas
### Backend: PHP 8.1

### Framework: Laravel 10

### Banco de Dados: MariaDB

### Frontend: HTML, CSS (estilos inline e básicos para o layout)

# Como Instalar e Rodar
Para configurar e rodar o projeto localmente, siga os passos abaixo:

### 1. Clone o repositório:
```bash
git clone https://github.com/Leandrops2022/Alfasoft-exercise.git
cd Alfasoft-exercise/html
```
    
### 2. Instale as dependências do Composer:
     
```bash
composer install
```
     
### 3. Configure o arquivo de ambiente (.env):
Copie o arquivo .env.example para .env:
    
```bash
cp .env.example .env
```
Edite o arquivo .env com suas credenciais de banco de dados e outras configurações necessárias.
Exemplo de configuração de banco de dados para MySQL:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```
Se você estiver usando Docker para o MySQL, lembre-se das configurações de porta e host que você definiu.

### 4. Gere a chave da aplicação:
```bash
php artisan key:generate
```

### 5. Crie e rode as migrações (e seeds):
    Isso criará as tabelas no seu banco de dados e populará com dados de teste (usuários e contatos).
```bash
php artisan migrate:fresh --seed
```

### 6. Inicie o servidor de desenvolvimento do Laravel:
```bash
php artisan serve
```
A aplicação estará acessível em http://127.0.0.1:8000.

# Testes
O projeto inclui testes de funcionalidade (Feature Tests) para validar as regras de validação dos formulários de criação e edição de contatos, garantindo que os dados são inseridos corretamente e que as regras de unicidade são respeitadas, inclusive no contexto de atualização de registros existentes.

Para rodar os testes:

## 1. Configure seu ambiente de teste no .env.testing ou phpunit.xml (muitas vezes, SQLite em memória é uma boa escolha para testes):
```bash 
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

## 2. Execute os testes:
```bash
php artisan test
```
# Autor
* Leandro Pereira Soares - https://github.com/Leandrops2022
# Licensa
Este projeto está licenciado sob a Licença MIT - veja o arquivo LICENSE para detalhes.