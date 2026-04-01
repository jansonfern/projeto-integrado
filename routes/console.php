<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:backup', function () {
    $driver = DB::connection()->getDriverName();
    $backupDir = storage_path('app/backups');
    File::ensureDirectoryExists($backupDir);

    $timestamp = now()->format('Ymd_His');

    if ($driver === 'sqlite') {
        $sqlitePath = database_path('database.sqlite');

        if (! File::exists($sqlitePath)) {
            $this->error('Arquivo SQLite nao encontrado para backup.');

            return 1;
        }

        $target = $backupDir.DIRECTORY_SEPARATOR."sqlite_{$timestamp}.sqlite";
        File::copy($sqlitePath, $target);
        $this->info("Backup SQLite criado: {$target}");
    } else {
        $this->warn('Backup automatico para MySQL/PostgreSQL depende de mysqldump/pg_dump no servidor.');
        $this->warn('Configure o dump no deploy e mantenha este comando no scheduler para limpeza/rotina.');
    }

    $retentionDays = (int) env('BACKUP_RETENTION_DAYS', 7);
    $cutoff = now()->subDays($retentionDays);

    foreach (File::files($backupDir) as $file) {
        if ($file->getMTime() < $cutoff->timestamp) {
            File::delete($file->getPathname());
        }
    }

    $this->info('Rotina de backup finalizada.');

    return 0;
})->purpose('Gera backup local do banco e remove backups antigos');

Schedule::command('app:backup')
    ->dailyAt(env('BACKUP_TIME', '02:00'))
    ->withoutOverlapping();
