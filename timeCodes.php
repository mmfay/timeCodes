<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Time Codes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylesheets/timecodes.css">
</head>
<style>
</style>
<body>
    <h1 class="titleheader"> timeCodes </h1>
    <ul>
        <li><a href="home.php">Data Entry</a></li>
        <li><a href="#timecodeentry">Review Data</a></li>
        <?php
            session_start();
            if(strcmp($_SESSION["USERID"],"admin") == 0) {
                echo "<li><a href='userManagement.php'>User Management</a></li>";
                echo "<li><a href='timeCodes.php'>Time Codes</a></li>";
                echo "<li><a href='reporting.php'>Reporting</a></li>";
            }
        ?>
    </ul>
    <div class="headers">
        <h1>Create Time Codes</h1>
    </div>
    <div class="form-container">
        <form class="form" id="submissionForm">
            <label>Time Code
                <input type="text" id="newTC"></input>
            </label>
            <label>Description
                <input type="text" id="newDesc"></input>
            </label>
            <button type="submit">Submit</button>
        </form>
    </div>
    <div class="headers">
        <h1>Time Code List</h1>
    </div>
    <div class="table-container">
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
    </div>
    
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
        submissionForm.addEventListener("submit", (e) => {
            e.preventDefault();

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
        });
        </script>
</body>