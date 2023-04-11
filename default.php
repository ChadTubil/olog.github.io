<?php
    include 'db-controller.php';
    session_start();

    if(isset($_POST["btnLogin"])){
        $txtUsername = $_POST['Username'];
        $txtPassword = $_POST['Password'];

        $sqlLogin = "SELECT * FROM s_users_tbl WHERE s_username = '$txtUsername' AND s_password = '$txtPassword' 
        AND s_isdel = 0";
        $queryLogin = mysqli_query($dbConString, $sqlLogin);
        $numRowsLogin = mysqli_num_rows($queryLogin);

        if($numRowsLogin != 0){
            $fetchLogin = mysqli_fetch_assoc($queryLogin);
            $_SESSION["s_id"] = $fetchLogin["s_id"];

            header("location:check-login.php");
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
    <div class="authincation h-100" >
        <div class="container-fluid h-100" >
            <div class="row justify-content-center h-100 align-items-center" >
                <div class="col-md-8" >
                    <div class="authincation-content" style="box-shadow: 5px 5px #888888;">
                        <div class="row no-gutters"> 
                            <div class="col-xl-6" style="text-align: center; margin: auto;">
                                <img src="image/Pulilan.png" style="width: 80%;">
                            </div>
                            <div class="col-xl-6">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label style="color: black"><strong>Username</strong></label>
                                            <input type="text" name="Username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label style="color: black"><strong>Password</strong></label>
                                            <input type="password" name="Password" class="form-control">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1" style="color: black">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="page-forgot-password.html" style="color: black">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="btnLogin" class="btn btn-primary btn-block">SIGN IN</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p style="color: black">If you are an applicant, please sign up <a class="text-primary" href="register.php">here.</a></p>
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
    <script src="vendor/global/global.min.js"></script>
    <script src="js/quixnav-init.js"></script>
    <script src="js/custom.min.js"></script>
</body>
</html>