<?php

namespace App\Jobs;

class CheckMailQueue
{
    public function processData($input, $number)
    {
        sleep(2); // simulate processing

        // Do something with the input
        file_put_contents(storage_path('logs/test_output.log'), "Processed: $input, $number\n", FILE_APPEND);
    }

    public function sendEmail($to)
    {
        // simulate sending email
        file_put_contents(storage_path('logs/test_output.log'), "Sent email to: $to\n", FILE_APPEND);
    }
}
