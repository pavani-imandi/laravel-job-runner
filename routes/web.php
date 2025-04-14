<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/job-dashboard', function () {
    $logPath = storage_path('logs/background_jobs.log');
    $errorPath = storage_path('logs/background_jobs_errors.log');
    $logs = File::exists($logPath) ? array_reverse(explode("\n", File::get($logPath))) : [];
    $errors = File::exists($errorPath) ? array_reverse(explode("\n", File::get($errorPath))) : [];
    return view('dashboard.jobs', compact('logs', 'errors'));
});
