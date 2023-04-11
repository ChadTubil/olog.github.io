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

    if(isset($_POST['btnSubmit'])) {
        $txtPayment = $_POST['Payment'];

        $sqlUpdate = "UPDATE cashier_tbl SET cash_status = '$txtPayment' WHERE cash_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        $sqlCheckPayment = "SELECT * FROM cashier_tbl WHERE cash_id = '$id'";
        $queryCheckPayment = mysqli_query($dbConString, $sqlCheckPayment);
        $fetchCheckPayment = mysqli_fetch_assoc($queryCheckPayment);

        if($fetchCheckPayment['cash_status'] == 'Accept'){
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = 'Enrolled' WHERE stud_id = '$CStudId'";
            mysqli_query($dbConString, $sqlUpdateStudent);

            header("location: cashier.php");
        }else{
            $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = 'Payment Refused' WHERE stud_id = '$CStudId'";
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
                                                    <h3 class="card-title" style="color: black;">FULL FEE</h3>
                                                    <!-- <span>
                                                        <button class="btn btn-success" onclick="document.location.href='subjects-add.php'">Add Subject</button>
                                                    </span> -->
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">Total No. of Subjects: 
                                                                <strong><u>
                                                                    <?php 
                                                                        $sqlTOTALSUB = "SELECT COUNT(en_sub_id) AS SUBJECTTOTAL FROM enroll_tbl WHERE en_stud_id = '$CStudId'";
                                                                        $queryTOTALSUB = mysqli_query($dbConString, $sqlTOTALSUB);
                                                                        $fetchTOTALSUB = mysqli_fetch_assoc($queryTOTALSUB);

                                                                        print $fetchTOTALSUB['SUBJECTTOTAL']; 
                                                                    ?>
                                                                </u></strong>
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px; text-align: right;">Total No. of Units: 
                                                                <strong><u>
                                                                    <?php 
                                                                        $sqlTOTALUNIT = "SELECT SUM(sub_units) AS TOTALUNITS FROM enroll_tbl INNER JOIN subjects_tbl ON en_sub_id = sub_id WHERE en_stud_id = $CStudId";
                                                                        $queryTOTALUNIT = mysqli_query($dbConString, $sqlTOTALUNIT);
                                                                        $fetchTOTALUNIT = mysqli_fetch_assoc($queryTOTALUNIT);

                                                                        print $fetchTOTALUNIT['TOTALUNITS']; 
                                                                    ?>
                                                                </u></strong>
                                                            </p>
                                                        </div>
                                                    </div>
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
                                                        <div class="col-5">
                                                            <p style="color: black; font-size: 16px; text-align: right;">Status: 
                                                                <strong><u>
                                                                    <?php 
                                                                        print $fetchCashier['cash_status']; 
                                                                    ?>
                                                                </u></strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6" style="text-align: center;">
                                                            <h5 style="color: black;"><strong>FULL FEE</strong></h5>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">SUBJECTS FEE: <strong><u><?php print "₱".' '.$fetchCashier['cash_sub_fee_total']; ?></u></strong></p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">MISC FEE: <strong><u><?php print "₱".' '.$fetchCashier['cash_mf']; ?></u></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">TOTAL TUITION FEE: 
                                                                <strong><u>
                                                                    <?php 
                                                                        $CSFT = $fetchCashier['cash_sub_fee_total'];
                                                                        $CM = $fetchCashier['cash_mf'];

                                                                        $TotalWODISCOUNT = $CSFT + $CM;

                                                                        print "₱".' '.$TotalWODISCOUNT; 
                                                                
                                                                    ?>
                                                                </u></strong>
                                                            </p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">DISCOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_discount']; ?></u></strong></p>
                                                        </div>
                                                        
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">TOTAL AMOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_totalfee']; ?></u></strong></p>
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
                                                        <div class="col-2" style="text-align: center;">
                                                            
                                                        </div>
                                                        <div class="col-8" style="text-align: center;">
                                                            <img src="../image/<?php print $fetchCashier["cash_image"]?>" style="width: 100%; height: 400px;">
                                                        </div>
                                                        <div class="col-2" style="text-align: center;">
                                                            
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <select name="Payment" class="form-control" style="color: black; border-color: black;" <?php if ($fetchCashier["cash_status"] == 'Accept'){ ?> disabled <?php   } ?>>
                                                                <option value="Accept">Accept</option>
                                                                <option value="Refuse">Refuse</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-5">
                                                            <button class="btn btn-success" <?php if ($fetchCashier["cash_status"] == 'Accept'){ ?> disabled <?php   } ?> style="width: 100%;" name="btnSubmit">SUBMIT</button>
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