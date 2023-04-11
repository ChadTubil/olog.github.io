<?php
    include '../db-controller.php';
    session_start();

    if(!(isset($_SESSION["a_users_id"]))) {
        header("location: index.php");
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
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Subjects</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">SUBJECTS</h4>
                                <span>
                                    <button class="btn btn-success" onclick="document.location.href='subjects-add.php'">Add Subject</button>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Subject</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Field</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlSubjects = "SELECT * FROM subjects_tbl WHERE sub_isdel = 0 ORDER BY sub_code ASC";
                                                $querySubjects = mysqli_query($dbConString, $sqlSubjects);
                                                while($fetchSubjects = mysqli_fetch_assoc($querySubjects)) {
                                            ?>
                                            <tr>
                                                <td style="color: black;"><?php print $fetchSubjects["sub_code"] ?></td>
                                                <td style="color: black;"><?php print $fetchSubjects["sub_name"] ?></td>
                                                <td style="color: black;"><?php print $fetchSubjects["sub_units"] ?></td>
                                                <td style="color: black;"><?php print $fetchSubjects["sub_price"] ?></td>
                                                <td style="color: black;"><?php print $fetchSubjects["sub_field"] ?></td>
                                                <td style="color: black;"><?php print $fetchSubjects["sub_status"] ?></td>
                                                <td>
                                                    <button type="button" onclick="document.location.href='subjects-edit.php?id=<?php print $fetchSubjects['sub_id']; ?>'" class="btn btn-primary" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-edit"></i> EDIT</button>
                                                    <button type="button" onclick="document.location.href='subjects-delete.php?id=<?php print $fetchSubjects['sub_id']; ?>'" class="btn btn-danger" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-trash"></i> DELETE</button>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Code</th>
                                                <th>Subject</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Field</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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