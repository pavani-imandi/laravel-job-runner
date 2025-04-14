<?php

return [
    'allowed' => [
        \App\Jobs\CheckMailQueue::class => ['processData', 'sendEmail'],
    ],
    'max_attempts' => 3,
    'retry_delay' => 5, // in seconds
];
