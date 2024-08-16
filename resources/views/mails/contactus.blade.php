<!DOCTYPE html>
<html>
<head>
    <title>contact us</title>
</head>
<body>
    <div style="margin-left: 300px">
    <h1 style="color: red;">contact form </h1>
    <p><strong>name: {{ $data['name'] }}</strong></p>
    <p><strong> email:{{ $data['email'] }}</strong></p>
    <p><strong> subject:{{ $data['subject'] }}</strong></p>
    <p><strong>message :{{ $data['message'] }}</strong></p>
    </div>
</body>
</html>