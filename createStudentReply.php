<?php
require('studentSessionCheck.php');

if(isset($_SESSION)){
	$uID=$_SESSION['uID'];
}

//get the value of the message id from the url
$messageID = $_GET['messageID'];

$feedback="";
$error="";
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
			<a class="BreadEff" href="studentDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="studentMessaging.php"> Message Menu &raquo;</a>
			<a class="BreadEff" href="viewStudentMessagesReceived.php"> Messages Received &raquo; </a>
			<a class="BreadEff" href="#"> Message Reply </a>
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

	
	<!--Page Header-->
	<div class="col-sm-10">	
	<div class="container">
	<h1> Message</h1>
	<?php
	
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
	
	$stmt = mysqli_prepare ($mysqli, "SELECT message.messageID, message.sender, useraccount.firstName, useraccount.lastName, message.recipient, message.messageTitle, message.contentDetails, message.messageDate FROM message, useraccount WHERE message.messageID = ? AND useraccount.userID=message.sender");
	
	if($stmt)
	{
		//bind parameters for markers
		mysqli_stmt_bind_param($stmt, "i", $messageID);
		
		//execute query
		mysqli_stmt_execute($stmt);
		
		//bind the results
		mysqli_stmt_bind_result($stmt, $mID, $sID, $sFN, $sLN, $r, $mTitle, $cD, $date);
		
		//fetch the values
		if(mysqli_stmt_fetch($stmt))
		{
			$value1 = $mID;
			$value2=$sID;
			$value2a = $sFN;
			$value2b=$sLN;
			$value3 = $r;
			$value4 = $mTitle;
			$value5 = $cD;
			$value6 = $date;
		}
	}
	?>
	
	<h4>Message being Replied to:</h4>
	<form class="horizontal" method="post" action="createStudentReply.php?messageID=<?php echo($messageID); ?>">
		
		<input type="hidden" name="messageID" value="<?php echo($messageID);?>"/>
		
		<label>Message Sender ID:</label>
			<input type="text" name="mSender" class="form-control" readonly value="<?php echo($value2);?>"/>
			<br /> 
		
		<label>Message Sender:</label>
			<input type="text" name="mSenderName" class="form-control" readonly value="<?php echo($value2a." ".$value2b);?>"/>
			<br />
		
		<label>Message Title:</label>
			<input type="text" name="mTitle" class="form-control" readonly value="<?php echo($value4);?>"/>
			<span class="errorMessage"></span>
			<br /> <br />
			
			<label>Message Description:</label>
			<textarea class="form-control" name="mDesc" readonly placeholder="Enter your text here.."><?php echo($value5);?></textarea>
			<br /> 
		
	
	<h4>Reply to Message</h4>
	<br />
	<?php
		
		//determine if the button was clicked
		if (isset ($_POST["sendReply"]))
		{
			global $feedback;
			global $count;
			global $error;
			
			//get the values from the form
			$mSender = $_POST["mSender"];
			$rTitle = $_POST["rTitle"];
			$rDesc = $_POST["rDesc"];
			$rDate =date("Y-m-d");
			
		//do validation 
		$errorCount = 0;
		
		if ($rTitle == "" || $rTitle == null)
		{
			$error.="<br/>Please enter the title of the message.";
			$count++;
		}
		
		if ($rDesc == "" || $rDesc == null)
		{
			$error.="<br/>Please enter a description for the message.";
			$count++;
		}
		
		if ($count ==0)
			{
				//santize the values
				$mSender = filter_var ($mSender, FILTER_SANITIZE_STRING);
				$rTitle = filter_var ($rTitle, FILTER_SANITIZE_STRING);
				$rDesc = filter_var ($rDesc, FILTER_SANITIZE_STRING);
				
				//include database connection
				include("DBConnect.php");
				
				//do insert of reply table
				if ($stmt = mysqli_prepare ($mysqli, "INSERT INTO reply (sender, recipient, messageTitle, contentDetails, messageID, messageDate) VALUES (?, ?, ?, ?, ?, ?)"));
				{	
					//bind the parameters
					mysqli_stmt_bind_param ($stmt, "iissis",$uID, $mSender, $rTitle, $rDesc, $mID, $rDate);
					
					//execute query
					mysqli_stmt_execute ($stmt) or die (mysqli_error($mysqli));
				
					//close statement
					mysqli_stmt_close ($stmt);
				}

				$feedback.="<br/>Reply has been sent";
				
			}
		}
	
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
	
		<label>Message Title:</label>
			<input type="text" name="rTitle" class="form-control" value=""/>
			<br />
			
			<label>Message Description:</label>
			<textarea class="form-control" name="rDesc" placeholder="Enter your text here.."></textarea>
			<br /> 
				
		<input type="submit" class="btn btn-primary btn-sm form-control" name="sendReply" value="Send Reply">		
	</div>
	   
	   <br/>
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
