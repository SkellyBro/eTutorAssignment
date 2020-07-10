<?php
require('adminSessionCheck.php');
//make calls to phpmailer
//v5.2.25 of phpmailer will be used
require('phpmailer/PHPMailerAutoload.php');

$error="";
$feedback="";
$count=0;

if(isset($_SESSION)){
	$uID=$_SESSION['uID'];
}

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
			<a class="BreadEff" href="authorizedUserDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="#.php">Student Allocation</a>
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
	<h1>Student Allocation</h1>
	<p>These are all the unallocated students, please select a tutor and allocate the students accordingly.</p>
	
	<form onsubmit="return assignStudent(this)" class="horizontal" method="post" action="studentAllocation.php">
		<select class="form-control" name ="tID"> 
		<option value="">---Select Personal Tutor to Assign Students to---</option>
		
			<?php 
			//this code is to load all tutors in a select 
			//include the database connection	
			include("DBConnect.php");	
			$stmt = mysqli_prepare($mysqli, "SELECT tutor.userID, useraccount.firstName, useraccount.lastname FROM tutor, useraccount WHERE useraccount.userID=tutor.userID");

			if($stmt)
			{
				//execute query
				mysqli_stmt_execute($stmt);

				//bind the results
				mysqli_stmt_bind_result($stmt, $tID, $tFN, $tLN); 	

				//fetch the values
				while(mysqli_stmt_fetch($stmt))
				{
					echo("<option value='".$tID."'>".$tFN." ".$tLN."</option>");
				}
			}
			?>
		</select>
		
		<br/>
		<br/>
		
		<?php
			
			//This code is for the validation and the actual insert into the db
			
			if(isset($_POST['allocate'])){
				
				$tID=$_POST['tID'];
				$sID=$_POST['sID'];

				//do validation to ensure user actually selected something
				validateData($tID, $sID);	
				
				//if check to ensure there are no errors
				if($count==0){
					
					//for loop for the array
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
						
						//prepare sql insert statement into assign table
						require('DBConnect.php');
						if ($stmt = mysqli_prepare($mysqli,
							"INSERT INTO assign(tutorID, studentID, adminID)
							VALUES(?, ?, ?)")){
								
							//Bind parameters to SQL Statement Object
							mysqli_stmt_bind_param($stmt, "iii", $tID, $sID[$i], $uID);
							//Execute statement object and check if successful
							if(mysqli_stmt_execute($stmt)){
								//start email code
								//create new phpmailer object
								$mail= new PHPMailer();
								
								//include necessary data for phpmailer object
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
								$mail->Subject='Tutor Allocation';
								$mail->Body= 'Hello Sir/Madam, <br/>
									Please be advised that you have been allocated to one of our tutors! <br/>
									
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
								
								$feedback.= "<br/>Student(s) assigned!";
							}else{
								$error.= "Students have not been assigned. Please contact a technician for assistance.";
							}//end of feedback if else 
						
						}//end mysqli prepare statement
						
					}//end of for loop 
				}//end of $count if 
			}//end of isset
			
			//function to validate entered data
			function validateData($tID, $sID){
				global $error;
				global $count;
				
				if($tID==0 || $tID== null){
					$error.= "<br/> You must select a tutor."; 
					$count++;
				}
				
				if(count($sID)==0){
					$error.= "<br/> You must select a student to assign."; 
					$count++;
				}
				
			};//end of validateData function
			
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

		
			//this code is to display all unallocated students.
		
			//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
			IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
			FROM useraccount
			WHERE useraccount.position=2
            AND useraccount.userID NOT IN (SELECT useraccount.userID FROM useraccount, assign WHERE useraccount.userID=assign.studentID)
            GROUP BY useraccount.userID");
			if ($stmt)
				{	
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
				
				echo "	<h4>Unassigned Students:</h4>
						<p>Click the checkbox for each student you wish to assign to the selected tutor.</p>
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
								<td><div class='checkbox'><label><input type='checkbox' name='sID[]' value='$sID'></label></div></td>
							</tr>";
						}//end of while
					echo("  </tr>
							</table>
							<input type='submit' class='btn btn-primary btn-block' name='allocate' value='Allocate Students'>
							<br/>");
					}else{
						echo("<h5>No students are currently unassigned.</h5>");
					}
				}//end of stmt
		
		?>
		
		</div>
	
	</div>  
	</form>
      
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