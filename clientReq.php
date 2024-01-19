<?php 
    include 'external.php';
    function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
    }
    function insertRecord($code, $desc) {
        $query = "INSERT INTO TIMECODES (TIMECODE, DESCRIPTION, ISACTIVE) VALUES ('" . $code . "','" . $desc . "',1);";
        executeSQL($query);
        getTimeCodesTable();
    }
    function insertUser($user, $fname, $lname, $phone, $email, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO USERINFO (USERNAME, FIRSTNAME, LASTNAME, PHONE, EMAIL, PASSWORD) VALUES ('" . $user . "','" . $fname . "','" . $lname . "','" . $phone . "','" . $email . "','" . $password . "');";
        executeSQL($query);
        userList();
    }
    function insertTimeCode($timeCode) {
        updateOpenTimeCodes();
        $query = "INSERT INTO TIMECODESLOGGING (USERNAME, TIMECODE, TIMECODESTART) VALUES ('" . $_SESSION['USERID'] . "','" . $timeCode . "', now());";
        executeSQL($query);
        dailyCodes();

    }
    function updateOpenTimeCodes() {
        $query = "UPDATE TIMECODESLOGGING SET TIMECODEEND = NOW() WHERE USERNAME = '" . $_SESSION['USERID'] . "' AND TIMECODEEND is null;";
        executeSQL($query);
    }
    function updateRecord($code, $active) {
        $query = "UPDATE TIMECODES SET ISACTIVE = " . intval($active) . " WHERE TIMECODE = '" . $code . "';";
        executeSQL($query);
    }
    function deleteTimeCode($timeCode) {
        $query = "DELETE FROM TIMECODES WHERE TIMECODE = '" . $timeCode . "';";
        executeSQL($query);
        getTimeCodesTable();
    }
    function executeSQL($sqlQuery) {
        $conn = getDatabaseConnection();
        if ($conn->connect_error) {
            die("connection failed: " . $conn->connect_error);
        }
        // prepare statement
        $sql = $conn->prepare($sqlQuery);
        //$sql = $conn->prepare("UPDATE TIMECODES SET ISACTIVE = 0 WHERE TIMECODE = '100A';";
        // execute
        $sql->execute();
        $conn->close();
    }
// Retrieve the raw POST data
$jsonData = file_get_contents('php://input');
// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);
// Check if decoding was successful
if ($data !== null) {
   // Access the data and perform operations
   //$name = $data['name'];
   //$active = $data['isActive'];
   // Perform further processing or respond to the request
        $type = $data['title'];
        switch ($type) {
            case "Insert":
                $code = $data['code'];
                $desc = $data['desc'];
                insertRecord($code, $desc);
                break;
            case "InsertUser":
                $user = $data['username'];
                $fname = $data['firstname'];
                $lname = $data['lastname'];
                $phone = $data['phone'];
                $email = $data['email'];
                $password = $data['password'];
                insertUser($user, $fname, $lname, $phone, $email, $password);
                break;
            case "InsertTimeCode":
                $timeCode = $data['timeCode'];
                insertTimeCode($timeCode);
                break;
            case "Update":
                $name = $data['name'];
                $active = $data['isActive'];
                updateRecord($name, $active);
                break;
            case "Delete":
                $name = $data['name'];
                deleteTimeCode($name);
                break;
            case "Select":
                $userRange = $data['userRange'];
                $timeRange = $data['timeRange'];
                buildReportTable($timeRange, $userRange);
                break;
            case "Logout":
                logout();
                break;
            default:
                echo "error";
        }

} else {
   // JSON decoding failed
   http_response_code(400); // Bad Request
   echo "Invalid JSON data";
}

?>