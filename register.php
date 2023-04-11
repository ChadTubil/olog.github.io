<?php
    include 'db-controller.php';
    date_default_timezone_set("Asia/Manila");

    if(isset($_POST['btnSave'])) {
        $txtUsername = $_POST['Username'];
        $txtPassword = $_POST['Password'];
        $date = date('Y-m-d');

        $sqlCheck = "SELECT s_username FROM s_users_tbl WHERE s_username = '$txtUsername'";
        $queryCheck = mysqli_query($dbConString, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            $message = "Username is already exists. Please try enter another username.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }else{
            $sqlStudUser = "INSERT INTO s_users_tbl() VALUES (NULL, '$txtUsername', '$txtPassword', '$date', 0)";
            mysqli_query($dbConString, $sqlStudUser);

            $sqlStudUserFind = "SELECT * FROM s_users_tbl WHERE s_username = '$txtUsername'";
            $queryStudUserFind = mysqli_query($dbConString, $sqlStudUserFind);
            $fetchStudUserFind = mysqli_fetch_assoc($queryStudUserFind);
            $SUID = $fetchStudUserFind["s_id"];

            header("location: form.php?id=".''.$SUID);
        }
    }

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SMS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="image/GisulLogo.png">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="h-100" background="image/PulilanCP.jpg" style="background-size: 100% 100%; background-repeat: no-repeat; background-attachment: fixed;">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-8">
                    <div class="authincation-content" style="box-shadow: 5px 5px #888888;">
                        <div class="row no-gutters">
                            <div class="col-xl-6" style="text-align: center; margin: auto;">
                                <img src="image/Pulilan.png" style="width: 80%;">
                            </div>
                            <div class="col-xl-6">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form method="post" role="form" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label style="color: black"><strong>Username</strong></label>
                                            <input type="text" class="form-control" placeholder="username" name="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <label style="color: black"><strong>Password</strong></label>
                                            <input type="password" class="form-control" placeholder="********" name="Password" required> 
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" name="btnSave" class="btn btn-primary btn-block">SIGN ME UP</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p style="color: black">Already have an account? <a class="text-primary" href="default.php">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <!--endRemoveIf(production)-->
</body>

</html>