# Configuração Rápida do .env

Copie este conteúdo para um arquivo chamado `.env` na raiz do projeto:

```
APP_NAME="Sistema Médico"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webll
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120

QUEUE_CONNECTION=database
CACHE_STORE=database
```

Depois de criar o arquivo `.env`, execute:
```bash
php artisan key:generate
```

Isso gerará automaticamente a chave `APP_KEY`.

