<?php
 
namespace Spatie\Backup\Tasks\Cleanup\Strategies;

use Spatie\Backup\Tasks\Cleanup\CleanupStrategy;
use Illuminate\Support\Collection;
use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\BackupDestination\BackupCollection;

class BackupCleaner extends CleanupStrategy
{
    public function deleteOldBackups(BackupCollection $backups){
        $backup = $backups->oldest();
        $backup->delete();
    }
}