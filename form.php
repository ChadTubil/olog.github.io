<?php
    include 'db-controller.php';

    $id = $_GET["id"];
    
    $sqlStudUser = "SELECT * FROM s_users_tbl WHERE s_id = '$id'";
    $queryStudUser = mysqli_query($dbConString, $sqlStudUser);
    $fetchStudUser = mysqli_fetch_assoc($queryStudUser);

    if(isset($_POST['btnSubmit'])) {
        $txtLastName = $_POST['LastName'];
        $txtFirstName = $_POST['FirstName'];
        $txtMiddleName = $_POST['MiddleName'];
        $txtExtension = $_POST['Extension'];
        $txtHomeAddress = $_POST['HomeAddress'];
        $txtBarangay = $_POST['Barangay'];
        $txtCity = $_POST['City'];
        $txtProvince = $_POST['Province'];
        $txtPhone = $_POST['Phone'];
        $txtEmail = $_POST['Email'];
        $txtBirthday = $_POST['Birthday'];
        $txtBirthplace = $_POST['Birthplace'];
        $txtGender = $_POST['Gender'];
        $txtCivil = $_POST['Civil'];
        $txtReligion = $_POST['Religion'];
        $txtFatherName = $_POST['FatherName'];
        $txtFatherOccupation = $_POST['FatherOccupation'];
        $txtMotherName = $_POST['MotherName'];
        $txtMotherOccupation = $_POST['MotherOccupation'];
        $txtLastSchool = $_POST['LastSchool'];
        $txtGradeLevel = $_POST['GradeLevel'];
        $txtIncoming = $_POST['Incoming'];
        $date = date('Y-m-d');

        $sqlStudUser = "INSERT INTO students_tbl() VALUES (NULL, '$id', '', '', '$txtLastName', '$txtFirstName', '$txtMiddleName', 
        '$txtExtension', '$txtPhone', '$txtEmail', '$txtHomeAddress', '$txtBarangay', '$txtCity', '$txtProvince', '$txtBirthday', 
        '$txtBirthplace', '$txtGender', '$txtCivil', '$txtReligion', '$txtFatherName', '$txtFatherOccupation', 
        '$txtMotherName', '$txtMotherOccupation', '$txtLastSchool', '$txtGradeLevel', '$date', 'Applicant', '', '$txtIncoming', 0)";
        mysqli_query($dbConString, $sqlStudUser);

        header("location: last.php?id=".''.$id);
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>SMS</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="image/GisulLogo.png">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="form/css/style.css" rel="stylesheet">
    
    </head>
    <body class="h-100" background="image/PulilanCP.jpg" style="background-size: 100% 100%; background-repeat: no-repeat; background-attachment: fixed;">
        <div class="testbox">
            <form method="post">
                <div style="text-align: center;">
                    <img src="image/Pulilan.png" style="width: 10%">
                </div>
                <br>
                <br>
                <div style="text-align: center;">
                    <p style="font-size: 40px; color: black;">APPLICATION FORM</p>
                </div>
                <br>
                <hr>
                <br>
                <div class="colums">
                    <div class="item">
                        <label for="fname" style="color: black;">Username: </label> 
                        <a style="color: black; font-size: 18px;"><strong><?php print $fetchStudUser["s_username"]; ?></strong></a>
                    </div>
                </div>
                <br>
                <br>
                <div class="colums2">
                    <div style="text-align: left;">
                        <p style="color: black; font-size: 20px;"><strong>I. PERSONAL INFORMATION</strong></p>
                    </div>
                </div>
                <div class="colums3">
                    <div class="item">
                        <label for="address1" style="color: black;">Last Name<span>*</span></label>
                        <input id="lastname" type="text"   name="LastName" required/>
                    </div>
                    <div class="item">
                        <label for="address2" style="color: black;">First Name<span>*</span></label>
                        <input id="firstname" type="text"   name="FirstName" required/>
                    </div>
                    <div class="item">
                        <label for="state" style="color: black;">Middle Name<span>*</span></label>
                        <input id="middlename" type="text"   name="MiddleName" required/>
                    </div>
                    <div class="item">
                        <label for="state" style="color: black;">Name Extension</label>
                        <input id="middlename" type="text"   name="Extension"/>
                    </div>
                </div>
                <div>
                    <div class="item">
                        <label for="zip" style="color: black;">Complete Home Address<span>*</span></label>
                        <input id="homeaddress" type="text" name="HomeAddress" required/>
                    </div>
                </div>
                <div class="colums2">
                    <div class="item">
                        <label for="address1" style="color: black;">Barangay<span>*</span></label>
                        <input id="lastname" type="text"   name="Barangay" required/>
                    </div>
                    <div class="item">
                        <label for="address2" style="color: black;">Municipality/City<span>*</span></label>
                        <input id="firstname" type="text"   name="City" required/>
                    </div>
                    <div class="item">
                        <label for="state" style="color: black;">Province<span>*</span></label>
                        <input id="middlename" type="text"   name="Province" required/>
                    </div>
                </div>
                <div class="colums2">
                    <div class="item">
                        <label for="city" style="color: black;">Mobile Number<span>*</span></label>
                        <input id="mobilenumber" type="text"   name="Phone" required/>
                    </div>
                    <div class="item" style="text-align: left">
                        <label for="dateofbirth" style="color: black;">Email<span>*</span></label>
                        <input id="dateofbirth" type="email" name="Email" required/>
                    </div>
                    <div class="item">
                        <label for="phone" style="color: black;">Birthday<span>*</span></label>
                        <input id="age" type="date" name="Birthday" required/>
                    </div>
                </div>
                <div class="item">
                    <label for="zip" style="color: black;">Birth Place<span>*</span></label>
                    <input id="homeaddress" type="text" name="Birthplace" required/>
                </div>
                <div class="colums2">
                    <div class="item">
                        <label for="city" style="color: black;">Gender<span>*</span></label>
                        <select name="Gender">
                            <option value="Male">Male </option>
                            <option value="Female">Female</option>
                            <option value="Rather not to say">Rather not to say</option>
                        </select>
                    </div>
                    <div class="item">
                        <label for="address2" style="color: black;">Civil Status<span>*</span></label>
                        <select name="Civil">
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Separated">Separated</option>
                            <option value="Widowed">Widowed </option>
                        </select>
                    </div>
                    <div class="item">
                        <label for="state" style="color: black;">Religion<span>*</span></label>
                        <input id="middlename" type="text"   name="Religion" required/>
                    </div>
                </div>
                <div class="colums">
                    <div class="item">
                        <label for="fname">Father's Name<span>*</span></label>
                        <input id="nameofspouse" type="text" name="FatherName" required/>
                    </div>
                    <div class="item">
                        <label for="fname">Father's Occupation<span>*</span></label>
                        <input id="occupation" type="text" name="FatherOccupation" required/>
                    </div>
                </div>
                <div class="colums">
                    <div class="item">
                        <label for="fname">Mother's Name<span>*</span></label>
                        <input id="nameofspouse" type="text" name="MotherName" required/>
                    </div>
                    <div class="item">
                        <label for="fname">Mother's Occupation<span>*</span></label>
                        <input id="occupation" type="text" name="MotherOccupation" required/>
                    </div>
                </div>
                <div class="colums2">
                    <div style="text-align: left;">
                        <p style="color: black; font-size: 20px;"><strong>II. EDUCATIONAL INFORMATION</strong></p>
                    </div>
                </div>
                <div class="colums2">
                    <div class="item">
                        <label for="fname">Highest Grade Level Attained<span>*</span></label>
                        <select name="GradeLevel" required>
                            <optgroup label="PRE-ELEMENTARY">
                                <option value="Toddler">Toddler</option>
                                <option value="Nursery">Nursery</option>
                                <option value="Kinder">Kinder</option>
                            </optgroup>
                            <optgroup label="GRADE SCHOOL">
                                <option value="Grade 1">Grade 1</option>
                                <option value="Grade 2">Grade 2</option>
                                <option value="Grade 3">Grade 3</option>
                                <option value="Grade 4">Grade 4</option>
                                <option value="Grade 5">Grade 5</option>
                                <option value="Grade 6">Grade 6</option>
                            </optgroup>
                            <optgroup label="JUNIOR HIGH SCHOOL">
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </optgroup>
                            <optgroup label="SENIOR HIGH SCHOOL">
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="item">
                        <label for="fname">Last School Attended<span>*</span></label>
                        <input id="highesteducation" type="text" name="LastSchool" required/>
                    </div>
                    <div class="item">
                        <label for="fname">Incoming Grade Level To Take<span>*</span></label>
                        <select name="Incoming" required>
                            <optgroup label="PRE-ELEMENTARY">
                                <option value="Toddler">Toddler</option>
                                <option value="Nursery">Nursery</option>
                                <option value="Kinder">Kinder</option>
                            </optgroup>
                            <optgroup label="GRADE SCHOOL">
                                <option value="Grade 1">Grade 1</option>
                                <option value="Grade 2">Grade 2</option>
                                <option value="Grade 3">Grade 3</option>
                                <option value="Grade 4">Grade 4</option>
                                <option value="Grade 5">Grade 5</option>
                                <option value="Grade 6">Grade 6</option>
                            </optgroup>
                            <optgroup label="JUNIOR HIGH SCHOOL">
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </optgroup>
                            <optgroup label="SENIOR HIGH SCHOOL">
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="btn-block">
                    <button type="submit" name="btnSubmit">Submit</button>
                </div>
            </form>
        </div>
        <br>
        <br>
    
        <div style="text-align: center;">
        <p style="color: black;">Copyright © Designed &amp; Developed by <a href="https://www.gisulpro.com/" target="_blank">Gisul Pro</a> 2021</p>
        </div>
        <br>
        <br>
    </body>
</html>