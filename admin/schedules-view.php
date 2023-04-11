<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
    }
    $id = $_GET["id"];
    $sqlSchedules= "SELECT * FROM schedules_tbl WHERE sched_id = '$id'";
    $querySchedules = mysqli_query($dbConString, $sqlSchedules);
    $fetchSchedules = mysqli_fetch_assoc($querySchedules);

    $SCHEDCYID = $fetchSchedules["sched_course_year_id"];

    if(isset($_POST['btnSave'])) {
        $txtSubject = $_POST['type_subject'];
        $txtDay = $_POST['Day'];
        $txtStart = $_POST['Start'];
        $txtEnd = $_POST['End'];
        $txtProfessor = $_POST['Professor'];
        $date = date('Y-m-d');

        
        $sqlAdd = "INSERT INTO sched_sub_tbl() VALUES (NULL, '$id', '$txtSubject', '$txtStart', '$txtEnd', '$txtDay', 
        '$txtProfessor', '$date', 0)";
        mysqli_query($dbConString, $sqlAdd);

        header("location: schedules-add-subjects.php?id=".''.$id);

    }

    if(isset($_POST['btnStatus'])) {
        $txtStatus = $_POST['Status'];
        $date = date('Y-m-d');

        
        $sqlUpdate = "UPDATE schedules_tbl SET sched_status = '$txtStatus' WHERE sched_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        header("location: schedules.php");

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
                            <h4>LIST OF SCHEDULES</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Schedules</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View Schedule</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                    <div class="card-header">
                                        <h4 class="card-title">Schedule for:</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="basic-form">
                                                <div class="form-row">
                                                    <div class="col-sm-4">
                                                        <h2 style="color: black;">
                                                            <?php
                                                                $sqlSections = "SELECT * FROM sections_tbl WHERE sec_id = '$SCHEDCYID'";
                                                                $querySections = mysqli_query($dbConString, $sqlSections);
                                                                $fetchSections = mysqli_fetch_assoc($querySections);

                                                                print $fetchSections["sec_code"]; 
                                                            ?>
                                                    </div>
                                                    <div class="col-sm-3" style="text-align: right">
                                                        <p style="color: black; font-size: 20px;">STATUS:</p>
                                                    </div>
                                                    <div class="col-sm-3" style="text-align: left">
                                                        
                                                        <h2 style="color: black;"><?php print $fetchSchedules["sched_status"]; ?></h2>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="card-footer" style="text-align: right;">
                                            <button class="btn btn-primary"  type="submit" name="btnSA">SAVE & ADD</button>
                                            <button class="btn btn-primary" type="submit" name="btnSave">SAVE</button>
                                        </div> -->
                                    </form>
                                </div>
                                <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                    <div class="card-header">
                                        <h4 class="card-title">Schedule</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body" >
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" style="color: black; text-align: center;">Subject</th>
                                                                <th scope="col" style="color: black; text-align: center;">Day</th>
                                                                <th scope="col" style="color: black; text-align: center;">Start</th>
                                                                <th scope="col" style="color: black; text-align: center;">End</th>
                                                                <th scope="col" style="color: black; text-align: center;">Professor</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $sqlSS = "SELECT * FROM sched_sub_tbl WHERE ss_isdel = 0 AND ss_sched_id = '$id'";
                                                            $querySS = mysqli_query($dbConString, $sqlSS);
                                                            while($fetchSS = mysqli_fetch_assoc($querySS)) {
                                                        ?>
                                                            <tr>
                                                                <td style="color: black;">
                                                                    <?php 
                                                                        $SSSID = $fetchSS["ss_subjects_id"];

                                                                        $sqlSubject = "SELECT * FROM subjects_tbl WHERE sub_id = '$SSSID'";
                                                                        $querySubject = mysqli_query($dbConString, $sqlSubject);
                                                                        $fetchSubject = mysqli_fetch_assoc($querySubject);
                                                                        print $fetchSubject["sub_code"]; 
                                                                    ?>
                                                                </td>
                                                                <td style="color: black; text-align: center;"><?php print $fetchSS["ss_day"]; ?></td>
                                                                <td style="color: black; text-align: center;"><?php print $fetchSS["ss_start"]; ?></td>
                                                                <td style="color: black; text-align: center;"><?php print $fetchSS["ss_end"]; ?></td>
                                                                <td style="color: black; text-align: center;"><?php print $fetchSS["ss_professor"]; ?></td>
                                                                
                                                            </tr>
                                                        <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
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