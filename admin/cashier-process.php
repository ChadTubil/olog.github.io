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
    $CSFT = $fetchCashier['cash_sub_fee_total'];

    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_id = '$CStudId'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);

    if(isset($_POST['btnFull'])) {
        //full

        $txtMF = $_POST['MF'];
        if($txtMF == ''){
            $MF = '0';
        }else{
            $MF = $txtMF;
        }
        $txtDiscount = $_POST['Discount'];
        if($txtDiscount == ''){
            $D1 = '0';
        }else{
            $D1 = $txtDiscount;
        }
        $SUMFULL = $CSFT + $MF;

        $TOTALFULL = $SUMFULL - $D1;

        //installment

        $txtMF2 = $_POST['MF2'];
        if($txtMF2 == ''){
            $MF2 = '0';
        }else{
            $MF2 = $txtMF2;
        }

        $txtDiscount2 = $_POST['Discount2'];
        if($txtDiscount2 == ''){
            $D2 = '0';
        }else{
            $D2 = $txtDiscount2;
        }

        
        $txtTerms = $_POST['Terms'];
        $PerTerms = $CSFT / $txtTerms;
        if($txtTerms == '3'){
            $NewTotalSubFee = $PerTerms * 3;
            $SubFeeInt = $NewTotalSubFee * 0.03;
            $TFWithInt = $NewTotalSubFee + $SubFeeInt;
            $TOTALWDIS2 = $SubFeeInt - $D2;
            $TOTALFEE = $TOTALWDIS2 + $txtMF2;

            $sqlUpdate = "UPDATE cashier_tbl SET cash_mf = '$MF', cash_discount = '$D1', cash_totalfee = '$TOTALFULL', cash_status = 'Processed' WHERE cash_id = '$id'";
            mysqli_query($dbConString, $sqlUpdate);

            $sqlCheck = "SELECT ins_cash_id FROM installments_tbl WHERE ins_cash_id = '$id'";
            $queryCheck = mysqli_query($dbConString, $sqlCheck);

            if(mysqli_num_rows($queryCheck) > 0){
                $message = "Installment Fee is already exists.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }else{
                $sqlAdd = "INSERT INTO installments_tbl() VALUES (NULL, '$id', '$txtTerms', '$PerTerms', '', '$PerTerms', '', '', '',
                '', '', '', '', '', '', '$txtMF2', '', '$txtDiscount2', '$TOTALFEE', '', '', '', '', 0)";
                mysqli_query($dbConString, $sqlAdd);
            }
        }else{
            $NewTotalSubFee = $PerTerms * 5;
            $SubFeeInt = $NewTotalSubFee * 0.05;
            $TFWithInt = $NewTotalSubFee + $SubFeeInt;
            $TOTALWDIS2 = $TFWithInt - $D2;
            $TOTALFEE = $TOTALWDIS2 + $txtMF2;

            $sqlUpdate = "UPDATE cashier_tbl SET cash_mf = '$MF', cash_discount = '$D1', cash_totalfee = '$TOTALFULL', cash_status = 'Processed' WHERE cash_id = '$id'";
            mysqli_query($dbConString, $sqlUpdate);

            $sqlCheck = "SELECT ins_cash_id FROM installments_tbl WHERE ins_cash_id = '$id'";
            $queryCheck = mysqli_query($dbConString, $sqlCheck);

            if(mysqli_num_rows($queryCheck) > 0){
                $message = "Installment Fee is already exists.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }else{
                $sqlAdd = "INSERT INTO installments_tbl() VALUES (NULL, '$id', '$txtTerms', '$PerTerms', '', '$PerTerms', '', '$PerTerms', '',
                '$PerTerms', '', '$PerTerms', '', '', '', '$txtMF2', '', '$txtDiscount2', '$TOTALFEE', '', '', '', '', 0)";
                mysqli_query($dbConString, $sqlAdd);
            }
        }
        $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = 'Enroll-6' WHERE stud_id = '$CStudId'";
        mysqli_query($dbConString, $sqlUpdateStudent);
        
        header("location: cashier.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php include '../body/head.php'; ?>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <!-- <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div> -->
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
                            <h4>LIST OF FEES</h4>
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
                                    <h4 class="card-title">FEES</h4>
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
                                                <div class="card-body">
                                                    <p style="color: black">Subject taken</p>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th style="color: black; text-align: center;">Code</th>
                                                                    <th style="color: black; text-align: center;">Subject</th>
                                                                    <th style="color: black; text-align: center;">Unit(s)</th>
                                                                    <th style="color: black; text-align: center;">Field</th>
                                                                    <th style="color: black; text-align: center;">Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $sqlEnroll = "SELECT * FROM enroll_tbl WHERE en_isdel = 0 AND en_stud_id = '$CStudId'";
                                                                    $queryEnroll = mysqli_query($dbConString, $sqlEnroll);
                                                                    $fetchEnroll = mysqli_fetch_assoc($queryEnroll);
                                                                    $ESCHEDID = $fetchEnroll['en_sched_id'];
                                                                    
                                                                    $sqlSchedSub = "SELECT DISTINCT ss_subjects_id FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$ESCHEDID'";
                                                                    $querySchedSub = mysqli_query($dbConString, $sqlSchedSub);
                                                                    while($fetchSchedSub = mysqli_fetch_assoc($querySchedSub)) {
                                                                        
                                                                ?>
                                                                <tr>
                                                                    <td style="color: black; text-align: center;">
                                                                        <?php 
                                                                            $SSSubId = $fetchSchedSub['ss_subjects_id'];
                                                                            
                                                                            $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSubId'";
                                                                            $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                                                            $fetchSubjects = mysqli_fetch_assoc($querySubjects);
                                                                            print $fetchSubjects["sub_code"];
                                                                        ?>
                                                                    </td>
                                                                    <td style="color: black; text-align: center;">
                                                                        <?php 

                                                                            $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSubId'";
                                                                            $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                                                            $fetchSubjects = mysqli_fetch_assoc($querySubjects);
                                                                            print $fetchSubjects["sub_name"] 
                                                                        ?>
                                                                    </td>
                                                                    <td style="color: black; text-align: center;">
                                                                        <?php 

                                                                            $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSubId'";
                                                                            $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                                                            $fetchSubjects = mysqli_fetch_assoc($querySubjects);
                                                                            print $fetchSubjects["sub_units"] 
                                                                        ?>
                                                                    </td>
                                                                    <td style="color: black; text-align: center;">
                                                                        <?php 

                                                                            $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSubId'";
                                                                            $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                                                            $fetchSubjects = mysqli_fetch_assoc($querySubjects);
                                                                            print $fetchSubjects["sub_field"] 
                                                                        ?>
                                                                    </td>
                                                                    <td style="color: black; text-align: center;">
                                                                        <?php 

                                                                            $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSubId'";
                                                                            $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                                                            $fetchSubjects = mysqli_fetch_assoc($querySubjects);
                                                                            print "₱".''.$fetchSubjects["sub_price"] 
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div style="text-align: right;">
                                                        <p style="color: black;">TOTAL:
                                                            <strong>
                                                                <?php
                                                                    $sqlSUBSUM = "SELECT * FROM cashier_tbl WHERE cash_isdel = 0 AND cash_stud_id = '$CStudId'";
                                                                    $querySUBSUM = mysqli_query($dbConString, $sqlSUBSUM);
                                                                    $fetchSUBSUM = mysqli_fetch_assoc($querySUBSUM);

                                                                    print "₱".''.$fetchSUBSUM['cash_sub_fee_total'];
                                                                ?>
                                                            </strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                            <p style="color: black; font-size: 16px;">Total No. of Units: 
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
                                                            <p style="color: black; font-size: 16px;">Status: 
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
                                                        <div class="col-6" style="text-align: center;">
                                                            <h5 style="color: black;"><strong>INSTALLMENT FEE</strong></h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">SUBJECTS FEE: <strong><u><?php print "₱".' '.$fetchSUBSUM['cash_sub_fee_total']; ?></u></strong></p>
                                                        </div>
                                                        <div class="col-6">
                                                            <label style="color: black;">Installement Terms:</label>
                                                            <select class="form-control" name="Terms" required style="color: black; border-color: black;">
                                                                <option value="3">3 Terms</option>
                                                                <option value="5">5 Terms</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label style="color: black;">MISCELLANEOUS</label>
                                                            <input type="number" class="form-control" name="MF" placeholder="₱ 0.00" style="color: black; border-color: black;">
                                                        </div>
                                                        <div class="col-6">
                                                            <label style="color: black;">MISCELLANEOUS</label>
                                                            <input type="number" class="form-control" name="MF2" placeholder="₱ 0.00" style="color: black; border-color: black;">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label style="color: black;">DISCOUNT</label>
                                                            <input type="number" class="form-control" name="Discount" placeholder="₱ 0.00" style="color: black; border-color: black;">
                                                        </div>
                                                        <div class="col-6">
                                                            <label style="color: black;">DISCOUNT</label>
                                                            <input type="number" class="form-control" name="Discount2" placeholder="₱ 0.00" style="color: black; border-color: black;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">TOTAL AMOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_totalfee']; ?></u></strong></p>
                                                            <button class="btn btn-success btn-sm" style="width: 50%"name="btnFull">SAVE</button>
                                                        </div>
                                                        <div class="col-6">
                                                            <p style="color: black; font-size: 16px;">TOTAL AMOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_totalfee']; ?></u></strong></p>
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