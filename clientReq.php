<?php 
    function insertRecord($code, $desc) {
        $servername = "localhost:3306";
        $username1 = "root";
        $password1 = "vaXjev98";
        $dbname = "TIMECODES";
        $conn = new mysqli($servername,$username1,$password1,$dbname);
        if ($conn->connect_error) {
            die("connection failed: " . $conn->connect_error);
        }
        $sql = $conn->prepare("INSERT INTO TIMECODES (TIMECODE, DESCRIPTION, ISACTIVE) VALUES ('" . $code . "','" . $desc . "',1);");
        // execute
        $sql->execute();
        $conn->close();
    }
    function updateRecord($code, $active) {
        $servername = "localhost:3306";
        $username1 = "root";
        $password1 = "vaXjev98";
        $dbname = "TIMECODES";
        $conn = new mysqli($servername,$username1,$password1,$dbname);
        if ($conn->connect_error) {
            die("connection failed: " . $conn->connect_error);
        }
        // prepare statement
        $sql = $conn->prepare("UPDATE TIMECODES SET ISACTIVE = " . intval($active) . " WHERE TIMECODE = '" . $code . "';");
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
        if (strcmp($type, "Update") == 0) {
            $name = $data['name'];
            $active = $data['isActive'];
            updateRecord($name, $active);
        } else if (strcmp($type, "New") == 0) {
            $code = $data['code'];
            $desc = $data['desc'];
            insertRecord($code, $desc);
        }
    
} else {
   // JSON decoding failed
   http_response_code(400); // Bad Request
   echo "Invalid JSON data";
}
/*
    $servername = "localhost:3306";
    $username1 = "root";
    $password1 = "vaXjev98";
    $dbname = "TIMECODES";
    $conn = new mysqli($servername,$username1,$password1,$dbname);
    if ($conn->connect_error) {
        die("connection failed: " . $conn->connect_error);
    }
    // prepare statement
	$sql = $conn->prepare("UPDATE TIMECODES SET ISACTIVE = " . intval($active) . " WHERE TIMECODE = '" . $name . "';");
	//$sql = $conn->prepare("UPDATE TIMECODES SET ISACTIVE = 0 WHERE TIMECODE = '100A';";
	// execute
	$sql->execute();
    $conn->close();
*/

?>