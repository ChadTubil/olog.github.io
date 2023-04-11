<?php
	include '../db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE subjects_tbl SET sub_isdel=1 WHERE sub_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: subjects.php");
?>