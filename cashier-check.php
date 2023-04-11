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
    $StudId = $fetchStudent['stud_id'];

    $sqlCashier = "SELECT * FROM cashier_tbl WHERE cash_stud_id = '$StudId'";
    $queryCashier = mysqli_query($dbConString, $sqlCashier);
    $fetchCashier = mysqli_fetch_assoc($queryCashier);

    $STAT = $fetchCashier["cash_mode"];

    if($STAT == 'Full'){
        header("location: enroll-7.php");
    }else{
        header("location: enroll-7-1.php");
    }
    


?>