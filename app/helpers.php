<?php

function runBackgroundJob($class, $method, $params = [])
{
    $paramString = implode(',', $params);
    $phpPath = PHP_OS_FAMILY === 'Windows' ? 'php.exe' : 'php';

    $cmd = "$phpPath " . base_path('run-job.php') . " $class $method \"$paramString\"";

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        pclose(popen("start /B " . $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null &");
    }
}
