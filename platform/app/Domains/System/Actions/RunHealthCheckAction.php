<?php

declare(strict_types=1);

namespace App\Domains\System\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RunHealthCheckAction
{
    public function execute(): array
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'queue' => $this->checkQueue(),
            'storage' => $this->checkStorage(),
            'memory' => $this->checkMemory(),
        ];

        $status = collect($checks)->every(fn($check) => $check['status'] === 'ok')
            ? 'healthy'
            : 'degraded';

        return [
            'status' => $status,
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
        ];
    }

    protected function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            DB::select('SELECT 1');

            return [
                'status' => 'ok',
                'response_time' => $this->measureTime(function () {
                    DB::select('SELECT 1');
                }),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    protected function checkCache(): array
    {
        try {
            $key = 'health_check_' . uniqid();
            $value = 'ok';

            Cache::put($key, $value, 10);
            $stored = Cache::get($key);
            Cache::forget($key);

            return [
                'status' => $stored === $value ? 'ok' : 'error',
                'message' => $stored === $value ? null : 'Cache read/write mismatch',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    protected function checkQueue(): array
    {
        try {
            $connection = config('queue.connections.redis.connection', 'default');
            Redis::connection($connection)->ping();

            return ['status' => 'ok'];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    protected function checkStorage(): array
    {
        try {
            $path = storage_path('app');
            $writable = is_writable($path);

            return [
                'status' => $writable ? 'ok' : 'warning',
                'message' => $writable ? null : 'Storage directory is not writable',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    protected function checkMemory(): array
    {
        $usage = memory_get_usage(true);
        $limit = ini_get('memory_limit');
        $limitBytes = $this->convertToBytes($limit);

        $usagePercent = ($usage / $limitBytes) * 100;

        return [
            'status' => $usagePercent < 80 ? 'ok' : ($usagePercent < 95 ? 'warning' : 'error'),
            'usage_mb' => round($usage / 1024 / 1024, 2),
            'limit_mb' => round($limitBytes / 1024 / 1024, 2),
            'usage_percent' => round($usagePercent, 2),
        ];
    }

    protected function measureTime(callable $callback): float
    {
        $start = microtime(true);
        $callback();
        return round((microtime(true) - $start) * 1000, 2);
    }

    protected function convertToBytes(string $value): int
    {
        $unit = strtolower(substr($value, -1));
        $bytes = (int) substr($value, 0, -1);

        return match ($unit) {
            'g' => $bytes * 1024 * 1024 * 1024,
            'm' => $bytes * 1024 * 1024,
            'k' => $bytes * 1024,
            default => $bytes,
        };
    }
}
