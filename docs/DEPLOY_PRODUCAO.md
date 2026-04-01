# Deploy de Producao

## 1) Infra minima recomendada
- PHP 8.2+
- Nginx ou Apache
- MySQL 8+ ou PostgreSQL 14+
- Redis (opcional, recomendado para fila/cache)
- HTTPS com certificado valido

## 2) Variaveis obrigatorias
Configure no `.env` de producao:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_medico
DB_USERNAME=app_user
DB_PASSWORD=senha_forte

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=suporte@seu-dominio.com
MAIL_FROM_NAME="Sistema Medico"

BACKUP_TIME=02:00
BACKUP_RETENTION_DAYS=14
```

## 3) Comandos de publicacao
```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 4) Cron do scheduler
No servidor, configure:

```bash
* * * * * php /caminho/do/projeto/artisan schedule:run >> /dev/null 2>&1
```

## 5) Pos deploy
- Validar login e dashboard
- Validar recuperacao de senha
- Validar endpoint de CEP
- Validar comando `php artisan app:backup`
