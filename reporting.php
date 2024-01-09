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
            <button onclick="exportToExcel()">Export</button>
        </form>
    </div>
    <div class="table-container">
        <table class="timecodes" id="phpTest">

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
                document.getElementById("phpTest").innerHTML = xhr.responseText;
            }
        }
        });
        function exportToExcel() {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById("phpTest");
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            
            // Specify file name
            filename = 'excel_data.xls';
            
            // Create download link element
            downloadLink = document.createElement("a");
            
            document.body.appendChild(downloadLink);
            
            if(navigator.msSaveOrOpenBlob){
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob( blob, filename);
            } else{
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            
                // Setting the file name
                downloadLink.download = filename;
                
                //triggering the function
                downloadLink.click();
            }
    
        }
    </script>
</body>