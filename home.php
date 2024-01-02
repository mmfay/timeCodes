<?php
function checkCredentials($un, $pw) {
    
    $conn = getConnection();
    
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
function printOptions() {
    // create select string
    $sql = "SELECT TIMECODE FROM TIMECODES WHERE ISACTIVE = 1 ORDER BY TIMECODE ASC;";

    // prepare/execute statement
    $result = getConnection()->query($sql); 

    // loop through results and build sidenav list/links
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<option id='" . $row["TIMECODE"] . "'>" . $row["TIMECODE"] . "</option>";
        }
    } else {
        echo "<option id='NA'>No Options</option>";
    }
}
function getConnection() {
    $servername = "localhost:3306";
    $username1 = "root";
    $password1 = "vaXjev98";
    $dbname = "TIMECODES";
    $conn = new mysqli($servername,$username1,$password1,$dbname);
    return $conn;
}
// check for authenticated user global variable
// if it doesnt exist, redirect to login page, else just write html code for authenticated user
session_start();

$un = $_REQUEST["user"];
$pw = $_REQUEST["password"];
if (!checkCredentials($un,$pw) && !(strcmp($_SESSION["AUTHENTICATED"], "FALSE") == 0)) {
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
    <h1 class="titleheader"> timeCodes </h1>
    <ul>
        <li><a href="#home">Data Entry</a></li>
        <li><a href="#timecodeentry">Review Data</a></li>
        <?php
            if(strcmp($_SESSION["USERID"],"admin") == 0) {
                echo "<li><a href='userManagement.php'>User Management</a></li>";
                echo "<li><a href='timeCodes.php'>Time Codes</a></li>";
                echo "<li><a href='reporting.php'>Reporting</a></li>";
            }
        ?>
    </ul>
    <div class="form-container">
        <form class="form" id="userCreationForm">
            <label>Time Code
                <select name="timeCodes" id="timeCodes">
                    <?php 
                        printOptions();
                    ?>
                </select>
            </label>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>