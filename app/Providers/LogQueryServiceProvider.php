<?php

namespace App\Providers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class LogQueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        // if ($blnSqlQueryLog !== true) {
        //     return;
        // }

        DB::listen(static function ($query): void {
            $strSql = $query->sql;

            foreach ($query->bindings as $binding) {
                if (is_string($binding)) {
                    $binding = "'{$binding}'";
                } elseif (is_bool($binding)) {
                    $binding = $binding ? '1' : '0';
                } elseif (is_int($binding)) {
                    $binding = (string) $binding;
                } elseif (is_float($binding)) {
                    $binding = (string) $binding;
                } elseif ($binding === null) {
                    $binding = 'NULL';
                } elseif ($binding instanceof Carbon) {
                    $binding = "'{$binding->toDateTimeString()}'";
                } elseif ($binding instanceof DateTime) {
                    $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                }

                $strSql = preg_replace('/\\?/', $binding, $strSql, 1);
            }

            if ($query->time > 2000) {
                Log::channel('jplog')->info(sprintf('処理時間:%.2f ms SQL: %s;', $query->time, $strSql));
                Log::channel('enlog')->info(sprintf('processing time:%.2f ms SQL: %s;', $query->time, $strSql));
            } else {
                Log::channel('jplog')->info(sprintf('処理時間:%.2f ms SQL: %s;', $query->time, $strSql));
                Log::channel('enlog')->info(sprintf('processing time:%.2f ms SQL: %s;', $query->time, $strSql));
            }
        });

        Event::listen(static fn (TransactionBeginning $event) => Log::channel('jplog')->info('START TRANSACTION'));
        Event::listen(static fn (TransactionCommitted $event) => Log::channel('jplog')->info('COMMIT'));
        Event::listen(static fn (TransactionRolledBack $event) => Log::channel('jplog')->info('ROLLBACK'));
        Event::listen(static fn (TransactionBeginning $event) => Log::channel('enlog')->info('START TRANSACTION'));
        Event::listen(static fn (TransactionCommitted $event) => Log::channel('enlog')->info('COMMIT'));
        Event::listen(static fn (TransactionRolledBack $event) => Log::channel('enlog')->info('ROLLBACK'));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
