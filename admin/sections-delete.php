<?php
	include '../db-controller.php';

	$id = $_GET['id'];

	$sqlDelete = "UPDATE sections_tbl SET sec_isdel=1 WHERE sec_id=$id";
	mysqli_query($dbConString, $sqlDelete);

	header("location: sections.php");
?>