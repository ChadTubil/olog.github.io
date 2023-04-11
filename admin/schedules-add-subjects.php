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
                                        <h4 class="card-title">Adding subject for:</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="basic-form">
                                                <div class="form-row">
                                                    <div class="col-sm-4">
                                                        <h2>
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
                                                        
                                                        <select name="Status" class="form-control">
                                                            <option value="Available">Available</option>
                                                            <option value="Not Available">Not Available</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary" type="submit" name="btnStatus">Update</button>
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
                                        <h4 class="card-title">Subjects</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body" >
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <div class="card-body">
                                                                    <label style="color: black;">Subject</label>
                                                                    <select id="dynamic-option-creation" name="type_subject" required>
                                                                        <?php
                                                                            $Subjects = mysqli_query($dbConString, "SELECT sub_id, sub_code From subjects_tbl WHERE sub_isdel = 0 ORDER BY sub_code ASC");  // Use select query here 

                                                                            while($data = mysqli_fetch_array($Subjects))
                                                                            {
                                                                            echo "<option value='". $data['sub_id'] ."'>" .$data['sub_code'] ."</option>";  // displaying data in option menu //first id second display
                                                                            }	
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="card-body">
                                                                    <label style="color: black;">Day</label>
                                                                    <select class="form-control" name="Day">
                                                                        <option value="Monday">Monday</option>
                                                                        <option value="Tuesday">Tuesday</option>
                                                                        <option value="Wednesday">Wednesday</option>
                                                                        <option value="Thursday">Thursday</option>
                                                                        <option value="Friday">Friday</option>
                                                                        <option value="Saturday">Saturday</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="card-body">
                                                                    <label style="color: black;">Start</label>
                                                                    <div class="input-group clockpicker">
                                                                        <input type="text" class="form-control" value="09:30" name="Start"> 
                                                                            <span class="input-group-append"><span class="input-group-text">
                                                                                <i class="fa fa-clock-o"></i></span>
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="card-body">
                                                                    <label style="color: black;">End</label>
                                                                    <div class="input-group clockpicker">
                                                                        <input type="text" class="form-control" value="09:30" name="End"> 
                                                                            <span class="input-group-append"><span class="input-group-text">
                                                                                <i class="fa fa-clock-o"></i></span>
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-6">
                                                                <div class="card-body">
                                                                    <label style="color: black;">Professor</label>
                                                                    <div>
                                                                        <input type="text" class="form-control" name="Professor" required> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                                <div class="card-body">
                                                                    <label style="color: black;">Action</label>
                                                                    <div>
                                                                        <button class="btn btn-success" name="btnSave" style="width: 100%"><i class="fa fa-plus"></i> ADD</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                                <th scope="col" style="color: black; text-align: center;">Action</th>
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
                                                                <td style="color: black; text-align: center;">
                                                                    <span>
                                                                        <a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit" style="color: blue"><i class="fa fa-pencil color-muted"></i></a>
                                                                        <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close" style="color: red"><i class="fa fa-close color-danger"></i></a>
                                                                    </span>
                                                                </td>
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