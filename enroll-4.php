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

    $schedid = $_GET["schedid"];

    $sqlSched = "SELECT * FROM schedules_tbl WHERE sched_id = '$schedid'";
    $querySched = mysqli_query($dbConString, $sqlSched);
    $fetchSched = mysqli_fetch_assoc($querySched);

    if(isset($_POST['btnProceed'])) {

        $sqlEnrolls = "SELECT * FROM enroll_tbl WHERE en_isdel = 0 AND en_stud_id = '$id'";
        $queryEnrolls = mysqli_query($dbConString, $sqlEnrolls);
        $fetchEnrolls = mysqli_fetch_assoc($queryEnrolls);
        $ENSCHEDID = $fetchEnrolls['en_sched_id'];
        $ENID = $fetchEnrolls['en_id'];

        $sqlLeftPrice = "SELECT DISTINCT ss_subjects_id, sub_id, sub_price FROM sched_sub_tbl 
        LEFT JOIN subjects_tbl ON ss_subjects_id = sub_id WHERE ss_sched_id = '$ENSCHEDID'";
        $queryLeftPrice = mysqli_query($dbConString, $sqlLeftPrice);
        $total = 0;
        while($data = mysqli_fetch_array($queryLeftPrice)) {
             $total += $data['sub_price'];
            //other stuff you are doing with results, otherwise just do SQL sum.
        }
        // echo $total;

        // $sqlSUBSUM = "SELECT SUM(sub_price) AS TOTAL FROM enroll_tbl INNER JOIN subjects_tbl ON  en_sub_id = sub_id WHERE en_stud_id = '$id'";
        // $querySUBSUM = mysqli_query($dbConString, $sqlSUBSUM);
        // $fetchSUBSUM = mysqli_fetch_assoc($querySUBSUM);

        // $TOTALSUBFEE = $fetchSUBSUM['TOTAL'];

        $date = date('Y-m-d');

        $sqlAdd = "INSERT INTO cashier_tbl() VALUES (NULL, '$id', '$ENID', '$total', '', '', '', '', '$date', '', 'Process', 'No Mode of Payment', 0)";
        mysqli_query($dbConString, $sqlAdd);

        $sqlUpdateEN = "UPDATE enroll_tbl SET en_sched_id = '$schedid' WHERE en_stud_id = '$id'";
        mysqli_query($dbConString, $sqlUpdateEN);

        $sqlUpdateSTUD = "UPDATE students_tbl SET stud_status = 'Enroll-5' WHERE stud_id = '$id'";
        mysqli_query($dbConString, $sqlUpdateSTUD);

        header("location: enroll-5.php");
        
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
                <div>
                    <p>Schedule for: <strong style="color: black;">
                        <?php
                            $SCY = $fetchSched['sched_course_year_id'];

                            $sqlSection = "SELECT * FROM sections_tbl WHERE sec_id = '$SCY'";
                            $querySection= mysqli_query($dbConString, $sqlSection);
                            $fetchSection = mysqli_fetch_assoc($querySection);

                            print $fetchSection['sec_code'];
                        ?>
                    </strong></p>
                    <p style="color: red;">Check if your selected subject is on your schedule</p>
                    <br>
                    <div class="table-responsive">
                        <h2 style="color: black;">Monday</h2>
                        <table id="example" class="display" style="min-width: 500px;">
                            <thead>
                                <tr>
                                    <th style="color: black;">Subject</th>
                                    <th style="color: black;">Day</th>
                                    <th style="color: black;">Start</th>
                                    <th style="color: black;">End</th>
                                    <th style="color: black;">Professor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sqlSS = "SELECT * FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$schedid' AND ss_day = 'Monday'";
                                    $querySS = mysqli_query($dbConString, $sqlSS);
                                    while($fetchSS = mysqli_fetch_assoc($querySS)) {
                                ?>
                                <tr>
                                    <td style="color: black;">
                                        <?php 
                                            $SSSID = $fetchSS["ss_subjects_id"];

                                            $sqlSubject = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSID'";
                                            $querySubject = mysqli_query($dbConString, $sqlSubject);
                                            $fetchSubject = mysqli_fetch_assoc($querySubject);
                                            print $fetchSubject["sub_code"]; 
                                        ?>
                                    </td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_day"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_start"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_end"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_professor"]; ?></td>
                                    <td style="color: black; text-align: center;">
                                        <span>
                                            <a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit" style="color: blue"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close" style="color: red"><i class="fa fa-close color-danger"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <h2 style="color: black;">Tuesday</h2>
                        <table id="example" class="display" style="min-width: 500px;">
                            <thead>
                                <tr>
                                    <th style="color: black;">Subject</th>
                                    <th style="color: black;">Day</th>
                                    <th style="color: black;">Start</th>
                                    <th style="color: black;">End</th>
                                    <th style="color: black;">Professor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sqlSS = "SELECT * FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$schedid' AND ss_day = 'Tuesday'";
                                    $querySS = mysqli_query($dbConString, $sqlSS);
                                    while($fetchSS = mysqli_fetch_assoc($querySS)) {
                                ?>
                                <tr>
                                    <td style="color: black;">
                                        <?php 
                                            $SSSID = $fetchSS["ss_subjects_id"];

                                            $sqlSubject = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSID'";
                                            $querySubject = mysqli_query($dbConString, $sqlSubject);
                                            $fetchSubject = mysqli_fetch_assoc($querySubject);
                                            print $fetchSubject["sub_code"]; 
                                        ?>
                                    </td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_day"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_start"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_end"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_professor"]; ?></td>
                                    <td style="color: black; text-align: center;">
                                        <span>
                                            <a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit" style="color: blue"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close" style="color: red"><i class="fa fa-close color-danger"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <h2 style="color: black;">Wednesday</h2>
                        <table id="example" class="display" style="min-width: 500px;">
                            <thead>
                                <tr>
                                    <th style="color: black;">Subject</th>
                                    <th style="color: black;">Day</th>
                                    <th style="color: black;">Start</th>
                                    <th style="color: black;">End</th>
                                    <th style="color: black;">Professor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sqlSS = "SELECT * FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$schedid' AND ss_day = 'Wednesday'";
                                    $querySS = mysqli_query($dbConString, $sqlSS);
                                    while($fetchSS = mysqli_fetch_assoc($querySS)) {
                                ?>
                                <tr>
                                    <td style="color: black;">
                                        <?php 
                                            $SSSID = $fetchSS["ss_subjects_id"];

                                            $sqlSubject = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSID'";
                                            $querySubject = mysqli_query($dbConString, $sqlSubject);
                                            $fetchSubject = mysqli_fetch_assoc($querySubject);
                                            print $fetchSubject["sub_code"]; 
                                        ?>
                                    </td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_day"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_start"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_end"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_professor"]; ?></td>
                                    <td style="color: black; text-align: center;">
                                        <span>
                                            <a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit" style="color: blue"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close" style="color: red"><i class="fa fa-close color-danger"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <h2 style="color: black;">Thursday</h2>
                        <table id="example" class="display" style="min-width: 500px;">
                            <thead>
                                <tr>
                                    <th style="color: black;">Subject</th>
                                    <th style="color: black;">Day</th>
                                    <th style="color: black;">Start</th>
                                    <th style="color: black;">End</th>
                                    <th style="color: black;">Professor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sqlSS = "SELECT * FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$schedid' AND ss_day = 'Thursday'";
                                    $querySS = mysqli_query($dbConString, $sqlSS);
                                    while($fetchSS = mysqli_fetch_assoc($querySS)) {
                                ?>
                                <tr>
                                    <td style="color: black;">
                                        <?php 
                                            $SSSID = $fetchSS["ss_subjects_id"];

                                            $sqlSubject = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSID'";
                                            $querySubject = mysqli_query($dbConString, $sqlSubject);
                                            $fetchSubject = mysqli_fetch_assoc($querySubject);
                                            print $fetchSubject["sub_code"]; 
                                        ?>
                                    </td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_day"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_start"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_end"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_professor"]; ?></td>
                                    <td style="color: black; text-align: center;">
                                        <span>
                                            <a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit" style="color: blue"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close" style="color: red"><i class="fa fa-close color-danger"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <h2 style="color: black;">Friday</h2>
                        <table id="example" class="display" style="min-width: 500px;">
                            <thead>
                                <tr>
                                    <th style="color: black;">Subject</th>
                                    <th style="color: black;">Day</th>
                                    <th style="color: black;">Start</th>
                                    <th style="color: black;">End</th>
                                    <th style="color: black;">Professor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sqlSS = "SELECT * FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$schedid' AND ss_day = 'Friday'";
                                    $querySS = mysqli_query($dbConString, $sqlSS);
                                    while($fetchSS = mysqli_fetch_assoc($querySS)) {
                                ?>
                                <tr>
                                    <td style="color: black;">
                                        <?php 
                                            $SSSID = $fetchSS["ss_subjects_id"];

                                            $sqlSubject = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSID'";
                                            $querySubject = mysqli_query($dbConString, $sqlSubject);
                                            $fetchSubject = mysqli_fetch_assoc($querySubject);
                                            print $fetchSubject["sub_code"]; 
                                        ?>
                                    </td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_day"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_start"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_end"]; ?></td>
                                    <td style="color: black; text-align: center;"><?php print $fetchSS["ss_professor"]; ?></td>
                                    <td style="color: black; text-align: center;">
                                        <span>
                                            <a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit" style="color: blue"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close" style="color: red"><i class="fa fa-close color-danger"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <button class="btn btn-success" style="width: 25%" type="submit" name="btnProceed">Proceed to payment </button>
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