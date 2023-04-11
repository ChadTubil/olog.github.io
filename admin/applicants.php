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
                            <h4>LIST OF APPLICANTS</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dasboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Applicants</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Applicants</h4>
                                <span>
                                    <button class="btn btn-success">Add New Applicant</button>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Last Grade Level</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlStudents= "SELECT * FROM students_tbl WHERE stud_isdel = 0 AND stud_status !='Enrolled' ORDER BY stud_datecreated ASC";
                                                $queryStudents = mysqli_query($dbConString, $sqlStudents);
                                                while($fetchStudents = mysqli_fetch_assoc($queryStudents)) {

                                                    $STAT = $fetchStudents["stud_status"];
                                            ?>
                                            <tr>
                                                <td style="color: black"><?php print $fetchStudents["stud_lastname"].' '.$fetchStudents["stud_nameextension"].', '.$fetchStudents["stud_firstname"].' '.$fetchStudents["stud_middlename"]; ?></td>
                                                <td style="color: black"><?php print $fetchStudents["stud_lastgradecompleted"] ?></td>
                                                <td style="color: black"><?php print $fetchStudents["stud_phone"] ?></td>
                                                <td style="color: black"><?php print $fetchStudents["stud_email"] ?></td>
                                                <td style="color: black"><?php print $fetchStudents["stud_status"] ?></td>
                                                <td>
                                                    <button type="button" <?php if ($STAT != 'Applicant'){ ?> disabled <?php   } ?> onclick="document.location.href='applicant-access.php?id=<?php print $fetchStudents['stud_id']; ?>'" class="btn btn-warning" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-key"></i></i> Access</button>
                                                    <button type="button" onclick="document.location.href='users-hire.php?id=<?php print $fetchStudents['stud_id']; ?>'" class="btn btn-info" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-eye"></i> VIEW</button>
                                                    <button type="button" onclick="document.location.href='users-edit.php?id=<?php print $fetchStudents['stud_id']; ?>'" class="btn btn-primary" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-edit"></i> EDIT</button>
                                                    <button type="button" onclick="document.location.href='users-delete.php?id=<?php print $fetchStudents['stud_id']; ?>'" class="btn btn-danger" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-trash"></i> DELETE</button>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Last Grade Level</th>
                                                <th>Phone</th>
                                                <th>Email</th>
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