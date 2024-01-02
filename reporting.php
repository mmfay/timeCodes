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
        <h1>Run Reports</h1>
    </div>
    <div class="reporting">
        <select id="years" name="years">
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>
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