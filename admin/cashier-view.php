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
                                                        <p style="color: black; font-size: 16px;">MISC FEE: <strong><u><?php print "₱".' '.$fetchCashier['cash_mf']; ?></u></strong></p>
                                                    </div>
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
                                                        <p style="color: black; font-size: 16px;">TOTAL TUITION FEE: 
                                                            <strong><u>
                                                                <?php 
                                                                    $CSFT = $fetchSUBSUM['cash_sub_fee_total'];
                                                                    $CM = $fetchCashier['cash_mf'];

                                                                    $TotalWODISCOUNT = $CSFT + $CM;

                                                                    print "₱".' '.$TotalWODISCOUNT; 
                                                            
                                                                ?>
                                                            </u></strong>
                                                        </p>
                                                    </div>
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
                                                        <p style="color: black; font-size: 16px;">DISCOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_discount']; ?></u></strong></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p style="color: black; font-size: 16px;">
                                                            
                                                            <?php
                                                                if($Terms == 3){
                                                                    print "";
                                                                }else{
                                                                    print "3RD TERM: ".''."<strong><u> ₱".''.$PERTERMS.''."</u></strong>";
                                                                }
                                                            ?>&nbsp&nbsp
                                                            <?php
                                                                if($fetchIns['ins_third_image'] == ''){
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

                                                    </div>
                                                    <div class="col-6">
                                                        <p style="color: black; font-size: 16px;">
                                                                <?php
                                                                    if($Terms == 3){
                                                                        print "";
                                                                    }else{
                                                                        print "4TH TERM: ".''."<strong><u> ₱".''.$PERTERMS.''."</u></strong>";
                                                                    }
                                                                ?>&nbsp&nbsp
                                                                <?php
                                                                    if($fetchIns['ins_fourth_image'] == ''){
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

                                                    </div>
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

                                                    </div>
                                                    <div class="col-6">
                                                        <p style="color: black; font-size: 16px;">DISCOUNT: <strong><u><?php print "₱".' '.$fetchIns['ins_discount'];  ?></u></strong></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p style="color: black; font-size: 16px;">TOTAL AMOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_totalfee']; ?></u></strong></p>
                                                    </div>
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
                                </div>
                            </div>
                        </div>
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