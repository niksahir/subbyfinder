<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Received</title>
</head>
<body>
    <h1>You have received a new enquiry!</h1>
    <p><strong>Name:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Phone:</strong> {{ $phone }}</p>
    <div><strong>Message:</strong> {{ $userMessage }}</div>
    <p><strong>URL:</strong> <a href="{{ $url }}">{{ $url }}</a></p>
</body>
</html>
