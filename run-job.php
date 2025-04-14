<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

$config = require __DIR__ . '/config/background-jobs.php';
$logFile = storage_path('logs/background_jobs.log');
$errorLogFile = storage_path('logs/background_jobs_errors.log');

[$script, $class, $method, $params] = array_pad($argv, 4, null);

// Sanitize inputs
$class = trim($class);
$method = trim($method);
$paramsArray = $params
    ? array_map(fn($p) => strip_tags(trim($p)), explode(',', $params))
    : [];
//$paramsArray = $params ? array_map(fn($p) => filter_var(trim($p), FILTER_SANITIZE_STRING), explode(',', $params)) : [];
//$paramsArray = $params ? explode(',', $params) : [];

function logMessage($message, $file) {
    file_put_contents($file, '[' . now() . '] ' . $message . PHP_EOL, FILE_APPEND);
}

$attempts = $config['max_attempts'] ?? 1;
$delay = $config['retry_delay'] ?? 5;
$success = false;

for ($i = 1; $i <= $attempts; $i++) {
    try {
        // Adding security check to allow only whitelisted classes
        if (!isset($config['allowed'][$class]) || !in_array($method, $config['allowed'][$class])) {
            throw new Exception("Unauthorized job: $class@$method");
        }

        if (!class_exists($class)) throw new Exception("Class $class not found.");

        $instance = app()->make($class);

        logMessage("Running $class@$method (attempt $i)", $logFile);

        call_user_func_array([$instance, $method], $paramsArray);

        logMessage("Completed $class@$method", $logFile);
        $success = true;
        break;

    } catch (Throwable $e) {
        logMessage("Attempt $i failed: " . $e->getMessage(), $errorLogFile);
        if ($i < $attempts) sleep($delay);
    }
}

if (!$success) {
    logMessage("Final failure: $class@$method", $errorLogFile);
    exit(1);
}
