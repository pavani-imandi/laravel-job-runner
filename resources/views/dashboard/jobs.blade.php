<!DOCTYPE html>
<html>
<head>
    <title>Background Job Dashboard</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f8f9fa; }
        h2 { margin-top: 40px; }
        pre { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1); max-height: 400px; overflow-y: scroll; }
    </style>
</head>
<body>
<h1>Background Job Dashboard</h1>

<h2>Job Logs</h2>
<pre>@foreach($logs as $log){{ $log }}
    @endforeach</pre>

<h2>Error Logs</h2>
<pre>@foreach($errors as $error){{ $error }}
    @endforeach</pre>
</body>
</html>
