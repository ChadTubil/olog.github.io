<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");
    session_start();

    $id = $_SESSION["s_id"];
    
    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_users_id = '$id'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);
    $CYID = $fetchStudents["stud_course_year_id"];

    $sqlSection = "SELECT * FROM sections_tbl WHERE sec_id = '$CYID'";
    $querySection = mysqli_query($dbConString, $sqlSection);
    $fetchSection = mysqli_fetch_assoc($querySection);

    $sqlCourse = "SELECT * FROM course_year_tbl WHERE cy_id = '$CYID'";
    $queryCourse = mysqli_query($dbConString, $sqlCourse);
    $fetchCourse = mysqli_fetch_assoc($queryCourse);

    $sqlSched = "SELECT * FROM schedules_tbl WHERE sched_course_year_id = '$CYID'";
    $querySched = mysqli_query($dbConString, $sqlSched);
    $fetchSched = mysqli_fetch_assoc($querySched);
    $SchedId = $fetchSched['sched_id'];
    

    if(isset($_POST['btnSubmit'])) {
        $txtSubject = $_POST['Subject'];

        header("location: enroll-4.php?schedid=".''.$SchedId);
        
    }

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
                        Selected level: <strong><?php print $fetchSection['sec_year'].' ('.$fetchSection['sec_code'].')'; ?></strong>
                    </p>
                </div>
                <br>
                <br>
                <div class="colums">
                    <div class="item">
                        <label style="color: black">View Schedule</label>
                        <h2 style="color: black;"><?php print $fetchSection['sec_code']; ?></h2>
                        <button class="btn btn-success" type="submit" name="btnSubmit">View </button>
                    </div>
                </div>
                <br>
                <br>
            </form>
        </div>
        <br>
        <br>
        <br>
        <div style="text-align: center;">
            <p style="color: black;">Copyright © Designed &amp; Developed by <a href="https://www.gisulpro.com/" target="_blank">Gisul Pro</a> 2021</p>
        </div>
    </body>
</html> 