<?php
require('tutorSessionCheck.php');
$feedback="";
$count=0;
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>eTutor</title>

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
			<td><h6><a href="tutorDashboard.php">Dashboard</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="documentUploadArea.php">Upload Documents</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewStudentUploadList.php">Student Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewPersonalUploads.php">Your Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="messaging.php">Messaging</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="tutorBlog.php">Your Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewStudentBlog.php">View Student Blogs</a></h6></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
		
	<!--Page Header-->
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	<h1>Tutor Dashboard</h1>
	<h3><a>	
				Welcome <?php if(isset($_SESSION['position'])){
				$firstName= $_SESSION['firstName'];
				$lastName=$_SESSION['lastName'];
				$uID=$_SESSION['uID'];
				echo($firstName.' '.$lastName);}?> 
	</a></h3>
	
	
	
		<br />
		<!--Student Sorting/ Filtering Form-->
		<form class="horizontal" method="post" action="tutorDashboard.php">
		
		<div class="form-group">
			<label class="control-label">Student Search:</label>
		 
			<input type="text" class="form-control" name="fName" placeholder="Student Firstname"/> 
		 
			<input type="text" class="form-control" name="lName" placeholder="Student Lastname"/> 
			
			<input type="submit" class="btn btn-sm btn-primary form-control" name="submitName"/>
		 </div>
		
		
		</form>
		
		
		<form class="horizontal" method="post" action="tutorDashboard.php">
			<label>Student Sorting: </label>
			<select class="form-control" name="Sort">
				<option value="">----Sorting Options----</option>
				<option value="age">Age</option>
				<option value="gender">Gender</option>
				<option value="firstName">First Name</option>
				<option value="lastName">Last Name</option>
			</select>
			<input type="submit" class="btn btn-sm btn-primary form-control" name="submitSort"/>
		</form>
			
			<br/>
			
		<form class="horizontal" method="post" action="tutorDashboard.php">
		
			<label class="control-label">Reset Student Table:</label>
		
			<input type="submit" class="btn btn-primary btn-sm" name="loadAll" value="Reload">
		
		</form>
		
			
	</div>
	</form>	
	<br/>
	<div class="container">
		
		<?php
			//if a name was submitted this code will run
			if(isset($_POST['submitName'])){
				global $feedback;
						
				//get variable passed from textbox
				$fName=$_POST['fName'];
				$lName=$_POST['lName'];
				
				//validate entered user data
				validateData($fName, $lName);
				
				if($count==0){
					//sanitize entered data for foreign symbols
					sanitizeData($fName);
					sanitizeData($lName);
					
					//include database connection
					include("DBConnect.php");
				
					//prepare sql statement
					$stmt = mysqli_prepare ($mysqli, 
					"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
					IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
					FROM useraccount, assign
					WHERE useraccount.position=2
					AND useraccount.userID = assign.studentID
					AND assign.tutorID=?
					AND (useraccount.firstName LIKE ? 
					OR useraccount.lastName LIKE ?)");
					if ($stmt)
					{	
						//bind variables
						mysqli_stmt_bind_param($stmt, "iss", $uID, $fName, $lName);
						
						//execute query 
						mysqli_stmt_execute ($stmt);
						
						//bind the results
						mysqli_stmt_bind_result ($stmt, $fn, $ln, $sID, $gender, $age);
						
						//store result to check resultSet
						mysqli_stmt_store_result($stmt);
						
						//store number of rows in variable
						$resultSet= mysqli_stmt_num_rows($stmt);
						
						if($resultSet>=1){
						
						echo "<h4>Search Results:</h4>
								<table class='table table-bordered table-striped table-hover'>
							  <tr>
								<th>Student ID</th>
								<th>Student First Name</th>
								<th>Student Last Name</th>
								<th>Student Gender</th>
								<th>Student Age</th>
							  </tr>";

						//fetch the values
						while(mysqli_stmt_fetch($stmt))
							{
								echo "<tr>
									<td>".$sID ."</td>
									<td>".$fn."</td>
									<td>".$ln."</td>
									<td>".$gender."</td>
									<td>".$age."</td>
								</tr>";
							}//end of while
							echo("</table>");
						}else{
							echo("<h6>No results found for search criteria.</h6>");
						}
					}//end of stmt
				}//end of count if				
				
			}elseif(isset($_POST['submitSort'])){
				$sortOp=$_POST['Sort'];
				
				if($sortOp=="age"){
					ageSort();
				
				}elseif($sortOp=="firstName"){
					fNameSort();
				
				}elseif($sortOp=="lastName"){
					lNameSort();
				
				}else{
					genderSort();
				}
			
			}else{
			
			//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
			IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
			FROM useraccount, assign
			WHERE useraccount.position=2
			AND useraccount.userID = assign.studentID
			AND assign.tutorID=?");
			if ($stmt)
				{
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);	
					
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $ln, $sID, $gender, $age);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				echo "<h4>List of Students:</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Student ID</th>
							<th>Student First Name</th>
							<th>Student Last Name</th>
							<th>Student Gender</th>
							<th>Student Age</th>
							<th>View More Details</th>
						  </tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
						{
							echo "<tr>
								<td>".$sID."</td>
								<td>".$fn."</td>
								<td>".$ln."</td>
								<td>".$gender."</td>
								<td>".$age."</td>
								<td><a href= 'viewStudentInformation.php?userID=".$sID."'>View More Details</a></td>
							</tr>";
						}//end of while 
						echo("</table>");
					}else{
						echo("<h5>No students have been assigned to you as yet. Please contact the system admin for assistance if necessary.</h5>");
					}
				}//end of stmt
				
				
			//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT message.messageID, useraccount.firstName, useraccount.lastName, message.messageTitle, message.contentDetails, message.messageDate
			FROM message, useraccount
			WHERE message.recipient=?
			AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND CURRENT_DATE()
			AND message.sender= useraccount.userID");
			if ($stmt)
				{
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);	
					
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $mID, $firstName, $lastName, $mTitle, $mDetails, $mDate);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				echo "<h4>Messages Received in the last 7 days:</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Message ID</th>
							<th>Sender</th>
							<th>Message Title</th>
							<th>Message Details</th>
							<th>Message Date</th>
						  </tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
						{
							echo "<tr>
								<td>".$mID."</td>
								<td>".$firstName.' '.$lastName."</td>
								<td>".$mTitle."</td>
								<td>".$mDetails."</td>
								<td>".$mDate."</td>
							</tr>";
						}//end of while 
						echo("</table>");
					}else{
						echo("<h5>No messages have been received in the last 7 days.</h5>");
					}
				}//end of stmt
				
				//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT reply.replyID, useraccount.firstName, useraccount.firstName, reply.messageTitle, reply.contentDetails, reply.messageID, reply.messageDate
			FROM reply, useraccount
			WHERE reply.recipient=?
			AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND CURRENT_DATE()
			AND reply.sender= useraccount.userID");
			if ($stmt)
				{
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);	
					
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $rID, $firstName, $lastName, $rTitle, $rDetails, $mID, $rDate);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				echo "<h4>Replies Received in the last 7 days:</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Reply ID</th>
							<th>Sender</th>
							<th>Reply Title</th>
							<th>Reply Details</th>
							<th>Message ID</th>
							<th>Reply Date</th>
						  </tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
						{
							echo "<tr>
								<td>".$mID."</td>
								<td>".$firstName.' '.$lastName."</td>
								<td>".$rTitle."</td>
								<td>".$rDetails."</td>
								<td>".$mID."</td>
								<td>".$rDate."</td>
							</tr>";
						}//end of while 
						echo("</table>");
					}else{
						echo("<h5>No message replies received in the last 7 days.</h5>");
					}
				}//end of stmt
				
				//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT meeting.meetingID, useraccount.firstName, useraccount.lastName, meeting.meetingDate, meeting.meetingTime, meeting.meetingType
			FROM useraccount, meeting
			WHERE meeting.meetingHost=?
			AND meeting.meetingDate BETWEEN CURRENT_DATE() AND (CURRENT_DATE()+ INTERVAL+7 DAY)
			AND meeting.meetingAttendee= useraccount.userID");
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
				
				echo "<h4>Upcoming Meetings:</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Meeting ID</th>
							<th>Attendee</th>
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
						echo("<h5>No meetings have been booked by your students as yet.</h5>");
					}
				}//end of stmt
				
				
				//prepare sql statement
		$stmt=mysqli_prepare($mysqli, 
		"SELECT useraccount.firstName, useraccount.lastName, documents.documentName, documents.documentDescription, documents.uploadDate
		FROM documents, assign, useraccount
		WHERE useraccount.userID=assign.studentID
		AND assign.studentID=documents.uploadedBy
		AND documents.uploadDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND CURRENT_DATE()
		AND assign.tutorID=?");
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
				echo "<br/> <h4>Recent Uploads From Students in last 7 days:</h4>
				<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Student Name</th>
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
					echo("<h5>No Documents have been uploaded by your students as yet.</h5>");
				}//end of resultSet if
		}//end of stmt
			}//end of isset
			
			
			
			//this runs if the "reset table" button was clicked to recover the table with all records in the event of a search
			//it litterally does nothing but force the page to reload the table
			//without calling a header
			if(isset($_POST['loadAll'])){
			}//end of isset
			
			
			//Function dump start
			//Function dump is sorted alphabetically. 
			
			
			//function that houses sql for age sorting
			function ageSort(){
				global $uID;
				//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
			IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age 
			FROM useraccount, assign
			WHERE useraccount.position=2
			AND useraccount.userID = assign.studentID
			AND assign.tutorID=?
			ORDER BY age ASC");
			if ($stmt)
				{	
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
				
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $ln, $sID, $gender, $age);
				
				echo "<h5>Currently Sorted by Age (Ascending)</h5>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Student ID</th>
							<th>Student First Name</th>
							<th>Student Last Name</th>
							<th>Student Gender</th>
							<th>Student Age</th>
						  </tr>
						  <tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
					{
						echo "<tr>
							<td>".$sID."</td>
							<td>".$fn."</td>
							<td>".$ln."</td>
							<td>".$gender."</td>
							<td>".$age."</td>
						</tr>";
					}//end of while 	
				}//end of stmt
			}//end of ageSort
			
			//function that houses sql for sorting by firstName
			function fNameSort(){
			global $uID;
			//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
			IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
			FROM useraccount, assign
			WHERE useraccount.position=2
			AND useraccount.userID = assign.studentID
			AND assign.tutorID=?
			ORDER BY useraccount.firstName ASC");
			if ($stmt)
				{	
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
				
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $ln, $uid, $gender, $age);
				
				echo "<h5>Currently Sorted by First Name (Ascending)</h5>
				<table class='table table-bordered table-striped table-hover'>	
						  <tr>
							<th>Student ID</th>
							<th>Student First Name</th>
							<th>Student Last Name</th>
							<th>Student Gender</th>
							<th>Student Age</th>
						  </tr>
						  <tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
					{
						echo "<tr>
							<td>".$uid ."</td>
							<td>".$fn."</td>
							<td>".$ln."</td>
							<td>".$gender."</td>
							<td>".$age."</td>
						</tr>";
					}//end of while 	
				}//end of stmt
			}//end of function fNameSort
			
			
			//function that houses sql for sorting by lastName
			function genderSort(){
			global $uID;
			//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
			IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
			FROM useraccount, assign
			WHERE useraccount.position=2
			AND useraccount.userID = assign.studentID
			AND assign.tutorID=?
			ORDER BY useraccount.gender ASC");
			if ($stmt)
				{	
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
				
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $ln, $uid, $gender, $age);
				
				echo "<h5>Currently Sorted by Gender (Ascending)</h5>
				<table class='table table-bordered table-striped table-hover'>	
						  <tr>
							<th>Student ID</th>
							<th>Student First Name</th>
							<th>Student Last Name</th>
							<th>Student Gender</th>
							<th>Student Age</th>
						  </tr>
						  <tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
					{
						echo "<tr>
							<td>".$uid ."</td>
							<td>".$fn."</td>
							<td>".$ln."</td>
							<td>".$gender."</td>
							<td>".$age."</td>
						</tr>";
					}//end of while 	
				}//end of stmt
			}//end of function genderSort
			
			
			//function that houses sql for sorting by lastName
			function lNameSort(){
			global $uID;
			//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
			IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
			FROM useraccount, assign
			WHERE useraccount.position=2
			AND useraccount.userID = assign.studentID
			AND assign.tutorID=?
			ORDER BY useraccount.lastName ASC");
			if ($stmt)
				{	
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);
				
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $ln, $uid, $gender, $age);
				
				echo "<h5>Currently Sorted by Last Name (Ascending)</h5>
				<table class='table table-bordered table-striped table-hover'>	
						  <tr>
							<th>Student ID</th>
							<th>Student First Name</th>
							<th>Student Last Name</th>
							<th>Student Gender</th>
							<th>Student Age</th>
						  </tr>
						  <tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
					{
						echo "<tr>
							<td>".$uid ."</td>
							<td>".$fn."</td>
							<td>".$ln."</td>
							<td>".$gender."</td>
							<td>".$age."</td>
						</tr>";
					}//end of while 	
				}//end of stmt
			}//end of function fNameSort
			
			function sanitizeData($val){
				$val= filter_var($val, FILTER_SANITIZE_STRING);
				
				//include php code
				include('DBConnect.php');
			
				//sanitize data going into MySQL
				$val= mysqli_real_escape_string($mysqli, $val);
			
				return $val;
			}//end of sanitizeData
			
			//function to validate entered search critera
			function validateData($fN, $lN){
				global $feedback;
				global $count;
				$count=0;
				
				
				if(preg_match("([A-Za-z\s\w]+)", $fN) || preg_match("[^$]", $fN)){
					
				}else{
					$count++;
					$feedback.="<br/>Firstname cannot contain special symbols or be numeric.";
				}
			
				
				if(preg_match("([A-Za-z\^$]+)", $lN) || preg_match("[^$]", $lN)){
					
				}else{
					$count++;
					$feedback.="<br/>Lastname cannot contain special symbols or be numeric.";
				}
				
			}
			
			
			
			
			if($feedback != ""){
		 
				 echo "<div class= 'alert alert-danger'>"; 
				   if ($count == 1) echo "<strong>$count error found.</strong>";
				   if ($count > 1) echo "<strong>$count errors found.</strong>";
				 echo "$feedback
				   </div>";
				
			}//end of function validateData

			
			
		?>
	<!--php goes here-->
	  </tr>
	</table>
	</div>
	   
      
      <!-- /.row -->

		</div>
      </div>
	  </div>
      <!-- /.row -->
	</div>
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
