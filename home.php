<?php
    include 'external.php';
    session_start();
    authentication(TRUE);
?>
<!DOCTYPE html>
<html>
<head>
    <title>timeCodes</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../stylesheets/timecodes.css">
</head>
<body>
    <h1 class="titleheader"> timeCodes </h1>
    <ul>
        <li><a href="#home">Data Entry</a></li>
        <li><a href="#timecodeentry">Review Data</a></li>
        <?php
            adminList();
        ?>
        <li><a onclick='logout()' href="login.php">Logout</a></li>
    </ul>
    <div class="form-container">
        <form class="form" id="timeCodeSubmit">
            <label>Time Code
                <select name="timeCodes" id="timeCodes">
                    <?php 
                        printOptions();
                    ?>
                </select>
            </label>
            <button type="submit">Submit</button>
        </form>
    </div>
    <div class="table-container">
        <table class="timecodes" id="phpTest">
        <colgroup width="150">
            <col span="1">
            <col span="2" style="background-color: #D6EEEE" width="250px">
        </colgroup>
            <?php 
                dailyCodes();
            ?>
        </table>
    </div>
    <script>
        function logout() {
            var postData = {
            title: "Logout"
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
        timeCodeSubmit.addEventListener("submit", (e) => {
            e.preventDefault();

            var postData = {
                title: "InsertTimeCode",
                name: "timecode",
                timeCode: timeCodes.options[timeCodes.selectedIndex].id
            }
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "clientReq.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(postData));
            xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                //no table to update now, just posting.
                document.getElementById("phpTest").innerHTML = xhr.responseText;
            }
        }
        });
    </script>
</body>