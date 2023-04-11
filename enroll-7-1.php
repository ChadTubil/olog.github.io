<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");
    session_start();

    $id = $_SESSION["s_id"];

    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_users_id = '$id'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);
    $CYID = $fetchStudents["stud_course_year_id"];

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

    if(isset($_POST['btnSubmit'])) {
        $txtImage = $_FILES["image"]['name'];

        $sqlUpdate = "UPDATE installments_tbl SET ins_dp_image = '$txtImage', ins_mf_image = '$txtImage'
        WHERE ins_cash_id = '$CSId'";
        mysqli_query($dbConString, $sqlUpdate);

        $sqlUpdateStudent = "UPDATE students_tbl SET stud_status = 'Paid' WHERE stud_id = '$CStudId'";
        mysqli_query($dbConString, $sqlUpdateStudent);

        move_uploaded_file($_FILES["image"]["tmp_name"], "image/".$_FILES["image"]["name"]);

        header("location: enroll-8.php");

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
                        Your tuition for installment payment
                    </p>
                    <br>
                    <p style="font-size: 16px; color: black;">Please use this accounts for payment:</p>
                    <br>
                    <br>
                                        <form method="post">
                                            <div class="card-body">
                                                <div class="colums2">
                                                    <div class="item">
                                                        <img src="image/BDO.svg" style="width: 20%; height: 40px;">    
                                                        <p style="color: black; font-size: 16px;">ACCOUNT:
                                                            <strong><u>
                                                                123456789
                                                            </u></strong>
                                                        </p>
                                                        <p style="color: black; font-size: 16px; ">Name: 
                                                            <strong><u>
                                                                Juan Dela Cruz
                                                            </u></strong>
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <img src="image/bpi.svg" style="width: 20%; height: 40px;">    
                                                        <p style="color: black; font-size: 16px;">ACCOUNT:
                                                            <strong><u>
                                                                123456789
                                                            </u></strong>
                                                        </p>
                                                        <p style="color: black; font-size: 16px;">Name: 
                                                            <strong><u>
                                                                Juan Dela Cruz
                                                            </u></strong>
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <img src="image/gcash.svg" style="width: 20%; height: 40px;">    
                                                        <p style="color: black; font-size: 16px;">ACCOUNT:
                                                            <strong><u>
                                                                123456789
                                                            </u></strong>
                                                        </p>
                                                        <p style="color: black; font-size: 16px;">Name: 
                                                            <strong><u>
                                                                Juan Dela Cruz
                                                            </u></strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="colums">
                                                    <div class="item">
                                                        <h2 style="color: black;"><strong>INSTALLMENT FEE</strong></h2>
                                                        <p style="color: red;">Need to pay</p>
                                                        <p style="color: red;">Downpayment &  miscellaneous fee</p> 
                                                        <br>
                                                        <p style="color: black; font-size: 16px;"><strong style="color: red;">* </strong>DOWNPAYMENT: <strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong></p>
                                                        <p style="color: black; font-size: 16px;">
                                                            <?php
                                                                if($Terms == 3){
                                                                    print "MID TERM: ";
                                                                }else{
                                                                    print "1ST TERM: ";
                                                                }
                                                            ?><strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong>
                                                        </p>
                                                        <p style="color: black; font-size: 16px;">
                                                            <?php
                                                                if($Terms == 3){
                                                                    print "FINAL TERM: ";
                                                                }else{
                                                                    print "2ND TERM: ";
                                                                }
                                                            ?><strong><u><?php print "₱".' '.$PERTERMS; ?></u></strong>
                                                        </p>
                                                        <p style="color: black; font-size: 16px;">
                                                        <?php
                                                            if($Terms == 3){
                                                                print "";
                                                            }else{
                                                                print "3RD TERM: ".''."<strong><u> ₱".''.$PERTERMS.''."</u></strong>";
                                                            }
                                                        ?>
                                                        </p>
                                                        <p style="color: black; font-size: 16px;">
                                                        <?php
                                                            if($Terms == 3){
                                                                print "";
                                                            }else{
                                                                print "4TH TERM: ".''."<strong><u> ₱".''.$PERTERMS.''."</u></strong>";
                                                            }
                                                        ?>
                                                        </p>
                                                        <p style="color: black; font-size: 15px;"><strong style="color: red;">* </strong>MISC FEE: <strong><u><?php print "₱".' '.$fetchIns['ins_mf']; ?></u></strong></p>
                                                        <p style="color: black; font-size: 16px;">DISCOUNT: <strong><u><?php print "₱".' '.$fetchIns['ins_discount'];  ?></u></strong></p>
                                                        <hr>
                                                        <p style="color: black; font-size: 16px;">TOTAL AMOUNT: <strong><u><?php print "₱".' '.$fetchIns['ins_total']; ?></u></strong></p>
                                                    </div>
                                                    <div class="item">
                                                        <h2 style="color: black;"><strong>UPLOAD PROOF OF PAYMENT</strong></h2>
                                                        <p><input type="file"  accept="image/*" name="image" id="file"  onchange="loadFile(event)" style="display: none;"></p>
                                                        <p style="color: black; border-style: outset; width: 20%; text-align: center; box-shadow: 2px 2px #888888;"><label style="color: black;" for="file" style="cursor: pointer;" >Upload Image</label></p>
                                                        <br>
                                                        <p><img id="output" width="50%" /></p>
                                                        <br>
                                                        <button class="btn btn-success" name="btnSubmit">SUBMIT</button>
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
        <script>
            var loadFile = function(event) {
                var image = document.getElementById('output');
                image.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
    </body>
</html> 