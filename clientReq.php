<?php 
    function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
    }
    function insertRecord($code, $desc) {
        $query = "INSERT INTO TIMECODES (TIMECODE, DESCRIPTION, ISACTIVE) VALUES ('" . $code . "','" . $desc . "',1);";
        executeSQL($query);
        returnTable();
    }
    function insertUser($user, $fname, $lname, $phone, $email, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO USERINFO (USERNAME, FIRSTNAME, LASTNAME, PHONE, EMAIL, PASSWORD) VALUES ('" . $user . "','" . $fname . "','" . $lname . "','" . $phone . "','" . $email . "','" . $password . "');";
        executeSQL($query);
        returnTable();
    }
    function updateRecord($code, $active) {
        $query = "UPDATE TIMECODES SET ISACTIVE = " . intval($active) . " WHERE TIMECODE = '" . $code . "';";
        executeSQL($query);
    }
    function deleteRecord() {
        
    }
    function executeSQL($sqlQuery) {
        $servername = "localhost:3306";
        $username1 = "root";
        $password1 = "vaXjev98";
        $dbname = "TIMECODES";
        $conn = new mysqli($servername,$username1,$password1,$dbname);
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
    function returnTable() {
        $tableHeaders = "<tr><th>Time Code</th><th>Description</th><th>Active</th></tr>";
        $servername = "localhost:3306";
        $username1 = "root";
        $password1 = "vaXjev98";
        $dbname = "TIMECODES";
        $conn = new mysqli($servername,$username1,$password1,$dbname);
        if ($conn->connect_error) {
            die("connection failed: " . $conn->connect_error);
        }

        // create select string
        $sql = "SELECT TIMECODE, DESCRIPTION, ISACTIVE FROM TIMECODES ORDER BY TIMECODE ASC, ISACTIVE ASC;";

        // prepare/execute statement
        $result = $conn->query($sql); 

        // loop through results and build sidenav list/links
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $tableRow = $tableRow . "<tr><td>" . $row["TIMECODE"] . "</td><td>" . $row["DESCRIPTION"] . "</td>";
                if ($row["ISACTIVE"] == 1) {
                    $tableRow = $tableRow . "<td><input id='" . $row["TIMECODE"] . "' type='checkbox' onclick='updateActive(" . "\"" . $row["TIMECODE"] . "\"" . ")' checked /></td></tr>";
                } else {
                    $tableRow = $tableRow . "<td><input id='" . $row["TIMECODE"] . "' type='checkbox' onclick='updateActive(" . "\"" . $row["TIMECODE"] . "\"" . ")'/></td</tr>";
                }
            }
        } 
        $table = $tableHeaders . $tableRow;
        echo $table;
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
            case "Update":
                $name = $data['name'];
                $active = $data['isActive'];
                updateRecord($name, $active);
                break;
            case "Delete":
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