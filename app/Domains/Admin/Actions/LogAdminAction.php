<?php

declare(strict_types=1);

namespace App\Domains\Admin\Actions;

use App\Domains\Admin\Models\AdminLog;
use App\Domains\Users\Models\User;

class LogAdminAction
{
    public function execute(User $admin, string $action, string $description, array $metadata = []): AdminLog
    {
        return AdminLog::create([
            'admin_id' => $admin->id,
            'action' => $action,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
