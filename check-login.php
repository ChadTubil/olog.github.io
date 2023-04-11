<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");
    session_start();

    if(!(isset($_SESSION["s_id"]))) {
        header("location: default.php");
    }


    // echo $_SESSION["s_id"];
    $sqlStudent = "SELECT * FROM students_tbl WHERE stud_users_id = $_SESSION[s_id]";
    $queryStudent = mysqli_query($dbConString, $sqlStudent);
    $fetchStudent = mysqli_fetch_assoc($queryStudent);
    $SUI = $fetchStudent["stud_users_id"];
    if($SUI > 0){
        $STAT = $fetchStudent["stud_status"];

        if($STAT == 'Applicant'){
            header("location: message.php");
        }else if($STAT == 'Enroll'){
            header("location: enroll-2.php");
        }else if($STAT == 'Enroll-2'){
            header("location: enroll-3.php");
        }else if($STAT == 'Enroll-3'){
            header("location: enroll-3.php");
        }else if($STAT == 'Enroll-5'){
            header("location: enroll-5.php");
        }else if($STAT == 'Enroll-6'){
            header("location: enroll-6.php");
        }else if($STAT == 'Pay'){
            header("location: cashier-check.php");
        }else if($STAT == 'Paid'){
            header("location: enroll-8.php");
        }else if($STAT == 'Enrolled'){
            header("location: student/dashboard.php");
        }
    }else{
        header("location: form.php?id=".''.$_SESSION["s_id"]);
    }
    
    


?>