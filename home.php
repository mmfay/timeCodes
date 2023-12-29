<?php
// check for authenticated user global variable
// if it doesnt exist, redirect to login page, else just write html code for authenticated user
session_start();

$un = $_REQUEST["user"];
$pw = $_REQUEST["password"];
if ($un !== "test" || $pw !==  "test1") {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../stylesheets/timecodes.css">
</head>

<body>
<h1>
    Content
</h1>
</body>