<?php
	include '../db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE course_year_tbl SET cy_isdel=1 WHERE cy_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: course-year.php");
?>