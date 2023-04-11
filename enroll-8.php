<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");
    session_start();

    $id = $_SESSION["s_id"];

    
    
    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_users_id = '$id'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);
    $CYID = $fetchStudents["stud_course_year_id"];


?>

<!DOCTYPE html>
<html>
    <head>
        <title>SMS</title>
        <link rel="icon" type="image/png" sizes="16x16" href="image/GisulLogo.png">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="form/css/style.css" rel="stylesheet">
    </head>
    <body class="h-100" background="image/PulilanCP.jpg" style="background-size: 100% 100%; background-repeat: no-repeat; background-attachment: fixed;">
        <div class="testbox">
            <form  method="post" role="form" enctype="multipart/form-data">
                <div style="text-align: center;">
                    <img src="image/Pulilan.png" style="width: 10%">
                </div>
                <br>
                <br>
                <div style="text-align: left;">
                    <p style="font-size: 40px; color: black;">Hello! <?php print $fetchStudents["stud_firstname"]; ?></p>
                </div>
                <br>
                <br>
                <hr>
                <br>
                <br>
                <div style="text-align: left;">
                    <p style="font-size: 20px; color: black;">
                        Your payment is on checking by our admin, wait for the confirmation email, text message or 
                        <a href="default.php">login</a> your credential to check the status of your application. Thank you!
                    </p>

                    <br>
                    <br>
                    
                    <br>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <div style="text-align: center;">
                        <p style="color: black;">Developed & Powered by <a href="https://www.gisulpro.com/" target="_blank"><strong>Gisul Pro</strong></a> 
                        From <strong>Cajache Group</strong> 2021</p>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html> 