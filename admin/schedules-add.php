<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
    }

    if(isset($_POST['btnSave'])) {
        $txtSched = $_POST['type_name'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT sched_course_year_id FROM schedules_tbl WHERE sched_course_year_id = '$txtSched'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Schedule for this course is already exists. Please try enter another.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO schedules_tbl() VALUES (NULL, '$txtSched', 'No Subjects', '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: schedules.php");
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
                            <h4>LIST OF SCHEDULES</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Schedules</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Schedule</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                    <div class="card-header">
                                        <h4 class="card-title">Create schedule for:</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="basic-form">
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                    <select class="form-control" name="type_name" required>
                                                        <?php
                                                        $Section = mysqli_query($dbConString, "SELECT sec_id, sec_code FROM sections_tbl WHERE sec_isdel = 0 ORDER BY sec_code ASC");  // Use select query here 

                                                        while($data = mysqli_fetch_array($Section))
                                                        {
                                                        echo "<option value='". $data['sec_id'] ."'>" .$data['sec_code'] ."</option>";  // displaying data in option menu //first id second display
                                                        }	
                                                        ?>
                                                    </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button class="btn btn-primary" type="submit" name="btnSave">CREATE SCHEDULE</button>
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