<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
    }

    if(isset($_POST['btnSave'])) {
        $txtCourse = $_POST['type_name'];
        $txtYear = $_POST['Year'];
        $txtSection = $_POST['Section'];
        $txtCode = $_POST['Code'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT sec_code FROM sections_tbl WHERE sec_code = '$txtCode'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Section Code is already exists. Please try enter another code.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO sections_tbl() VALUES (NULL, '$txtCourse', '$txtCode', '$txtYear', '$txtSection', 
            '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: sections.php");
        }
    }

    if(isset($_POST['btnSA'])) {
        $txtCourse = $_POST['type_name'];
        $txtYear = $_POST['Year'];
        $txtSection = $_POST['Section'];
        $txtCode = $_POST['Code'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT sec_code FROM sections_tbl WHERE sec_code = '$txtCode'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Section Code is already exists. Please try enter another code.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO sections_tbl() VALUES (NULL, '$txtCourse', '$txtCode', '$txtYear', '$txtSection', 
            '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: sections-add.php");
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
                            <h4>LIST OF YEAR AND SECTION</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Year and Section</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Year and Section</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                    <div class="card-header">
                                        <h4 class="card-title">Year and Section</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="basic-form">
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <label style="color: black">Course</label>
                                                        <select class="form-control" name="type_name" required>
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
                                                        <input type="text" class="form-control" placeholder="Year Level" name="Year">
                                                    </div>
                                                    <div class="col mt-2 mt-sm-0">
                                                        <label style="color: black">Section</label>
                                                        <input type="text" class="form-control" placeholder="Section" name="Section">
                                                    </div>
                                                    <div class="col mt-2 mt-sm-0">
                                                        <label style="color: black">Code</label>
                                                        <input type="text" class="form-control" placeholder="Section Code" name="Code">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer" style="text-align: right;">
                                            <button class="btn btn-primary"  type="submit" name="btnSA">SAVE & ADD</button>
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