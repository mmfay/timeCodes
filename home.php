<?php
function checkCredentials($un, $pw) {
    $servername = "localhost:3306";
    $username1 = "root";
    $password1 = "vaXjev98";
    $dbname = "TIMECODES";
    
    $conn = new mysqli($servername,$username1,$password1,$dbname);
    
    if ($conn->connect_error) {
        die("connection failed: " . $conn->connect_error);
    }

    // sql string
    $sql = "SELECT USERNAME, PASSWORD FROM USERINFO WHERE USERNAME = ?";

    // prepare/execute statement while binding parameters
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $un);
    $stmt->execute();

    // get the results
    $result = $stmt->get_result(); // get the mysqli result
    $user = $result->fetch_assoc(); // fetch data

    if (password_verify($pw,$user["PASSWORD"])) {
        $_SESSION["AUTHENTICATED"] = "TRUE";
        $_SESSION["LOGINATTEMPT"] = "TRUE";
        $_SESSION["USERID"] = $user["USERNAME"];
        return TRUE;
    } else {
        $_SESSION["AUTHENTICATED"] = "FALSE";
        $_SESSION["LOGINATTEMPT"] = "TRUE";
        return FALSE;
    }
    
    $conn->close();
}

// check for authenticated user global variable
// if it doesnt exist, redirect to login page, else just write html code for authenticated user
session_start();

$un = $_REQUEST["user"];
$pw = $_REQUEST["password"];
if (!checkCredentials($un,$pw)) {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>timeCodes</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../stylesheets/timecodes.css">
</head>
<body>
    <h1>Login Successful</h1>
</body>