<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed</title>
</head>
<body>
    <h1>Payment Failed</h1>
    <p>There was an error processing your payment.</p>
    @if (session('error'))
       <p>{{ session('error') }}</p>
    @endif
    <a href="{{ route('pdf.index') }}">Back to PDF List</a>
</body>
</html>