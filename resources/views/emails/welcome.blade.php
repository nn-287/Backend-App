<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X_UA_Compatible" content="if-edge">
    <meta name="viewport" content="width-device-width, initial-scale-1.0">
    <title>Welcome Email</title>
</head>
<body>
    <h1>Thanks for joining us, {{ $firstName }} {{ $secondName }}</h1>
    <p>Your verification token: {{ $token }}</p>
</body>
</html>
