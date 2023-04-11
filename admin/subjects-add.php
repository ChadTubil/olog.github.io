<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
    }

    if(isset($_POST['btnSave'])) {
        $txtSubject = $_POST['Subject'];
        $txtCode = $_POST['Code'];
        $txtField = $_POST['Field'];
        $txtUnit = $_POST['Units'];
        $txtPrice = $_POST['Price'];
        $txtStatus = $_POST['Status'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT sub_code FROM subjects_tbl WHERE sub_code = '$txtCode'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Subject Code is already exists. Please try enter another code.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO subjects_tbl() VALUES (NULL, '$txtCode', '$txtSubject', '$txtUnit', '$txtPrice', 
            '$txtField', '$txtStatus', '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: subjects.php");
        }
    }

    if(isset($_POST['btnSA'])) {
        $txtSubject = $_POST['Subject'];
        $txtCode = $_POST['Code'];
        $txtField = $_POST['Field'];
        $txtUnit = $_POST['Units'];
        $txtPrice = $_POST['Price'];
        $txtStatus = $_POST['Status'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT sub_code FROM subjects_tbl WHERE sub_code = '$txtCode'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Subject Code is already exists. Please try enter another code.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlAdd = "INSERT INTO subjects_tbl() VALUES (NULL, '$txtCode', '$txtSubject', '$txtUnit', '$txtPrice', 
            '$txtField', '$txtStatus', '$date', 0)";
            mysqli_query($dbConString, $sqlAdd);

            header("location: subjects-add.php");
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
                            <h4>LIST OF SUBJECTS</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Subjects</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Subject</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='course-year-add.php'">Add Course</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <div class="card" style="box-shadow: 5px 5px #888888; border: solid;">
                                    <div class="card-header">
                                        <h4 class="card-title">Subjects</h4>
                                    </div>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="basic-form">
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <label style="color: black">Subject</label>
                                                        <input type="text" class="form-control" placeholder="Subject" name="Subject">
                                                    </div>
                                                    <div class="col mt-3 mt-sm-0">
                                                        <label style="color: black">Code</label>
                                                        <input type="text" class="form-control" placeholder="Subject Code" name="Code">
                                                    </div>
                                                    <div class="col mt-3 mt-sm-0">
                                                        <label style="color: black">Field</label>
                                                        <select name="Field" class="form-control">
                                                            <option value="Major">Major</option>
                                                            <option value="Minor">Minor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-sm-4">
                                                        <label style="color: black">Unit(s)</label>
                                                        <input type="number" class="form-control" placeholder="Unit(s)" name="Units">
                                                    </div>
                                                    <div class="col mt-4 mt-sm-0">
                                                        <label style="color: black">Price ₱</label><input type="text" class="form-control" placeholder="Price per unit(s)" name="Price">
                                                    </div>
                                                    <div class="col mt-4 mt-sm-0">
                                                        <label style="color: black">Status</label>
                                                        <select name="Status" class="form-control">
                                                            <option value="Available">Available</option>
                                                            <option value="Not Available">Not Available</option>
                                                        </select>
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