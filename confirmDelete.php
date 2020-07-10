<?php 
require('adminSessionCheck.php');
//make calls to phpmailer
//v5.2.25 of phpmailer will be used
require('phpmailer/PHPMailerAutoload.php');
$uID= $_GET['userID'];
$feedback="";
$error="";

require('DBConnect.php');
						
	//perform select query to get student email for automated email
	$stmt= mysqli_prepare($mysqli,
	"SELECT useraccount.email
	FROM useraccount
	WHERE useraccount.userID= ? ");
	if($stmt){
		//bind variables
		mysqli_stmt_bind_param($stmt, "i", $uID);
		
		//execute query 
		mysqli_stmt_execute ($stmt);
		
		//bind the results
		mysqli_stmt_bind_result ($stmt, $email);

		if (mysqli_stmt_fetch($stmt)){
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
			$mail->Subject='Tutor Removal';
			$mail->Body= 'Hello Sir/Madam, <br/>
				Please be advised that you have been relieved of your current tutor. <br/>
				
				You will be assigned a new tutor in the coming days. <br/>
				
				If you do not want a new tutor please contact the administrator and notify them. <br/>
				
				Please do not respond to this email. <br/>
				
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
		}else{
			$error.="An error was encoutered. Please contact a technician for assistance.";
			return false;
		}//end of if-else
	}//end of stmt

	//perform select query to get tutor email for automated email
	//make call to dbconnector
	require('DBConnect.php');
	//create query
	$stmt= mysqli_prepare($mysqli,
	"SELECT useraccount.email
	FROM useraccount, assign
	WHERE useraccount.userID= assign.tutorID
    AND assign.studentID=? ");
	if($stmt){
		//bind variables
		mysqli_stmt_bind_param($stmt, "i", $uID);
		
		//execute query 
		mysqli_stmt_execute ($stmt);
		
		//bind the results
		mysqli_stmt_bind_result ($stmt, $email);

		if (mysqli_stmt_fetch($stmt)){
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
			$mail->Subject='Student Removal';
			$mail->Body= 'Hello Sir/Madam, <br/>
				Please be advised that you have been relieved of one of your current students. <br/>
				
				You will be assigned a new student in the coming days. <br/>
				
				Please do not respond to this email. <br/>
				
				Kind Regards, 
				eTutor Staff';
			$mail->AddAddress($email);
			
			//send the message, check for errors
				if (!$mail->send()) {
					$error.= "Mailer Error: " . $mail->ErrorInfo;
				} else {
					$feedback.="<br/>Tutor Notification Email Sent!";
					//Section 2: IMAP
					//Uncomment these to save your message in the 'Sent Mail' folder.
					#if (save_mail($mail)) {
					#    echo "Message saved!";
					#}
				}
		}else{
			$error.="An error was encoutered. Please contact a technician for assistance.";
			return false;
		}//end of if-else
	}//end of stmt
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
	<!--Main Content Container-->
    <div class="container col-lg-12">
	<meta name="viewport" content="width=device-width, initial-scale=1">


      <div class="row">
	  
         <div class="col-lg-12">
		 
		 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="authorizedUserDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="#"> Delete Tutor From Student </a>
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
			<td><h6><a href="tutorBlog.php">Your Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="#">Lorum Ipsum</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="#">Lorum Ipsum</a></h6></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
	
	<!--Page Header-->
	<div class="col-sm-10">	
	<div class="container">
	<h1>Delete Tutor from student</h1>
	<h3><a>	
				Welcome <?php if(isset($_SESSION['position'])){
				$firstName= $_SESSION['firstName'];
				$lastName=$_SESSION['lastName'];
				echo($firstName.' '.$lastName);}?> 
	</a></h3>
		
	<br />
			<p>
				The tutor has been deleted from this student. You will be directed to the student list shortly.
			</p>
	
	<!--User Table-->
	<div class="container">

		
	</div>
	<br/>
	
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
	
	
	//include database connection
			include("DBConnect.php");
			
			$stmt = mysqli_prepare($mysqli, "DELETE FROM assign 
					WHERE studentID = ?
					");
			
			if($stmt)
			{
				//bind parameters for markers
				mysqli_stmt_bind_param($stmt,"i",$uID);
				
				//execute query
				mysqli_stmt_execute($stmt);
				
				//close the statement
				mysqli_stmt_close($stmt);
			}
			//close the connection
			mysqli_close($mysqli);
		
		//this runs if the "reset table" button was clicked to recover the table with all records in the event of a search
			//it litterally does nothing but force the page to reload the table
			//without calling a header
			if(isset($_POST['loadAll'])){

			}//end of isset
			
		
	?>
	  </tr>
	</table>
	</div>
	   
      
      <!-- /.row -->

     
      </div>
	 </div>
      <!-- /.row -->
	</div>
    <!-- /.container -->
	<meta http-equiv="refresh" content= "5;URL=deleteTutorFromStudent.php"/>

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