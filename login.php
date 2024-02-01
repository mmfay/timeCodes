<?php
    include 'external.php';
    // server should keep session data for AT LEAST 1 hour
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);
    ini_set('session.gc-maxlifetime', 60 * 60 * 24 * 365);
    session_start();
    authentication(FALSE);
?>
<!DOCTYPE html>
<html>
<head>
    <title>timecodes</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../stylesheets/timecodes.css">
</head>
<body>
<h1 class="titleheader"> timecodes </h1>
    <div class="login">
    <form action="/home.php" method="post">
        <label>User Name
        <input type="text" name="user" id="userNameField">
        </label>
        <label>Password
        <input type="password" name="password" id="passwordField">
        </label>
        <input type="submit" value="Login">
    </form>
    </div>
    <script>
    </script>
</body>