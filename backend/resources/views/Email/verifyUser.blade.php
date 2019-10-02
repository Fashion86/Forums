<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
<div style="display: flex"><h3>Welcome to the site {{$user['username']}}</h3></div>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<a href="{{url('forum/user/verify', $user->verifyUser->token)}}">Verify Email</a>
</body>
</html>