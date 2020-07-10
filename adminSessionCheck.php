
<?php
    session_start();
	if($_SESSION['position']!="1"){
		
		Header("Location:login.php?feedback=You must be logged in to access this page...");
	}
?>