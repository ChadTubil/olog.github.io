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

    $CStudId = $fetchCashier['cash_stud_id'];
    $CSTAT = $fetchCashier['cash_status'];

    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_id = '$CStudId'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);

    $sqlIns = "SELECT * FROM installments_tbl WHERE ins_cash_id = '$id'";
    $queryIns = mysqli_query($dbConString, $sqlIns);
    $fetchIns = mysqli_fetch_assoc($queryIns);
    $Terms = $fetchIns['ins_type'];
    $DP = $fetchIns['ins_dp'];
    if($Terms == 3){
        $INT = $DP * 0.03;
        $PERTERMS = $DP + $INT;
    }else{
        $INT = $DP * 0.05;
        $PERTERMS = $DP + $INT;
    }

    if(isset($_POST['btnSubmitDP'])) {

        $date = date('Y-m-d');

        $sqlUpdateIns = "UPDATE installments_tbl SET ins_dp_date = '$date', ins_mf_date = '$date' WHERE ins_cash_id = '$id'";
        mysqli_query($dbConString, $sqlUpdateIns);

        $sqlUpdate = "UPDATE cashier_tbl SET cash_status = 'DP PAID' WHERE cash_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        $sqlCheckPayment = "SELECT * FROM cashier_tbl WHERE cash_id = '$id'";
        $queryCheckPayment = mysqli_query($dbConString, $sqlCheckPayment);
        $fetchCheckPayment = mysqli_fetch_assoc($queryCheckPayment);

        if($fetchCheckPayment['cash_status'] == 'DP PAID'){
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = 'Enrolled' WHERE stud_id = '$CStudId'";
            mysqli_query($dbConString, $sqlUpdateStudent);

            header("location: cashier.php");
        }else{
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = 'Payment Refused' WHERE stud_id = '$CStudId'";
            mysqli_query($dbConString, $sqlUpdateStudent);

            header("location: cashier.php");
        }
        

    }
    if(isset($_POST['btnSubmitMid'])) {

        $date = date('Y-m-d');

        $sqlUpdateIns = "UPDATE installments_tbl SET ins_mid_date = '$date' WHERE ins_cash_id = '$id'";
        mysqli_query($dbConString, $sqlUpdateIns);

        $sqlUpdate = "UPDATE cashier_tbl SET cash_status = '1st Payment Paid' WHERE cash_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        $sqlCheckPayment = "SELECT * FROM cashier_tbl WHERE cash_id = '$id'";
        $queryCheckPayment = mysqli_query($dbConString, $sqlCheckPayment);
        $fetchCheckPayment = mysqli_fetch_assoc($queryCheckPayment);

        if($fetchCheckPayment['cash_status'] == '1st Payment Paid'){
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = '1st Payment Paid' WHERE stud_id = '$CStudId'";
            mysqli_query($dbConString, $sqlUpdateStudent);

            header("location: cashier.php");
        }else{
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = '1st Payment Refused' WHERE stud_id = '$CStudId'";
            mysqli_query($dbConString, $sqlUpdateStudent);

            header("location: cashier.php");
        }
        

    }
    if(isset($_POST['btnSubmitFinal'])) {

        $date = date('Y-m-d');

        $sqlUpdateIns = "UPDATE installments_tbl SET ins_final_date = '$date' WHERE ins_cash_id = '$id'";
        mysqli_query($dbConString, $sqlUpdateIns);

        $sqlUpdate = "UPDATE cashier_tbl SET cash_status = '2nd Payment Paid' WHERE cash_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        $sqlCheckPayment = "SELECT * FROM cashier_tbl WHERE cash_id = '$id'";
        $queryCheckPayment = mysqli_query($dbConString, $sqlCheckPayment);
        $fetchCheckPayment = mysqli_fetch_assoc($queryCheckPayment);

        if($fetchCheckPayment['cash_status'] == '2nd Payment Paid'){
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = '2nd Payment Paid' WHERE stud_id = '$CStudId'";
            mysqli_query($dbConString, $sqlUpdateStudent);

            header("location: cashier.php");
        }else{
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = '2nd Payment Refused' WHERE stud_id = '$CStudId'";
            mysqli_query($dbConString, $sqlUpdateStudent);

            header("location: cashier.php");
        }
        

    }
    
