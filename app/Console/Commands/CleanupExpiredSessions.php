<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupExpiredSessions extends Command
{
    protected $signature = 'session:cleanup';
    protected $description = 'Remove expired sessions';

    public function handle(): int
    {
        $deleted = DB::table('sessions')
            ->where('last_activity', '<', now()->subHours(24)->timestamp)
            ->delete();

        $this->info("Cleaned up {$deleted} expired sessions.");

        return Command::SUCCESS;
    }
}
