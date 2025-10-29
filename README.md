# Projeto Web 2 - Sistema de Gestão Médica

Este é um projeto Laravel 11 que gerencia pacientes, médicos, agendamentos e certificados.

## 📌 Resumo Rápido

Para rodar o projeto em outro PC, siga estes passos principais:

1. ✅ Instalar PHP 8.2+ e Composer
2. ✅ Copiar o projeto para o novo PC
3. ✅ Executar `composer install`
4. ✅ Criar arquivo `.env` (veja `CONFIGURACAO_ENV.md`)
5. ✅ Executar `php artisan key:generate`
6. ✅ Criar banco de dados `webll`
7. ✅ Executar `php artisan migrate`
8. ✅ Executar `php artisan serve`
9. ✅ Acessar `http://localhost:8000`

Para mais detalhes, continue lendo abaixo.

## 📋 Requisitos do Sistema

Antes de começar, certifique-se de ter instalado:

- **PHP** >= 8.2
- **Composer** (gerenciador de dependências PHP)
- **MySQL** ou **MariaDB** (ou SQLite para desenvolvimento)
- **Servidor Web** (Apache/Nginx) ou usar o servidor embutido do PHP
- **Extensões PHP necessárias:**
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - PDO_MYSQL (ou PDO_SQLITE)
  - Tokenizer
  - XML

**Para verificar se as extensões estão instaladas:**
```bash
php -m
```

Ou crie um arquivo `info.php` com `<?php phpinfo(); ?>` e acesse no navegador.

## 🚀 Instalação Passo a Passo

### 1. Copiar o Projeto

Copie toda a pasta do projeto para o novo computador ou clone do repositório:

```bash
git clone <url-do-repositorio>
cd projeto-web-2-teste-ssh
```

### 2. Instalar Dependências do Composer

Execute o comando para instalar todas as dependências do projeto:

```bash
composer install
```

**Nota:** Se você não tem o Composer instalado, baixe em: https://getcomposer.org/download/

### 3. Configurar o Arquivo .env

**IMPORTANTE:** Você precisa criar o arquivo `.env` manualmente, pois este projeto não possui `.env.example`.

**Opção 1:** Use o arquivo `CONFIGURACAO_ENV.md` como referência e copie o conteúdo para criar um arquivo `.env` na raiz do projeto.

**Opção 2:** Crie o arquivo `.env` manualmente e configure:

```bash
# No Windows (PowerShell)
# Crie um arquivo de texto chamado .env na raiz do projeto

# No Linux/Mac
touch .env
```

Depois, edite o arquivo `.env` e configure:

```env
APP_NAME="Sistema Médico"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Configurações do Banco de Dados
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webll
DB_USERNAME=root
DB_PASSWORD=

# Para usar SQLite (mais simples para desenvolvimento)
# DB_CONNECTION=sqlite
# DB_DATABASE=C:/xampp/htdocs/projeto-web-2-teste-ssh/database/database.sqlite
```

**Importante:** 
- Se estiver usando **XAMPP**, o usuário padrão é `root` e a senha geralmente está vazia
- Se estiver usando **SQLite**, apenas descomente as linhas do SQLite e comente as do MySQL

### 4. Gerar a Chave da Aplicação

Execute o comando para gerar a chave de criptografia:

```bash
php artisan key:generate
```

### 5. Criar o Banco de Dados

#### Opção A: Usando MySQL/MariaDB

1. Abra o phpMyAdmin ou MySQL Workbench
2. Crie um novo banco de dados chamado `webll`:

```sql
CREATE DATABASE webll CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Opção B: Usando SQLite

O arquivo `database.sqlite` já existe na pasta `database/`. Certifique-se de que o arquivo `.env` está configurado para usar SQLite.

### 6. Executar as Migrações

Execute as migrações para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

**Opcional:** Se quiser popular o banco com dados de exemplo:

```bash
php artisan db:seed
```

### 7. Configurar Permissões (Linux/Mac)

Se estiver em Linux ou Mac, configure as permissões das pastas:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 8. Iniciar o Servidor de Desenvolvimento

Execute o servidor embutido do Laravel:

```bash
php artisan serve
```

O servidor estará disponível em: **http://localhost:8000**

### 9. Acessar a Aplicação

Abra seu navegador e acesse:

```
http://localhost:8000
```

## 🔧 Configuração com XAMPP (Windows)

Se você estiver usando XAMPP no Windows:

1. Copie o projeto para: `C:\xampp\htdocs\projeto-web-2-teste-ssh`
2. Configure o `.env` com:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=webll
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Inicie o Apache e MySQL no XAMPP Control Panel
4. Execute os comandos no terminal dentro da pasta do projeto:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan serve
   ```

## 📝 Comandos Úteis

### Limpar Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Executar Migrações Novamente

```bash
php artisan migrate:fresh
php artisan migrate:fresh --seed
```

### Criar um Novo Usuário (se necessário)

```bash
php artisan tinker
```

Depois no tinker:
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('senha123')
]);
```

## ⚠️ Problemas Comuns e Soluções

### Erro: "Could not find driver"

**Solução:** Instale a extensão PDO do MySQL:
- No `php.ini`, descomente a linha: `extension=pdo_mysql`

### Erro: "SQLSTATE[HY000] [1045] Access denied"

**Solução:** Verifique as credenciais do banco de dados no arquivo `.env`

### Erro: "The stream or file could not be opened"

**Solução:** Verifique as permissões da pasta `storage`:
```bash
chmod -R 775 storage
```

### Erro: "Class 'PDO' not found"

**Solução:** Instale as extensões PHP necessárias no `php.ini`

### Erro ao executar `composer install`

**Solução:** Certifique-se de ter o PHP 8.2 ou superior instalado:
```bash
php -v
```

### Erro: "file_get_contents(.env): Failed to open stream"

**Solução:** Crie o arquivo `.env` manualmente na raiz do projeto. Veja o arquivo `CONFIGURACAO_ENV.md` para o conteúdo necessário.

### Erro: "No application encryption key has been specified"

**Solução:** Execute o comando:
```bash
php artisan key:generate
```

## 📦 Estrutura do Projeto

- `app/` - Código da aplicação (Controllers, Models, etc.)
- `database/` - Migrações e seeders
- `public/` - Arquivos públicos (ponto de entrada da aplicação)
- `resources/` - Views e assets
- `routes/` - Definição de rotas
- `storage/` - Arquivos de cache e logs

## 🔐 Segurança

**IMPORTANTE:** Não compartilhe o arquivo `.env` publicamente. Ele contém informações sensíveis como chaves de criptografia e credenciais do banco de dados.

## 📞 Suporte

Se encontrar problemas durante a instalação, verifique:
1. Versão do PHP (`php -v`)
2. Versão do Composer (`composer --version`)
3. Logs do Laravel em `storage/logs/laravel.log`
4. Configurações do banco de dados no `.env`

## 🎯 Próximos Passos

Após a instalação bem-sucedida:
1. Acesse a aplicação em `http://localhost:8000`
2. Crie um usuário ou faça login
3. Explore as funcionalidades do sistema

