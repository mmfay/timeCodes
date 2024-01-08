<?php
    include 'external.php';
    session_start();
    authentication(TRUE);
?>
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
            adminList();
        ?>
        <li><a onclick='logout()' href="login.php">Logout</a></li>
    </ul>
    <div class="headers">
        <h1>Run Reports</h1>
    </div>
    <div class="reporting-container">
        <form class="form" id="reportingSubmit">
            <select id="years" name="years">
                <?php 
                    printReportYearOptions();
                ?>
            </select>
            <select id="users" name="users">
                <?php 
                    printUserNameOptions();
                ?>
            </select>
            <button type="submit">Submit</button>
        </form>
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
        reportingSubmit.addEventListener("submit", (e) => {
            e.preventDefault();

            var postData = {
                title: "Select",
                name: "reporting",
                timeRange: years.options[years.selectedIndex].id,
                userRange: users.options[users.selectedIndex].id
            }
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "clientReq.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(postData));
            xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                //document.getElementById("phpTest").innerHTML = xhr.responseText;
            }
        }
        });
    </script>
</body>