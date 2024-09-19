# COMO RODAR O PROJETO

pra fazer os testes de API necessario ter dentro do .env a chame "API_SECRET_KEY" e a "AUTHORIZATION_TOKEN"

### 1. No CMD rode os seguintes comandos:

-   composer install
-   npm i
-   npm run build

### 2. Crie um Arquivo .ENV

crie um arquivo .env e configure as credenciais do banco de dados

-   DB_CONNECTION=mysql
-   DB_HOST=127.0.0.1
-   DB_PORT=3306
-   DB_DATABASE=nome_tabela
-   DB_USERNAME=root
-   DB_PASSWORD=senha_root

### 3. Criar as migrations

-   php artisan migrate

### 4. Criar o ADMIN

-   php artisan make:filament-user

apos fornecer o nome, email e senha, ele criara um usuario e fornecera a url pra entrar no admin

URL padrao vai ficar -> http://localhost:8000/admin-{{APP_KEY}}

ex: http://localhost:8000/admin-UXUKJV/YAZ2YoENx+oxdPyZSjdeV0qh1esUZOtO+4cs=
