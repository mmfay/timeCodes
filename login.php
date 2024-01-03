<?php
    include 'external.php';
    session_start();
    authentication(FALSE);
?>
<!DOCTYPE html>
<html>
<head>
    <title>timeCodes</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../stylesheets/timecodes.css">
</head>
<body>
    <div class="login">
    <form action="/home.php" method="post">
        <label>User Name
        <input type="text" name="user" id="userNameField">
        </label>
        <label>Password
        <input type="text" name="password" id="passwordField">
        </label>
        <input type="submit" value="Login">
        <?php
            loginAttempt();
        ?>
    </form>
    </div>
    <script>
    </script>
</body>