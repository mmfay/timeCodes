<?php
    session_start();
    function getDatabaseConnection() {
        $servername = "localhost:3306";
        $username1 = "root";
        $password1 = "vaXjev98";
        $dbname = "TIMECODES";
        $conn = new mysqli($servername,$username1,$password1,$dbname);
        return $conn;
    }
    function getTimeCodesTable() {

        $conn = getDatabaseConnection();
        // create select string
        $sql = "SELECT TIMECODE, DESCRIPTION, ISACTIVE FROM TIMECODES ORDER BY TIMECODE ASC, ISACTIVE ASC;";

        // prepare/execute statement
        $result = $conn->query($sql); 

        // loop through results and build sidenav list/links
        if($result->num_rows > 0) {
            echo "<tr><th>Time Code</th><th>Description</th><th>Active</th><th>Delete</th></tr>";
            while($row = $result->fetch_assoc()){
                echo "<tr><td>" . $row["TIMECODE"] . "</td><td>" . $row["DESCRIPTION"] . "</td>";
                if ($row["ISACTIVE"] == 1) {
                    echo "<td><input id='" . $row["TIMECODE"] . "' type='checkbox' onclick='updateActive(" . "\"" . $row["TIMECODE"] . "\"" . ")' checked /></td><td><button type='button' onclick='deleteRecord(" . "\"" . $row["TIMECODE"] . "\"" . ")'>Delete</button></td></tr>";
                } else {
                    echo "<td><input id='" . $row["TIMECODE"] . "' type='checkbox' onclick='updateActive(" . "\"" . $row["TIMECODE"] . "\"" . ")'/></td><td><button type='button' onclick='deleteRecord(" . "\"" . $row["TIMECODE"] . "\"" . ")'>Delete</button></td></tr>";
                }
            }
        } 
    }
    function checkCredentials($un, $pw) {
    
        $conn = getDatabaseConnection();
        
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
            $_SESSION["USERID"] = $un;
            $_SESSION["PASSWORD"] = $pw;  
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
        $sql = "SELECT TIMECODE, DESCRIPTION FROM TIMECODES WHERE ISACTIVE = 1 ORDER BY TIMECODE ASC;";
    
        // prepare/execute statement
        $result = getDatabaseConnection()->query($sql); 
    
        // loop through results and build sidenav list/links
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                echo "<option id='" . $row["TIMECODE"] . "'>" . $row["TIMECODE"] . " - " . $row["DESCRIPTION"] . "</option>";
            }
        } else {
            echo "<option id='NA'>No Options</option>";
        }
    }
    function adminList() {
        if(strcmp($_SESSION["USERID"],"admin") == 0) {
            echo "<li><a href='userManagement.php'>User Management</a></li>";
            echo "<li><a href='timeCodes.php'>Time Codes</a></li>";
            echo "<li><a href='reporting.php'>Reporting</a></li>";
        }
    }
    function authentication($isNotLogin) {
            // check if user has authenticated, if not, check to see if this is a request and look to pass credentials
        if ($isNotLogin) {
            if (!(strcmp($_SESSION["AUTHENTICATED"], "TRUE") == 0)) {
                $un = $_REQUEST["user"];
                $pw = $_REQUEST["password"];
                if (!checkCredentials($un,$pw)) {
                    header('Location: login.php');
                } 
            } 
        } else {
            if ((strcmp($_SESSION["AUTHENTICATED"], "TRUE") == 0)) {
                header('Location: home.php');
                 
            } else {
               
            }
        }
    }
    function loginAttempt() {
        if (strcmp($_SESSION["LOGINATTEMPT"],"TRUE") == 0) {
            echo "<label>Login Failed</label>";
            session_destroy();
        } 
    }
    function userList() {
        $conn = getDatabaseConnection();
        // create select string
        $sql = "SELECT USERNAME, FIRSTNAME, LASTNAME, PHONE, EMAIL FROM USERINFO WHERE USERNAME <> 'admin';";

        // prepare/execute statement
        $result = $conn->query($sql); 
        echo "<tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Email</th>
        </tr>";
        // loop through results and build sidenav list/links
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                echo "<tr><td>" . $row["USERNAME"] . "</td><td>" . $row["FIRSTNAME"] . "</td><td>" . $row["LASTNAME"] . "</td><td>" . $row["PHONE"] . "</td><td>" . $row["EMAIL"] . "</td>";
            }
        } 
    }
?>