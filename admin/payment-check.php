<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
    }

    $id = $_GET['id'];

    $sqlCashier = "SELECT * FROM cashier_tbl WHERE cash_id = '$id'";
    $queryCashier = mysqli_query($dbConString, $sqlCashier);
    $fetchCashier = mysqli_fetch_assoc($queryCashier);

    $STAT = $fetchCashier["cash_mode"];

    if($STAT == 'Full'){
        header("location: payment-full.php?id=".''.$id);
    }else{
        header("location: payment-installment-checking.php?id=".''.$id);
    }
    


?>