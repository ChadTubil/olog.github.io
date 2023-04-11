<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
    }

    $id = $_GET["id"];

    $sqlStudents = "SELECT * FROM students_tbl WHERE stud_id = '$id'";
    $queryStudents = mysqli_query($dbConString, $sqlStudents);
    $fetchStudents = mysqli_fetch_assoc($queryStudents);
    $Year = $fetchStudents['stud_incominggrade'];


    if(isset($_POST['btnSubmit'])) {
        $txtCY = $_POST['CY'];

        // $sqlSection = "SELECT * FROM sections_tbl WHERE sec_id = '$txtCY'";
        // $querySection = mysqli_query($dbConString, $sqlSection);
        // $fetchSection = mysqli_fetch_assoc($querySection);

        // $SecYear = $fetchSection['sec_year'];
        
        $sqlUpdate = "UPDATE students_tbl SET stud_course_year_id = '$txtCY', stud_status = 'Enroll' WHERE stud_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        header("location: applicants.php");
        
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
                            <h4>GIVE ACCESS TO APPLICANT</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dasboard.php">Applicants</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Access</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Giving access to applicant</h4>
                                <!-- <span>
                                    <button class="btn btn-success">Add New Applicant</button>
                                </span> -->
                            </div>
                            <br>
                            <div style="padding: 10px;">
                                <div class="row">
                                    <div class="col-xl-6 col-xxl-6 col-lg-6 col-sm-6">
                                        <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                            <div class="card-header">
                                                <h5 class="card-title" style="color: black"><?php print $fetchStudents["stud_lastname"].' '.$fetchStudents["stud_nameextension"].', '.$fetchStudents["stud_firstname"].' '.$fetchStudents["stud_middlename"]; ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text" style="color: black">
                                                    Address: <?php print $fetchStudents["stud_address"] ?>
                                                </p>
                                                <p class="card-text" style="color: black">
                                                    Last school : <?php print $fetchStudents["stud_lastschool"] ?>
                                                </p>
                                                <p class="card-text" style="color: black">
                                                    Last Grade Level Completed  : <?php print $fetchStudents["stud_lastgradecompleted"] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-xxl-6 col-lg-6 col-sm-6">
                                        <form method="post" role="form" enctype="multipart/form-data">
                                            <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                                <div class="card-header">
                                                    <h4 class="card-title">GIVE ACCESS</h4>
                                                </div>
                                                <div class="card-body">
                                                    <label style="color: black;">Level to take:</label>
                                                    <h5 style="color: black;"><?php print $Year; ?></h5>
                                                    <br>
                                                    <div>
                                                        <label style="color: black;">Give section and schecule:</label>
                                                        <select name="CY" class="form-control" style="border-color: black;">
                                                            <?php
                                                                $Section = mysqli_query($dbConString, "SELECT sec_id, sec_code, sec_year From sections_tbl WHERE sec_isdel = 0 AND sec_year = '$Year'");  // Use select query here 

                                                                while($data = mysqli_fetch_array($Section))
                                                                {
                                                                    echo "<option value='". $data['sec_id'] ."'>" .$data['sec_year'].' ('.$data['sec_code'] .")</option>";  // displaying data in option menu //first id second display
                                                                }	
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <button class="btn btn-success" type="submit" name="btnSubmit" style="width: 100%;">GRANT</button>
                                                </div>
                                            </div>
                                        </form>
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