<?php
	include '../db-controller.php';

	$id = $_GET['id'];

	$sqlCashier = "SELECT * FROM cashier_tbl WHERE cash_id = '$id'";
    $queryCashier = mysqli_query($dbConString, $sqlCashier);
    $fetchCashier = mysqli_fetch_assoc($queryCashier);

    $CStudId = $fetchCashier['cash_stud_id'];
    $CSTAT = $fetchCashier['cash_status'];

    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_id = '$CStudId'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);

    $sqlIns = "SELECT * FROM installments_tbl WHERE ins_cash_id = '$id'";
    $queryIns = mysqli_query($dbConString, $sqlIns);
    $fetchIns = mysqli_fetch_assoc($queryIns);
    $Terms = $fetchIns['ins_type'];

    if($Terms == 3){
        header("location: payment-installment2.php?id=".''.$id);
    }else{
        header("location: payment-installment.php?id=".''.$id);
    }

	
?>