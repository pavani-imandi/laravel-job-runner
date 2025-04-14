<?php
use Symfony\Component\Process\Process;

function runBackgroundJob($class, $method, $params = [])
{
    $paramsString = implode(',', array_map('escapeshellarg', $params));
    $php = PHP_BINARY;
    $cmd = [
        $php,
        base_path('run-job.php'),
        $class,
        $method,
        $paramsString
    ];

    $process = new Process($cmd);
    $process->start(); // asynchronous background execution
}