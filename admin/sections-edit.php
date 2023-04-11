<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
    }

    $id = $_GET["id"];
    $sqlSection = "SELECT * FROM sections_tbl WHERE sec_id = '$id'";
    $querySection = mysqli_query($dbConString, $sqlSection);
    $fetchSection = mysqli_fetch_assoc($querySection);

    if(isset($_POST['btnSave'])) {
        $txtCourse = $_POST['type_name'];
        $txtYear = $_POST['Year'];
        $txtSection = $_POST['Section'];
        $txtCode = $_POST['Code'];
        $date = date('Y-m-d');

        $sqlUpdate = "UPDATE sections_tbl SET sec_code = '$txtCode', sec_course_year_id = '$txtCourse', 
        sec_year = '$txtYear', sec_section = '$txtSection' WHERE sec_id = '$id'";
        mysqli_query($dbConString, $sqlUpdate);

        header("location: sections.php");

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
                            <h4>LIST OF YEAR AND SECTION</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Year and Section</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Year and Section</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                    <div class="card-header">
                                        <h4 class="card-title">Course and Year Level</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="basic-form">
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <label style="color: black">Course</label>
                                                        <select class="form-control" name="type_name" required>
                                                            <option value="<?php print $fetchSection['sec_course_year_id']; ?>" selected>
                                                                <?php 
                                                                    if($fetchSection["sec_course_year_id"] != 0){
                                                                        $SCYID = $fetchSection["sec_course_year_id"];
                                                                        $sqlCY = "SELECT cy_course FROM course_year_tbl WHERE cy_id = '$SCYID'";
                                                                        $queryCY = mysqli_query($dbConString, $sqlCY);
                                                                        $fetchCY = mysqli_fetch_assoc($queryCY);
                                                                    
                                                                        print $fetchCY['cy_course']; 
                                                                    }else{
                                                                        print "SELECT COURSE";
                                                                    }
                                                                ?>
                                                            </option>
                                                            <?php
                                                                $CY = mysqli_query($dbConString, "SELECT cy_id, cy_course FROM course_year_tbl WHERE cy_isdel = 0 ORDER BY cy_code ASC");  // Use select query here 

                                                                while($data = mysqli_fetch_array($CY))
                                                                {
                                                                echo "<option value='". $data['cy_id'] ."'>" .$data['cy_course'] ."</option>";  // displaying data in option menu //first id second display
                                                                }	
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col mt-2 mt-sm-0">
                                                        <label style="color: black">Year</label>
                                                        <input type="text" class="form-control" value="<?php print $fetchSection['sec_year']; ?>" name="Year">
                                                    </div>
                                                    <div class="col mt-2 mt-sm-0">
                                                        <label style="color: black">Section</label>
                                                        <input type="text" class="form-control" value="<?php print $fetchSection['sec_section']; ?>" name="Section">
                                                    </div>
                                                    <div class="col mt-2 mt-sm-0">
                                                        <label style="color: black">Code</label>
                                                        <input type="text" class="form-control" value="<?php print $fetchSection['sec_code']; ?>" name="Code">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer" style="text-align: right;">
                                            <button class="btn btn-primary" type="submit" name="btnSave">SAVE</button>
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