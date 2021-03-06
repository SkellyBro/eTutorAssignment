<?php


require('tutorSessionCheck.php');

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
			<a class="BreadEff" href="tutorDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="messages.php"> Message Menu &raquo;</a>
			<a class="BreadEff" href="viewTutorMessageList.php"> Message List &raquo;</a>
			<a class="BreadEff" href="#">Edit Message</a>
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
			<td><h6><a href="messaging.php">Messaging</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewStudentBlog.php">View Student Blog</a></h6></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
	
<?php
	$error="";
	$count=0;
	$feedback="";
	
	$messageID =$_GET['messageID'];
	
	//Write query to retreive message details
	//setup value holders
	$value1 = "";
	$value2 = "";
	$value3 = "";
	$value4 = "";
	$value5 = "";
	$value6 = "";
	
	//include database connection
	include("DBConnect.php");
	
	$stmt = mysqli_prepare ($mysqli, "SELECT message.messageID, message.sender, message.recipient, message.messageTitle, message.contentDetails, message.messageDate FROM message WHERE message.messageID = ?");
	
	if($stmt)
	{
		//bind parameters for markers
		mysqli_stmt_bind_param($stmt, "i", $messageID);
		
		//execute query
		mysqli_stmt_execute($stmt);
		
		//bind the results
		mysqli_stmt_bind_result($stmt, $mID, $s, $r, $mTitle, $cD, $date);
		
		//fetch the values
		if(mysqli_stmt_fetch($stmt))
		{
			$value1 = $mID;
			$value2 = $s;
			$value3 = $r;
			$value4 = $mTitle;
			$value5 = $cD;
			$value6 = $date;
		}
	}
	
	//determine if the button was clicked
	if (isset ($_POST["editMessage"]))
	{
		//get the values from the form
		$mTitle = $_POST["mTitle"];
		$mDesc = $_POST["mDesc"];
		
		//do validation
		
		if ($mTitle == "" || $mTitle == null)
		{
			$error.="Please enter the title of the message.";
			$count++;
		}
		
		if ($mDesc == "" || $mDesc == null)
		{
			$error.="Please enter a description for the message.";
			$count++;
		}
	
	
		if ($count ==0)
		{
			//santize the values 
			$mTitle = filter_var ($mTitle, FILTER_SANITIZE_STRING);
			$mDesc = filter_var ($mDesc, FILTER_SANITIZE_STRING);
			
			//include database connection
			include("DBConnect.php");
			
			//do insert into message table
			if ($stmt = mysqli_prepare ($mysqli, "UPDATE message SET messageTitle = ?, contentDetails = ? WHERE messageID = ?"))
			{
				//bind parameters
				mysqli_stmt_bind_param ($stmt, "ssi", $mTitle, $mDesc, $mID);
				
				//Execute statement object and check if successful
				if(mysqli_stmt_execute($stmt)){
					$feedback.= "<br/>Message updated!";
				
				}else{
					$error.= "<br/>Message not updated. Please contact a technician.";
					$count++;
				}
				
				//close statement
				mysqli_stmt_close ($stmt);
			}
		}
	}
	
	//isset to carry user back to menu
	if(isset($_POST['return'])){
		Header("Location:viewTutorMessageList.php");
	}
	?>
	
	<!--Page Header-->
	<div class="col-sm-10">	
	<div class="container">
	<h1> Messaging </h1>
	<h5>Edit Message</h5>
	
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
	<br />
	<h6>Manditory Fields</h6>
	<br />
	
		<form class="horizontal" method="post" action="editTutorMessage.php?messageID=<?php echo($messageID); ?>">
		<div class="form-group">
		<input type="hidden" name="messageID" value="<?php echo($messageID);?>"/>
			
		<label>Message Title:</label>
			<input class="form-control" type="text" name="mTitle" value="<?php echo($value4);?>" size="50"/>
			<br/>

		<!--
			Code Adapted from: https://mdbootstrap.com/components/bootstrap-textarea/
			Code Author: mdbootstrap.com
			Code Accessed On: 11/10/2018
			-->
			<div class="form-group green-border-focus">
				<label for="exampleFormControlTextarea5">Message Description:</label>
				<textarea class="form-control" name="mDesc"  rows="3"><?php echo($value5);?></textarea>
			</div>
			
			<input type="submit" class="btn btn-primary btn-sm form-control" name="editMessage" value="Edit Message"/>
			<br/><br/>
			<input type="submit" class="btn btn-sm btn-primary form-control" name="return" value="Return to Message List"/>
			
		</form>
		</div>
			
	</div>
	
	<br/>
	   
      
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
