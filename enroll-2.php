<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");
    session_start();

    $id = $_SESSION["s_id"];
    
    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_users_id = '$id'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);
    $CYID = $fetchStudents["stud_course_year_id"]; //section id
    $StudId = $fetchStudents['stud_id'];

    $sqlSection = "SELECT * FROM sections_tbl WHERE sec_id = '$CYID'";
    $querySection = mysqli_query($dbConString, $sqlSection);
    $fetchSection = mysqli_fetch_assoc($querySection);
    $SecCY = $fetchSection['sec_course_year_id'];

    $sqlSchedule = "SELECT * FROM schedules_tbl WHERE sched_course_year_id = '$CYID'";
    $querySchedule = mysqli_query($dbConString, $sqlSchedule);
    $fetchSchedule = mysqli_fetch_assoc($querySchedule);
    $SCHEDID = $fetchSchedule['sched_id'];

    if(isset($_POST['btnNext'])) {

        $sqlCheck = "SELECT en_sub_id FROM enroll_tbl WHERE en_stud_id = '$StudId'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){

        }else{
            $sqlAdd = "INSERT INTO enroll_tbl() VALUES (NULL, '$StudId', '$CYID', '', '$SCHEDID', '$date', 
            '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            $sqlUpdate = "UPDATE students_tbl SET stud_status = 'Enroll-3' WHERE stud_id = '$id'";
            mysqli_query($dbConString, $sqlUpdate);

            header("location: enroll-3.php");
        }
        
        
        
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
                        <h2 style="color: black">Subject to take:</h2>
                    </div>
                </div>
                <div style="text-align: left">
                    <div class="table-responsive">
                        <table id="example" class="display">
                            <tbody>
                                <?php
                                    $sqlSched = "SELECT * FROM schedules_tbl WHERE sched_course_year_id = '$CYID'";
                                    $querySched = mysqli_query($dbConString, $sqlSched);
                                    $fetchSched = mysqli_fetch_assoc($querySched);
                                    $SchedId = $fetchSched['sched_id'];

                                    $sqlSS = "SELECT DISTINCT ss_subjects_id FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$SchedId'";
                                    $querySS = mysqli_query($dbConString, $sqlSS);
                                    while($fetchSS = mysqli_fetch_assoc($querySS)) {
                                ?>
                                <tr>
                                    <td style="color: black; text-align: left;">
                                        <?php 
                                            $SubId = $fetchSS["ss_subjects_id"];

                                            $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_id = '$SubId'";
                                            $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                            $fetchSubjects = mysqli_fetch_assoc($querySubjects);
                                            print $fetchSubjects["sub_name"] 
                                        ?>
                                    </td>
                                    <td style="color: black; text-align: center;">
                                        
                                    </td>
                                    <td style="color: black; text-align: center;">
                                        
                                    </td>
                                    <td style="color: black; text-align: center;">
                                        
                                    </td>
                                    <td style="color: black; text-align: center;">
                                        -
                                    </td>
                                    <td style="color: black; text-align: center;">
                                        
                                    </td>
                                    <td style="color: black; text-align: center;">
                                        
                                    </td>
                                    <td style="color: black; text-align: center;">
                                        
                                    </td>
                                    <td style="color: black; text-align: left;">
                                        <?php 
                                            $SubId = $fetchSS["ss_subjects_id"];

                                            $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_id = '$SubId'";
                                            $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                            $fetchSubjects = mysqli_fetch_assoc($querySubjects);
                                            print $fetchSubjects["sub_code"] 
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <button class="btn btn-success" type="submit" name="btnNext">NEXT</button>
                </div>
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