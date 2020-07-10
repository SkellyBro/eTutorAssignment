<?php 
require('adminSessionCheck.php');
//make calls to phpmailer
//v5.2.25 of phpmailer will be used
require('phpmailer/PHPMailerAutoload.php');

$count=0;
$feedback="";
$error="";

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Allocating Tutors</title>

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
	<!--Main Content Container-->
    <div class="container col-lg-12">
	<meta name="viewport" content="width=device-width, initial-scale=1">


      <div class="row">
	  
         <div class="col-lg-12">
		 
		 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="authorizedUserDashboard.php"> Dashboard &raquo; </a>
			<a class="BreadEff" href="#">Tutor Re-Allocation</a>
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
							<td><h6><a href="authorizedUserDashboard.php">Dashboard</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="studentTutorStatus.php">View All Students</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="studentAllocation.php">Student Allocation</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="allocate.php">Tutor Re-Allocation</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="deleteTutorFromStudent.php">Delete Student from Tutor</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="viewTutorBlog.php">View Tutor Blog</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="viewStudentBlog.php">View Students Blog</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="reportMenu.php">Report Menu</a></h6></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<!--Page Header-->
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	<h1>Administrator Dashboard</h1>
	<h3><a>	
				Welcome <?php if(isset($_SESSION['position'])){
				$firstName= $_SESSION['firstName'];
				$lastName=$_SESSION['lastName'];
				echo($firstName.' '.$lastName);}?> 
	</a></h3>
	
	<br />
	
	
	<!--User Table-->
	<div class="container">
		
		<form class="horizontal" method="post" action="allocate.php">
		
		<h4><label> Current Personal Tutor: </label><h4>
				<select class="form-control" name ="uID"> 
				<option value="0">---Select Personal Tutor---</option>
				
				<?php 
				//include the database connection	
				include("DBConnect.php");	
				$stmt = mysqli_prepare($mysqli, "SELECT tutor.userID, useraccount.firstName, useraccount.lastname FROM tutor, useraccount WHERE useraccount.userID=tutor.userID");

				if($stmt)
				{
					//execute query
					mysqli_stmt_execute($stmt);

					//bind the results
					mysqli_stmt_bind_result($stmt, $uID, $uFN, $uLN); 	

					//fetch the values
					while(mysqli_stmt_fetch($stmt))
					{
						echo("<option value='".$uID."'>".$uFN." ".$uLN."</option>");
					}
				}
				?>
				</select>
				
				<input type="submit" class="btn btn-sm btn-primary btn-block" name="selectTutor"/>
		</form>
		<br/>
	</div>
	
	<div class = "container">
		
		<table class='table table-bordered table-striped table-hover'>

		
		<?php
			//isset to perform the actual update
			if (isset($_POST['selectReTutor'])){
				$aTutor = $_POST['aTutor'];
				$sID= $_POST['sID'];

				validateData ($aTutor, $sID);
				if($count==0){
					for($i=0;$i<count($sID);$i++){
						
						//do insert into assign table
						require('DBConnect.php');
						
						//perform select query to get user email for automated email
						$stmt= mysqli_prepare($mysqli,
						"SELECT useraccount.email
						FROM useraccount
						WHERE useraccount.userID= ? ");
						if($stmt){
							//bind variables
							mysqli_stmt_bind_param($stmt, "i", $sID[$i]);
							
							//execute query 
							mysqli_stmt_execute ($stmt);
							
							//bind the results
							mysqli_stmt_bind_result ($stmt, $email);

							if (mysqli_stmt_fetch($stmt)){
								$feedback.="<br/>Student email acquired.";
							}else{
								$error.="An error was encoutered. Please contact a technician for assistance.";
								return false;
							}//end of if-else
						}//end of stmt
						
						//include database
						include('DBConnect.php');
						
						//prepare sql statement
						if ($stmt = mysqli_prepare($mysqli, "UPDATE assign SET tutorID = ? WHERE studentID = ?")){
								
							//bind parameters
							mysqli_stmt_bind_param($stmt, "ii", $aTutor, $sID[$i]);
								
							//execute query
							if(mysqli_stmt_execute($stmt)){
								
								//start email code
								
								$mail= new PHPMailer();

								$mail->isSMTP();
								$mail->SMTPAuth = true;
								$mail->SMTPSecture = 'ssl';
								$mail->Host = 'smtp.gmail.com';
								$mail->Port = '587';
								$mail->SMTPSecure = 'tls';
								$mail->isHTML();
								$mail->Username='ewsdgroup2018@gmail.com';
								$mail->Password= 'EWSD2018';
								$mail->SetFrom('no-reply@eTutor.com');
								$mail->Subject='Tutor Re-Allocation Notice';
								$mail->Body= 'Hello Sir/Madam, <br/>
									Please be advised that you have been re-allocated to one of our tutors! <br/>
									
									Please note that this email is automated, please do not reply to this. <br/>
									
									Kind Regards,
									eTutor Staff';
								$mail->AddAddress($email);
								
								//send the message, check for errors
									if (!$mail->send()) {
										$error.= "Mailer Error: " . $mail->ErrorInfo;
									} else {
										$feedback.="<br/>Student Notification Email Sent!";
										//Section 2: IMAP
										//Uncomment these to save your message in the 'Sent Mail' folder.
										#if (save_mail($mail)) {
										#    echo "Message saved!";
										#}
									}
								
								$feedback.= "<br/>Student has been reallocated to tutor.";
							}else{
								$error.= "Could not reallocate.";
						}//end of if-else
					}//end of stmt
				}//end of for loop
			}//end of count
		}//end of isset
		
		
		function validateData($aTutor, $sID){
			global $error;
			global $count;
			
			if($aTutor==0 || $aTutor== null){
				$count++;
				$error.="You must select a tutor to re-allocate students to.";
			}
			
			if(count($sID)==0){
				$count++;
				$error.="You must select a student to re-allocate";
			}
		}//end of validateData
			
			//this isset is sued to load all the students for the selected tutor and display the form to select the new tutor.
			if(isset($_POST['selectTutor'])){
					//make calls to the global error handlers
					global $count;
					global $error;
					
					//get userID from post, this userId identifies the selected tutor
					$uID=$_POST['uID'];
					
					//do some validation to ensure that the user does not select a null tutor.
					if($uID==0 || $uID== null){
						$count++;
						$error.="<br/>You must select a valid tutor to view their students!";
					}
					
					//error check to ensure that the user has no access to the following functionality should an error be found.
					if($count==0){
						echo("<form class='horizontal' method='post' action='allocate.php'>");
						
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
							
							echo "<h4>List of Selected Tutor's Students:</h4>
								<table class='table table-bordered table-striped table-hover'>
									  <tr>
										<th>Student ID</th>
										<th>Student First Name</th>
										<th>Student Last Name</th>
										<th>Student Gender</th>
										<th>Student Age</th>
										<th>Checkbox</th>
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
											<td><div class='radio'><label><input type='checkbox' name='sID[]' value='$sID'></label></div></td>
										</tr>";
									}//end of while 
									//echo html element to display button for form
									echo("</table>");
								}else{
									echo("<h5>No students have been assigned to this tutor.</h5>");
								}
							}//end of stmt
						
						//echo html elements needed for form
						echo("<h4><label>New Personal Tutor for Selected Students: </label></h4>
								<select class='form-control' name ='aTutor'> 
								<option value=''>---Select Personal Tutor---</option>");
					
						//include the database connection	
						include("DBConnect.php");	
						
						//create sql string to select new tutor information
						$stmt = mysqli_prepare($mysqli, "SELECT tutor.userID, useraccount.firstName, useraccount.lastName FROM tutor, useraccount WHERE useraccount.userID=tutor.userID");

							if($stmt)
							{
								//execute query
								mysqli_stmt_execute($stmt);

								//bind the results
								mysqli_stmt_bind_result($stmt, $uID, $uFN, $uLN); 	

								//fetch the values
								while(mysqli_stmt_fetch($stmt))
								{
									echo("<option value='".$uID."'>".$uFN." ".$uLN."</option>");
								}
							}
						//echo html elements to close select
						echo("</select>");
							echo("<input type='submit' class='btn btn-sm btn-primary btn-block' name='selectReTutor'/>");
							echo("</form>");
							echo("<br/>");
							echo("<br/>");
				}//end of isset
			}//end of error check
			
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
		
		</table>
		
		
		</div>
		


	
	</div>
	   
      
      <!-- /.row -->

     
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