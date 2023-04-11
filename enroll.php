<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");
    session_start();

    $id = $_SESSION["s_id"];
    
    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_users_id = '$id'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);

    if(isset($_POST['btnSubmit'])) {
        $txtCourse = $_POST['Course'];

        $sqlUpdate = "UPDATE students_tbl SET stud_course_year_id = '$txtCourse', stud_status = 'Enroll-2' WHERE stud_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        header("location: enroll-2.php");
        
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
                        Your application has been approved. You can now enroll!
                    </p>
                </div>
                <br>
                <br>
                <div class="colums">
                    <div class="item">
                    <label style="color: black">Select course you want to take</label>
                    <select class="form-control" name="Course" required> 
                        <?php
                            $Course = mysqli_query($dbConString, "SELECT DISTINCT cy_id, cy_course FROM course_year_tbl WHERE cy_isdel = 0");  // Use select query here 

                            while($data = mysqli_fetch_array($Course)){
                                echo "<option value='". $data['cy_id'] ."'>" .$data['cy_course']."</option>";  // displaying data in option menu //first id second display
                            }	
                        ?>
                    </select>
                    <button class="btn btn-success" type="submit" name="btnSubmit">NEXT</button>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <br>
        <br>
        <div style="text-align: center;">
            <p style="color: black;">Copyright © Designed &amp; Developed by <a href="https://www.gisulpro.com/" target="_blank">Gisul Pro</a> 2021</p>
        </div>
    </body>
</html> 