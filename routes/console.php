<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Schedule::command('queue:work database --max-time=50 --tries=3 --memory=128')
    ->everyMinute()
    ->withoutOverlapping(5)
    ->sendOutputTo(storage_path('logs/queue-' . date('Y-m-d') . '.log'))
    ->onSuccess(function () {
        Log::info('Queue worker completed successfully');
    })
    ->onFailure(function () {
        Log::error('Queue worker failed');
    });

// Restart queue setiap 5 menit
Schedule::command('queue:restart')
    ->everyFiveMinutes();


// Cek stuck jobs
Schedule::call(function () {
    $stuckJobs = DB::table('jobs')
        ->where('created_at', '<', now()->subMinutes(10))
        ->count();

    if ($stuckJobs > 0) {
        Log::warning("Found {$stuckJobs} stuck jobs in queue");
    }
})->everyFiveMinutes();


// Retry all failed jobs setiap hari
Schedule::command('queue:retry all')
    ->dailyAt('02:00');


// Hapus failed jobs lebih dari 30 hari
Schedule::call(function () {
    DB::table('failed_jobs')
        ->where('failed_at', '<', now()->subDays(30))
        ->delete();
})->weekly();


// Hapus log queue lebih dari 7 hari
Schedule::call(function () {
    $logPath = storage_path('logs');
    $files = glob($logPath . '/queue-*.log');

    foreach ($files as $file) {
        if (filemtime($file) < strtotime('-7 days')) {
            @unlink($file);
        }
    }
})->daily();