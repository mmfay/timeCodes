<?php
    echo $_POST["user"]
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    margin-bottom: 1%;
}
input[type=text], select {

  padding: 12px 20px;
  margin: 8px 0;
  width: 100%;
  display: block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
.form-container {
    margin-left: auto;
    margin-right: auto;
    justify-content: center;
    align-items: center;

}
.form {
    
    padding-left: 40%;
    padding-right: 40%;
    padding-bottom: 5%;
}
button {
    width: 100%;
    background-color: blue;
    color: white;
    border-radius: 25px;
    height: 40px;
}
@media only screen and (max-width: 1000px) {
    .form {
        padding-left: 0%;
    padding-right: 0%;  
    }
}
.headers {
    margin-left: auto;
    margin-right: auto;
    padding-left: 35%;
    padding-right: 35%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: red;
    margin-bottom: 1%;
}
</style>
<body>
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
        </from>
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
    <div class="headers">
        <h1>Run Reports</h1>
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