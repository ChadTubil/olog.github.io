<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");
    session_start();

    $id = $_SESSION["s_id"];

    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_users_id = '$id'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);
    $CYID = $fetchStudents["stud_course_year_id"];
    $StudId = $fetchStudents["stud_id"];

    $sqlCashier = "SELECT * FROM cashier_tbl WHERE cash_stud_id = '$id'";
    $queryCashier = mysqli_query($dbConString, $sqlCashier);
    $fetchCashier = mysqli_fetch_assoc($queryCashier);
    $CStudId = $fetchCashier['cash_stud_id'];
    $CSId = $fetchCashier['cash_id'];

    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_id = '$CStudId'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);

    $sqlIns = "SELECT * FROM installments_tbl WHERE ins_cash_id = '$CSId'";
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

    if(isset($_POST['btnNext'])) {
        $txtMode = $_POST['Mode'];

        $sqlUpdate = "UPDATE cashier_tbl SET cash_mode = '$txtMode', cash_status = 'Pay'
        WHERE cash_id = '$CSId'";
        mysqli_query($dbConString, $sqlUpdate);

        $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = 'Pay' WHERE stud_id = '$CStudId'";
        mysqli_query($dbConString, $sqlUpdateStudent);

        header("location: cashier-check.php");

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
                        Your tuition is processed by our admin.
                    </p>
                    <br>
                    <p style="font-size: 16px; color: black;">This is your processed tuition fee.</p>
                    <br>
                    <br>
                                        <form method="post">
                                            <div class="card-body">
                                                <div class="colums">
                                                    <div class="item">
                                                        <label for="city" style="color: black;">Choose the payment you want to use<span> *</span></label>
                                                        <select name="Mode" style="color: black; border-color: black;">
                                                            <option value="Full">Full </option>
                                                            <option value="Installment">Installment</option>
                                                        </select>
                                                        <button class="btn btn-success" name="btnNext"> NEXT </button>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="colums">
                                                    <div class="item">
                                                        <h2 style="color: black;"><strong>FULL FEE</strong></h2>
                                                    </div>
                                                    <div class="item">
                                                        <h2 style="color: black;"><strong>INSTALLMENT FEE</strong></h2>
                                                    </div>
                                                </div>
                                                <div class="colums">
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">SUBJECTS FEE: <strong><u><?php print "₱".' '.$fetchCashier['cash_sub_fee_total']; ?></u></strong></p>
                                                    </div>
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">DOWNPAYMENT: <strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="colums">
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">MISC FEE: <strong><u><?php print "₱".' '.$fetchCashier['cash_mf']; ?></u></strong></p>
                                                    </div>
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">
                                                        <?php
                                                            if($Terms == 3){
                                                                print "MID TERM: ";
                                                            }else{
                                                                print "1ST TERM: ";
                                                            }
                                                        ?>
                                                         <strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong></p>
                                                    </div>
                                                </div>
                                                <div class="colums">
                                                    <div class="item">
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
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">
                                                        <?php
                                                            if($Terms == 3){
                                                                print "FINAL TERM: ";
                                                            }else{
                                                                print "2ND TERM: ";
                                                            }
                                                        ?><strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="colums">
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">DISCOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_discount']; ?></u></strong></p>
                                                    </div>
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">
                                                        <?php
                                                            if($Terms == 3){
                                                                print "";
                                                            }else{
                                                                print "3RD TERM: ".''."<strong><u> ₱".''.$PERTERMS.''."</u></strong>";
                                                            }
                                                        ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="colums">
                                                    <div class="item">

                                                    </div>
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">
                                                        <?php
                                                            if($Terms == 3){
                                                                print "";
                                                            }else{
                                                                print "4TH TERM: ".''."<strong><u> ₱".''.$PERTERMS.''."</u></strong>";
                                                            }
                                                        ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="colums">
                                                    <div class="item">

                                                    </div>
                                                    <div class="item">
                                                        <p style="color: black; font-size: 15px;">MISC FEE: <strong><u><?php print "₱".' '.$fetchIns['ins_mf']; ?></u></strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="colums">
                                                    <div class="item">

                                                    </div>
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">DISCOUNT: <strong><u><?php print "₱".' '.$fetchIns['ins_discount'];  ?></u></strong></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="colums">
                                                    <div class="item">
                                                        <p style="color: black; font-size: 16px;">TOTAL AMOUNT: <strong><u><?php print "₱".' '.$fetchCashier['cash_totalfee']; ?></u></strong></p>
                                                    </div>
                                                    <div class="item">
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
                                        </form>
                    <br>
                    <hr>
                    <br>
                    <div style="text-align: center;">
                        <p style="color: black;">Developed & Powered by <a href="https://www.gisulpro.com/" target="_blank"><strong>Gisul Pro</strong></a> 
                        From <strong>Cajache Group</strong> 2021</p>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html> 