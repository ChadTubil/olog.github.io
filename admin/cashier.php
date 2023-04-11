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
                            <h4>LIST OF FEES</h4>
                            <span class="ml-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Cashier</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">FEES</h4>
                                <!-- <span>
                                    <button class="btn btn-success" onclick="document.location.href='subjects-add.php'">Add Subject</button>
                                </span> -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th>Mode</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlCashier = "SELECT * FROM cashier_tbl WHERE cash_isdel = 0";
                                                $queryCashier = mysqli_query($dbConString, $sqlCashier);
                                                while($fetchCashier = mysqli_fetch_assoc($queryCashier)) {
                                            ?>
                                            <tr>
                                                <td style="color: black;"><?php print "TRN-00".''.$fetchCashier["cash_id"] ?></td>
                                                <td style="color: black;"><?php print "STD-00".''.$fetchCashier["cash_stud_id"] ?></td>
                                                <td style="color: black;">
                                                    <?php 
                                                        $CSI = $fetchCashier["cash_stud_id"];
                                                        $sqlStudents = "SELECT * FROM students_tbl WHERE stud_id = '$CSI'";
                                                        $queryStudents = mysqli_query($dbConString, $sqlStudents);
                                                        $fetchStudents = mysqli_fetch_assoc($queryStudents);

                                                        print $fetchStudents['stud_lastname'].', '.$fetchStudents['stud_firstname'].' '.$fetchStudents['stud_middlename'];
                                                    ?>
                                                </td>
                                                <td style="color: black;"><?php print $fetchCashier["cash_mode"] ?></td>
                                                <td style="color: black;"><?php print $fetchCashier["cash_status"] ?></td>
                                                <td>
                                                    <button type="button" onclick="document.location.href='cashier-view.php?id=<?php print $fetchCashier['cash_id']; ?>'" class="btn btn-info" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-eye"></i> VIEW</button>
                                                    <button type="button" <?php if ($fetchCashier["cash_status"] != 'Process'){ ?> disabled <?php   } ?> onclick="document.location.href='cashier-process.php?id=<?php print $fetchCashier['cash_id']; ?>'" class="btn btn-primary" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-cogs"></i> PROCESS</button>
                                                    <button type="button" onclick="document.location.href='payment-check.php?id=<?php print $fetchCashier['cash_id']; ?>'" class="btn btn-warning" style="height: 25px; font-size: 12px; padding: 0px 10px;"><i class="fa fa-file"></i> PAYMENTS</button>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th>Mode</th>
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