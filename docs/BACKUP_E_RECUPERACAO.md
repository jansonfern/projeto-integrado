# Backup e Recuperacao

## Comando disponivel
O projeto possui o comando:

```bash
php artisan app:backup
```

### Comportamento atual
- `sqlite`: copia o arquivo `database/database.sqlite` para `storage/app/backups`.
- `mysql/pgsql`: mostra aviso para configurar `mysqldump`/`pg_dump` no servidor.
- Remove backups antigos conforme `BACKUP_RETENTION_DAYS`.

## Agendamento automatico
Configurado no scheduler para executar diariamente em `BACKUP_TIME`.

## Politica recomendada
- Backup diario completo
- Retencao de 14 a 30 dias
- Copia externa (S3, bucket privado ou storage gerenciado)
- Teste de restauracao mensal

## Teste de restauracao (sqlite)
1. Pare a aplicacao.
2. Substitua `database/database.sqlite` pelo arquivo de backup.
3. Suba a aplicacao e valide login/consultas.
