<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use Illuminate\Support\Facades\DB;

class DatabaseService
{
    /**
     * Run a database transaction.
     */
    public function transaction(callable $callback): mixed
    {
        return DB::transaction($callback);
    }

    /**
     * Get the database connection.
     */
    public function connection(?string $name = null)
    {
        return DB::connection($name);
    }

    /**
     * Get the database table prefix.
     */
    public function getTablePrefix(): string
    {
        return DB::getTablePrefix();
    }

    /**
     * Check if a table exists.
     */
    public function tableExists(string $table): bool
    {
        return DB::getSchemaBuilder()->hasTable($table);
    }

    /**
     * Check if a column exists in a table.
     */
    public function columnExists(string $table, string $column): bool
    {
        return DB::getSchemaBuilder()->hasColumn($table, $column);
    }

    /**
     * Get the column types for a table.
     */
    public function getColumnTypes(string $table): array
    {
        return DB::getSchemaBuilder()->getColumnType($table);
    }

    /**
     * Get the database size.
     */
    public function getDatabaseSize(): string
    {
        $result = DB::select('SELECT pg_size_pretty(pg_database_size(current_database())) as size');
        return $result[0]->size ?? 'Unknown';
    }
}
