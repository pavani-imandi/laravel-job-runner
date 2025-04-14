# Laravel Custom Background Job Runner

This project is a custom background job system built in Laravel. It allows you to execute PHP class methods as background jobs **without using Laravel’s default queue system**.

Jobs can be triggered via **CLI** or from **within Laravel code**, with built-in logging, retry handling, and a web-based monitoring dashboard.

---

## Features

- Run class methods as background jobs (CLI or Laravel)
- Retry mechanism with delay support
- Logs job status updates and errors
- Whitelist-based security (only approved classes/methods allowed)
- Web dashboard to view job and error logs
- Works on both Unix and Windows

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/laravel-job-runner.git
cd laravel-job-runner
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Set Permissions (Linux/macOS)

```bash
chmod -R 775 storage bootstrap/cache
```

---

## Configuration

### Define Allowed Jobs

Edit `config/background-jobs.php` to specify which classes and methods can be run:

```php
return [
    'allowed' => [
        \App\Jobs\MyJobClass::class => ['processData', 'sendEmail'],
    ],
    'max_attempts' => 3,
    'retry_delay' => 5,
];
```

### Register Helper File

In `composer.json`, add the helper file for background job execution:

```json
"autoload": {
    "files": [
        "app/helpers.php"
    ]
}
```

Then run:

```bash
composer dump-autoload
```

---

## Usage

### Option 1: From Laravel Code

```php
runBackgroundJob(\App\Jobs\ExampleJob::class, 'run', ['param1', 'param2']);
runBackgroundJob(\App\Jobs\CheckMailQueue::class, 'processData', ['Test', 123]);
```

### Option 2: From CLI

```bash
php run-job.php App\\Jobs\\MyJobClass processData "Test,123"
```

---

## Web Dashboard

This project includes a basic dashboard to view job logs and statuses.

### Start the Laravel Dev Server

```bash
php artisan serve
```

### Open in Your Browser

```
http://localhost:8000/job-dashboard
```

---

## Logs

- Job Logs: `storage/logs/background_jobs.log`
- Error Logs: `storage/logs/background_jobs_errors.log`

---

## Example Job Class

```php
namespace App\Jobs;

class MyJobClass
{
    public function processData($text, $number)
    {
        // Simulate processing
        sleep(2);
        file_put_contents(storage_path('logs/test_output.log'), "Processed: $text, $number\n", FILE_APPEND);
    }

    public function sendEmail($email)
    {
        file_put_contents(storage_path('logs/test_output.log'), "Sent email to: $email\n", FILE_APPEND);
    }
}
```

---

## License

MIT
