<?php

require('studentSessionCheck.php');

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
			<a class="BreadEff" href="#"> Dashboard</a>
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
		
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	<h1>Student Dashboard</h1>
	<h2><a>	
				Welcome <?php if(isset($_SESSION['position'])){
				$firstName= $_SESSION['firstName'];
				$lastName=$_SESSION['lastName'];
				echo($firstName.' '.$lastName);}?> 
	</a></h2>
	<h3>Tutor Interaction Feed for Past 7 days:</h3>
	<h4>Recent Messages With Personal Tutor:</h4>	
		
	</div>
	
	<div class="container">
	<?php
	
		$senderFN="";
		$senderLN="";
		$mTitle="";
		$conDetails="";
		$date="";
		$uID=0;
		$docName="";
		$docDesc="";
		
		
		if(isset($_SESSION)){
		$uID=$_SESSION['uID'];
		}
		
		include('DBConnect.php');
		//tutor messages table
		//prepare sql statement
		$stmt=mysqli_prepare($mysqli, 
		"SELECT useraccount.firstName, useraccount.lastName, message.messageTitle ,message.contentDetails, message.messageDate
		FROM useraccount, message, assign
		WHERE useraccount.userID=assign.tutorID
		AND assign.tutorID= message.sender
        AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND CURRENT_DATE()
		AND assign.studentID=?");
		if($stmt){
			
			//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
			
			//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $senderFN, $senderLN, $mTitle, $conDetails, $date);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				echo "<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Personal Tutor Name</th>
							<th>Message Title</th>
							<th>Message Content</th>
							<th>Date/Time</th>
						  </tr>";	
				//fetch the values
				while(mysqli_stmt_fetch($stmt)){
						echo "<tr>
							<td>".$senderFN.' '.$senderLN ."</td>
							<td>".$mTitle."</td>
							<td>".$conDetails."</td>
							<td>".$date."</td>
						</tr>";
					}//end of while
					echo("</table>");
				}else{
					echo("<h6>No messages have been sent by your tutor as yet.</h6>");
				}//end of resultSet if	
		}//end of stmt if
		
		include('DBConnect.php');
		//tutor replies table
		//prepare sql statement
		$stmt=mysqli_prepare($mysqli, 
		"SELECT useraccount.firstName, useraccount.lastName, reply.messageTitle ,reply.contentDetails, reply.messageDate
		FROM useraccount, reply, assign
		WHERE useraccount.userID=assign.tutorID
		AND assign.tutorID= reply.sender
		AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND CURRENT_DATE()
		AND assign.studentID=?");
		if($stmt){
			
			//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
			
			//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $senderFN, $senderLN, $mTitle, $conDetails, $date);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				echo "<h4>Recent Replies from Personal Tutor:</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Personal Tutor Name</th>
							<th>Message Title</th>
							<th>Message Content</th>
							<th>Date/Time</th>
						  </tr>";	
				//fetch the values
				while(mysqli_stmt_fetch($stmt)){
						echo "<tr>
							<td>".$senderFN.' '.$senderLN ."</td>
							<td>".$mTitle."</td>
							<td>".$conDetails."</td>
							<td>".$date."</td>
						</tr>";
					}//end of while
					echo("</table>");
				}else{
					echo("<h4>Recent Replies from Personal Tutor:</h4>");
					echo("<h5>No Message Replies have been sent by your tutor as yet.</h5>");
				}//end of resultSet if	
		}//end of stmt if
		
		//meeting table
		//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT meeting.meetingID, useraccount.firstName, useraccount.lastName, meeting.meetingDate, meeting.meetingTime, meeting.meetingType
			FROM useraccount, meeting
			WHERE meeting.meetingAttendee=?
			AND meeting.meetingHost= useraccount.userID
			AND meeting.meetingDate BETWEEN CURRENT_DATE() AND (CURRENT_DATE()+ INTERVAL+7 DAY)");
			if ($stmt)
				{
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);	
					
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $meetID, $firstName, $lastName, $meetingDate, $meetingTime, $meetingType);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				echo "<h4>Upcoming Meetings with Personal Tutor:</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Meeting ID</th>
							<th>Meeting Host</th>
							<th>Meeting Date</th>
							<th>Meeting Time</th>
							<th>Meeting Type</th>
						  </tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
						{
							echo "<tr>
								<td>".$meetID."</td>
								<td>".$firstName.' '.$lastName."</td>
								<td>".$meetingDate."</td>
								<td>".$meetingTime."</td>
								<td>".$meetingType."</td>
							</tr>";
						}//end of while 
						echo("</table>");
					}else{
						echo("<h4>Upcoming Meetings with Personal Tutor</h4>");
						echo("<h5>No meetings have been made between you and your tuto.</h5>");
					}
			}//end of stmt
	
	//uploaded documents table
	//prepare sql statement
		$stmt=mysqli_prepare($mysqli, 
		"SELECT useraccount.firstName, useraccount.lastName, documents.documentName, documents.documentDescription, documents.uploadDate
		FROM documents, assign, useraccount
		WHERE useraccount.userID=assign.tutorID
		AND assign.tutorID=documents.uploadedBy
		AND documents.uploadDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND CURRENT_DATE()
		AND assign.studentID=?");
		if($stmt){
			
			//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
			
			//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $senderFN, $senderLN, $docName, $docDesc, $date);
				
				mysqli_stmt_store_result($stmt);
				
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				if($resultSet>=1){
				echo "<br/> <h4>Recent Uploads From Personal Tutor:</h4>
				<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Personal Tutor Name</th>
							<th>Document Name</th>
							<th>Document Description</th>
							<th>Date/Time</th>
						  </tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
					{
						echo "<tr>
							<td>".$senderFN.' '.$senderLN ."</td>
							<td>".$docName."</td>
							<td>".$docDesc."</td>
							<td>".$date."</td>
						</tr>";
					}//end of while
					echo("</table>");
				}else{
					echo("<h4>Recent Uploads From Personal Tutor</h4>");
					echo("<h5>No Documents have been uploaded by your tutor as yet.</h5>");
				}//end of resultSet if
		}//end of stmt
	
	?>
	</table>
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
