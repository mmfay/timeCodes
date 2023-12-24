<?php
    echo $_POST["user"]
?>
<!DOCTYPE html>
<html>
<head>
    <title>timeCodes</title>
</head>
<style>
table, th, td {
  border:1px solid black;
  width: 50%;
}
.timecodes {
    margin-left: auto;
    margin-right: auto;
    margin-top: 20%;
}
.timeCodeEntry {
    margin: auto;
    position: absolute;
    display: block;
}
input[type=text], select {
  width: 10%;
  padding: 12px 20px;
  margin: 8px 0;
  display: block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
</style>
<body>
<button onclick="submit()">Submit1</button>
    <form class="timeCodeEntry">
        <label>Time Code
        <input type="text" id="newTC"></input>
        </label>
        <label>Description
        <input type="text" id="newDesc"></input>
        </label>
    </from>
    <table class="timecodes" id="phpTest">
        <tr>
            <th>Time Code</th>
            <th>Description</th>
            <th>Active</th>
        </tr>
        <?php
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
                echo "<tr><td>" . $row["TIMECODE"] . "</td><td>" . $row["DESCRIPTION"] . "</td>";
                if ($row["ISACTIVE"] == 1) {
                    echo "<td><input id='" . $row["TIMECODE"] . "' type='checkbox' onclick='updateActive(" . "\"" . $row["TIMECODE"] . "\"" . ")' checked /></td></tr>";
                } else {
                    echo "<td><input id='" . $row["TIMECODE"] . "' type='checkbox' onclick='updateActive(" . "\"" . $row["TIMECODE"] . "\"" . ")'/></td</tr>";
                }
            }
        } 

	
    ?>
    </table>
    <script>
        function updateActive(test) {
            var active = "";
            if (document.getElementById(test).checked) {
                active = "1";
            } else {
                active = "0";
            }
            var postData = {
            title: "Update",
            name: test,
            isActive: active
            };
         var xhr = new XMLHttpRequest();
         xhr.open("POST", "clientReq.php", true);
         xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
         xhr.send(JSON.stringify(postData));
         xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 201) {
          
            } else {
         
            }
         };
        }
        function submit() {
            var postData = {
                title: "Insert",
                name: "timeCode",
                code: document.getElementById("newTC").value,
                desc: document.getElementById("newDesc").value,
            }
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "clientReq.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(postData));
            xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                document.getElementById("phpTest").innerHTML = xhr.responseText;
            }
}
        }
        </script>
</body>