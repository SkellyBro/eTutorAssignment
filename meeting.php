<?php

require('studentSessionCheck.php');

$sUID=$_SESSION['uID'];

$feedback="";
$error="";
$count=0;


$error1="";
$error2="";
$error3="";
$error4="";
$error5="";
$unassigned=0;
$feedback="";

//determine if the submit button was pressed 
	if (isset($_POST ["meetingSubmit"]))
	{
		
		//get values from the form
		$mTime = $_POST["mTime"];
		$mDate = $_POST["mDate"];
		$mType = $_POST["mType"];
		
		//do validation
		$errorCount = 0;
		
	if($mDate=="" || $mDate==null){
		$count++;
		$error.= "<br/> Date is Required"; 
	}
	
	if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $mDate)){
	}else{
		$count++;
		$error.= "<br/> Date is not in format YYYY-MM-DD";
	}
		
	if ($mTime== ""||$mTime == null)
			{
				$error.="<br/>Please select a time for the meeting";
				$count++;
			}
			
	if ($mType== ""||$mType==null)
			{
				$error.="<br/>Please select the meeting type";
				$count++;
			}
			
		include("DBConnect.php");
	
/*SELECT meetingID
			FROM meeting
			WHERE meetingTime =?
			AND meetingDate LIKE ?
*/



	if( isset($mDate,$mTime,$mType) == true){
	

		include("DBConnect.php");
		
		
		if($stmt=mysqli_prepare ($mysqli,"		
			SELECT meetingID
			FROM meeting
			WHERE meetingTime = ? 
			AND meetingDate = ?		
			")){
				//bind parameters for markers
				mysqli_stmt_bind_param($stmt,"ss", $mTime,$mDate);		
				
				  //execute the stmt
		         mysqli_stmt_execute($stmt);

				 
				 mysqli_stmt_bind_result ($stmt, $meetingIds);
				 
				 //store result to check resultSet
				mysqli_stmt_store_result($stmt);
				 $resultSet="";
				$resultSet= mysqli_stmt_num_rows($stmt);
				//var_dump($resultSet);
				//echo ($resultSet);
				//die();
		if($resultSet>=1){
				$error.="<br/>Chosen time has already been booked. Please select a new time.";
			 	$count++;
			}
			
		}
		
	}
	
	if( isset($mDate,$mTime,$mType) == true){
	

		include("DBConnect.php");
		
		
		$stmt=mysqli_prepare ($mysqli,"		
			SELECT meetingID
			FROM meeting
			WHERE meetingDate = ?		
			");
			
			if($stmt){
				//bind parameters for markers
				mysqli_stmt_bind_param($stmt,"s",$mDate);		
				
				  //execute the stmt
		         mysqli_stmt_execute($stmt);

				 
				 mysqli_stmt_bind_result ($stmt, $meetingIds);
				 
				 //store result to check resultSet
				mysqli_stmt_store_result($stmt);
				 $resultSet="";
				$resultSet= mysqli_stmt_num_rows($stmt);
				//var_dump($resultSet);
				//echo ($resultSet);
				//die();
		if($resultSet>=6){
				$error.="<br/>Chosen Date has been booked to capacity. Please select another Date.";
			 	$count++;
			}
		}
		
	}
	
	if( isset($mDate,$mTime,$mType) == true){
			
	$today= date("Y-m-d");
	strtotime($mDate);
	
	if($mDate<$today){
		$count++;
		$error.="<br/>Entered date cannot be less than today's date.";
		}
	}
		
	
		
	if ($count==0)
		{			
			include("DBConnect.php");

			if($stmt=mysqli_prepare ($mysqli,"INSERT INTO meeting ( meetingHost, meetingAttendee, meetingDate, meetingTime, meetingType) Values ((SELECT useraccount.userID
		FROM assign, useraccount
		WHERE useraccount.userID=assign.tutorID
		AND assign.studentID=?),?,?,?,?)"))

			{
			
				//bind parameters for markers
				mysqli_stmt_bind_param($stmt,"iisss", $sUID, $sUID, $mDate, $mTime, $mType);		
				//execute query
				mysqli_stmt_execute ($stmt) or die (
				mysqli_error($mysqli));
				//close statement
				mysqli_stmt_close($stmt);
				
			}
			//close connection 
			mysqli_close ($mysqli);
			
			$feedback.="<br/>Your Meeting has been created";
			//die();
		}
	
	
	}



?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student Dasboard</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/sideNav.css"/>
	<link rel="stylesheet" type="text/css" href="css/table.css"/>
	
	</head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top navcolor">
      <div class="container">
        <a href="#" class="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
			 <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Header with Background Image -->
    <header class="business-header">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <!--<h1 class="display-3 text-center text-white mt-4">Business Name or Tagline</h1>-->
          </div>
        </div>
      </div>
    </header>

    <!-- Page Content -->
	
    <div class="container col-sm-12">
	<meta name="viewport" content="width=device-width, initial-scale=1">


       <div class="row">
	  
         <div class="col-lg-12">
		 
		 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="studentDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="#"> Create Meeting </a>
	    </div>
		<br/>
	  
	  <br/>
	  </div>
	  </div>
	  
	  <!--Side Menu-->
	<div class="row">
	 
		<div class="col-sm-2">
		<div class="fluid-container">
		 <table class="table">
		 <tbody>
		<tr>
			<td><h6><a href="studentDashboard.php">Dashboard</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="documentUploadArea.php">Upload Documents</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewTutorUploads.php">View Tutor Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewPersonalUploads.php">Your Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="studentMessaging.php">Messaging</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="meeting.php">Meeting Arrangement</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="studentBlog.php">Your Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewStudentBlog.php">View Student Blogs</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewTutorBlog.php">View Tutor Blogs</a></h6></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
		
	<div class="col-sm-10">	
	<div class="container">
	<h1>Student Dashboard</h1>
	<h3><a>	
				Welcome <?php if(isset($_SESSION['position'])){
				$firstName= $_SESSION['firstName'];
				$lastName=$_SESSION['lastName'];
				echo($firstName.' '.$lastName);}?> 
	</a></h3>
	
	<h4>Meeting Setup </h4>
	
	<?php
	
	//this is feedback code for any validation errors
			 if($error != ""){
				 echo "<div class= 'alert alert-danger'>"; 
				   if ($count == 1) echo "<strong>$count error found.</strong>";
				   if ($count > 1) echo "<strong>$count errors found.</strong>";
				 echo "$error
				   </div>";
			}//end of if statement for error
			
			//this is feedback code for success messages
			if($feedback != ""){
				 echo "<div class= 'alert alert-success'>"; 
				 echo "$feedback
				   </div>";
			}//end of if statement for error
		
	?>
		
	</div>
	
	<div class="container">
	<?php
		if(isset($_SESSION)){
		$uID=$_SESSION['uID'];
		}
		include('DBConnect.php');
		


		$stmt=mysqli_prepare($mysqli, 
		"SELECT useraccount.userID, useraccount.firstName, useraccount.lastName
		FROM assign, useraccount
		WHERE useraccount.userID=assign.tutorID
		AND assign.studentID=?");
		if($stmt){
			
			//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
			
			//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt,$tID, $tutorFN,$tutorLN);
				
				mysqli_stmt_store_result($stmt);
				
				$resultSet= mysqli_stmt_num_rows($stmt);
				

				if($resultSet>=1){
				while(mysqli_stmt_fetch($stmt))
					{
						echo "<h5>Your personal Tutor's Name is  $tutorFN $tutorLN </h5>";
						
					}
				}else{
					echo("<h6>You haven't been assigned as yet. Please contact your system administrator</h6>");
					$unassigned++;
				}//end of resultSet if
				mysqli_stmt_close($stmt);

		}
	?>	
	
	<?php
	
	if ($unassigned==0){
	echo("
	
	<form name='meetingSubmit' action='meeting.php' method='post'>
		
	<h5>Select the Date for the meeting. <br/> If the date picker is not displaying, please ensure the chosen date is in the form YYYY-MM-DD:</h5>
	
		<input class='form-control' type='date' name='mDate'/>
			<p class='text-danger'>
		$error2
	   </p>

	 <h5>Select time for meeting:</h5>
	
	<input type='radio' name='mTime' value='' checked> None <br>
	<input type='radio' name='mTime' value='08:00:00'> 8:00AM  -  10:00AM<br>
	<input type='radio' name='mTime' value='10:00:00'> 10:00AM -  12:00PM<br>
	<input type='radio' name='mTime' value='12:00:00'> 12:00PM -  2:00PM<br>
	<input type='radio' name='mTime' value='14:00:00'> 2:00PM  -  4:00PM<br>
	<input type='radio' name='mTime' value='16:00:00'> 4:00PM  -  6:00PM<br>
	<input type='radio' name='mTime' value='18:00:00'> 6:00PM  -  8:00PM<br>
	<p class='text-danger'>
		$error1	
	</p>
	<br/> <h5>Select type of meeting:</h5>
	<input type='radio' name='mType' value='' checked> None<br>
	<input type='radio' name='mType' value='online' > Online<br>
	<input type='radio' name='mType' value='offline'> Offline <br>
	<p class='text-danger'>
		$error5
	</p>
		</br>
		
	<input  type='submit' class='btn btn-sm btn-primary form-control' name='meetingSubmit' value= 'Register' />
	<br/>
	<br/>
	<input class='btn btn-sm btn-primary form-control' type='reset'>

	

	</form>

	
	");
	
	}else{
		echo("");
	}
	
	?>
	</br>
	<br/>
	</div> 
      <!-- /.row -->

	</div><!--Table Container end-->
    </div><!--Row End-->
	</div><!--Main Container End-->
      <!-- /.row -->
	
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-4 bg-dark col-lg-12">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; eTutor 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="bootstrap/jquery/jquery.min.js"></script>
    <script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
	

  </body>

</html>