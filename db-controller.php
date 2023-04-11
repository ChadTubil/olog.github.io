<?php
	define("DBHOST", "localhost");
	define("DBUSER", "root");
	define("DBPASSWORD", "");
	define("DBNAME", "olog_db");

	$dbConString = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBNAME);
	
	// if ($dbConString->ping()) {
    //     printf ("Our connection is ok!\n"); 
    // } else {
    //     printf ("Error: %s\n", $dbConString->error); 
    // }

	date_default_timezone_set("Asia/Manila");
?>