?>

<!DOCTYPE html>
<html lang="en">

<?php include '../body/head.php'; ?>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <?php include '../body/header.php'; ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->


        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php include '../body/sidebar.php'; ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>PAYMENTS</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Casheir</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <form method="post" role="form" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">PAYMENTS</h4>
                                    <!-- <span>
                                        <button class="btn btn-success" onclick="document.location.href='subjects-add.php'">Add Subject</button>
                                    </span> -->
                                </div>
                                <div class="card-body">
                                    <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <p style="color: black;">Student id: <strong><?php print "STD-00".''.$fetchStudents['stud_id']; ?></strong></p>
                                                </div>
                                                <div class="col-4">
                                                    <p style="color: black;">Address: <strong><?php print $fetchStudents['stud_address']; ?></strong></p>
                                                </div>
                                                <div class="col-4">
                                                    <p style="color: black;">Contact: <strong><?php print $fetchStudents['stud_phone']; ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p style="color: black;">Student Name: <strong><?php print $fetchStudents['stud_lastname'].', '.$fetchStudents['stud_firstname'].' '.$fetchStudents['stud_middlename']; ?></strong></p>
                                                </div>
                                                <div class="col-4">
                                                    <p style="color: black;">Email: <strong><?php print $fetchStudents['stud_email']; ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="color: black;">TUITION FEE</h3>
                                                    <!-- <span>
                                                        <button class="btn btn-success" onclick="document.location.href='subjects-add.php'">Add Subject</button>
                                                    </span> -->
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <p style="color: black; font-size: 16px;">Mode of Payment: 
                                                                <strong><u>
                                                                    <?php 
                                                                        print $fetchCashier['cash_mode']; 
                                                                    ?>
                                                                </u></strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">DOWNPAYMENT: <strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong>&nbsp&nbsp
                                                                <?php
                                                                    if($fetchIns['ins_dp_image'] == ''){
                                                                        print '<label style="background-color: red; padding-top: 2px; padding-botton: 2px;
                                                                        padding-left: 11px; padding-right: 11px; color: white; font-size: 10px;" >NOT PAID</label>';
                                                                    }else{
                                                                        print '<label style="background-color: green; padding-top: 2px; padding-botton: 2px;
                                                                        padding-left: 11px; padding-right: 11px; color: white; font-size: 12px;" >PAID</label>';
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">
                                                                <?php
                                                                if($Terms == 3){
                                                                    print "MID TERM: ";
                                                                }else{
                                                                    print "1ST TERM: ";
                                                                }
                                                                ?><strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong>&nbsp&nbsp
                                                                <?php
                                                                    if($fetchIns['ins_mid_image'] == ''){
                                                                        print '<label style="background-color: red; padding-top: 2px; padding-botton: 2px;
                                                                        padding-left: 11px; padding-right: 11px; color: white; font-size: 10px;" >NOT PAID</label>';
                                                                    }else{
                                                                        print '<label style="background-color: green; padding-top: 2px; padding-botton: 2px;
                                                                        padding-left: 11px; padding-right: 11px; color: white; font-size: 12px;" >PAID</label>';
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">
                                                                <?php
                                                                    if($Terms == 3){
                                                                        print "FINAL TERM: ";
                                                                    }else{
                                                                        print "2ND TERM: ";
                                                                    }
                                                                ?> <strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong>&nbsp&nbsp
                                                                <?php
                                                                    if($fetchIns['ins_final_image'] == ''){
                                                                        print '<label style="background-color: red; padding-top: 2px; padding-botton: 2px;
                                                                        padding-left: 11px; padding-right: 11px; color: white; font-size: 10px;" >NOT PAID</label>';
                                                                    }else{
                                                                        print '<label style="background-color: green; padding-top: 2px; padding-botton: 2px;
                                                                        padding-left: 11px; padding-right: 11px; color: white; font-size: 12px;" >PAID</label>';
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                        <p style="color: black; font-size: 15px;">MISC FEE: <strong><u><?php print "₱".' '.$fetchIns['ins_mf']; ?></u></strong>&nbsp&nbsp
                                                            <?php
                                                                if($fetchIns['ins_mf_image'] == ''){
                                                                    print '<label style="background-color: red; padding-top: 2px; padding-botton: 2px;
                                                                    padding-left: 11px; padding-right: 11px; color: white; font-size: 10px;" >NOT PAID</label>';
                                                                }else{
                                                                    print '<label style="background-color: green; padding-top: 2px; padding-botton: 2px;
                                                                    padding-left: 11px; padding-right: 11px; color: white; font-size: 12px;" >PAID</label>';
                                                                }
                                                            ?>
                                                        </p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">DISCOUNT: <strong><u><?php print "₱".' '.$fetchIns['ins_discount'];  ?></u></strong></p>
                                                        </div>
                                                        
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                        <p style="color: black; font-size: 16px;">TOTAL AMOUNT: 
                                                            <strong><u>
                                                                <?php 
                                                                    print "₱".' '.$fetchIns['ins_total']; 
                                                                ?>
                                                            </u></strong>
                                                        </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="color: black;">PROOF OF PAYMENT</h3>
                                                    <!-- <span>
                                                        <button class="btn btn-success" onclick="document.location.href='subjects-add.php'">Add Subject</button>
                                                    </span> -->
                                                </div>
                                                <hr>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-4" style="text-align: center;">
                                                            <h4>DP & MISC FEE</h4>
                                                            <button class="btn btn-success" 
                                                                <?php 
                                                                    if ($fetchIns["ins_dp_image"] == ''){ ?> disabled <?php   } 
                                                                    if ($CSTAT == 'DP PAID'){ ?> hidden <?php   } 
                                                                ?> 
                                                            style="width: 100%;" name="btnSubmitDP">ACCEPT</button>
                                                        </div>
                                                        <div class="col-8" style="text-align: center;">
                                                            <img src="../image/<?php print $fetchIns["ins_dp_image"]?>" style="width: 80%; height: 300px;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-4" style="text-align: center;">
                                                            <h4>MID TERM</h4>
                                                            <button class="btn btn-success" 
                                                                <?php 
                                                                    if ($fetchIns["ins_mid_image"] == ''){ ?> disabled <?php   } 
                                                                    if ($CSTAT == 'MID PAID'){ ?> hidden <?php   } 
                                                                ?> 
                                                            style="width: 100%;" name="btnSubmitMid">ACCEPT</button>
                                                        </div>
                                                        <div class="col-8" style="text-align: center;">
                                                            <img src="../image/<?php print $fetchIns["ins_mid_image"]?>" style="width: 80%; height: 300px;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-4" style="text-align: center;">
                                                            <h4>FINAL TERM</h4>
                                                            <button class="btn btn-success" 
                                                                <?php 
                                                                    if ($fetchIns["ins_final_image"] == ''){ ?> disabled <?php   } 
                                                                    if ($CSTAT == 'FINAL PAID'){ ?> hidden <?php   } 
                                                                ?> 
                                                            style="width: 100%;" name="btnSubmitFinal">ACCEPT</button>
                                                        </div>
                                                        <div class="col-8" style="text-align: center;">
                                                            <img src="../image/<?php print $fetchIns["ins_final_image"]?>" style="width: 80%; height: 300px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <?php include '../body/footer.php'; ?>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <?php include '../body/scripts.php'; ?>

</body>

</html>