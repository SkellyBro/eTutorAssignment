<?php
//include security 
require('studentSessionCheck.php');

//get the id from session 
$uploadedBy = $_SESSION["uID"];

//create error holders
$feedback="";
$error="";
$count=0;

//determine if the submit button was pressed 
if(isset($_POST["submitBlog"])){
	$title = $_POST["title"];
	$content = $_POST["content"];
	
	//do validation 
		
		if($title == "" || $title == null ) {
		$error.="<br/>You must have a Title for your Blog post";
		$count++;
	}//end title validation 	
		
			if($content == "" || $content == null ) {
		$error.="<br/>You must enter some text content for your Blog post";
		$count++;
	}//end content validation
	
	if($count == 0) {
		//capitalise
		$title = ucfirst($title);
		
		//sanitise
		$title = filter_var($title, FILTER_SANITIZE_STRING);
		$content = filter_var($content, FILTER_SANITIZE_STRING);
		$uploadedBy = filter_var($uploadedBy, FILTER_SANITIZE_STRING);
		
		//include the database connection
		include("DBConnect.php");
		
			if ($stmt = mysqli_prepare ($mysqli, "INSERT INTO blog(title, content, uploadedBy) VALUES (?, ?, ?)")) {
			//bind parameters for markers
			mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $uploadedBy);
			
			//execute query 
			if(mysqli_stmt_execute($stmt)){
				$feedback.= "<br/>Your blog post has been made Successfully!";
			
			}else{
				$error.= "<br/>Blog post not made. Please contact a technician.";
				$count++;
			}	
			
			//close statement
			mysqli_stmt_close($stmt);
		
			//close connection 
			mysqli_close($mysqli);
				echo("<br />");
				echo("<br />");
				echo("<br />");
				//echo "<script>alert('Your Blog was added successfully !');</script>";
			

		}//end of stmt
	}//end of if statement
	
}//end of submit 



?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student Blog</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/sideNav.css"/>
	<link rel="stylesheet" type="text/css" href="css/table.css"/>


</style>

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
			<a class="BreadEff" href="studentDashboard.php"> Dashboard &raquo; </a> 
			<a class="BreadEff" href="studentBlog.php"> Blogs</a>
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
	<h1>Your Blog</h1>
		
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
		
		<!--Student Blog post Form-->
		<form class="horizontal" method="post" action="studentBlog.php">
			<label class="control-label">Create a new Blog post below:</label>
			
			<div class="form-group"> 
				<input type="text" class="form-control" name="title" placeholder="Blog Title" aria-labelledby="blog title"/> 
			</div>
			
			<!--
			Code Adapted from: https://mdbootstrap.com/components/bootstrap-textarea/
			Code Author: mdbootstrap.com
			Code Accessed On: 11/10/2018
			-->
			<div class="form-group green-border-focus">
				<textarea class="form-control" name="content"  rows="3" placeholder="Enter your text here.."></textarea>
				<br/>
				<input type="submit" class="btn btn-sm btn-primary form-control" name="submitBlog"/>
			</div>
			
		
		</form>
			<!--End of Student Blog post Form-->
			
		
			
	</div>

	<br/>
	<div class="container">
		
	
	<!--Viewing of all blogs made by the Student -->
	<?php
		//include the database connection
		include("DBConnect.php");
//query
	$stmt = mysqli_prepare($mysqli, "SELECT blog.blogID, blog.title, blog.content, blog.uploadedBy, blog.dateUploaded, blog.dateLastEdited FROM blog, useraccount WHERE blog.uploadedBy = useraccount.userID AND useraccount.userID=? GROUP BY blog.blogID ORDER BY blog.dateUploaded ASC");
	if($stmt) {
		
		//bind parameters for markers 
		mysqli_stmt_bind_param($stmt, "i", $uploadedBy);
		
		//execute query 
		mysqli_stmt_execute($stmt);
				
		//bind the results
		mysqli_stmt_bind_result($stmt, $bId, $btitle, $bCont, $bUploader, $bDateUpload, $bLastEdited);
		
	echo("<h3> My Blog Posts:</h3>");
	echo("<hr>");
	
		//fetch the values 
		while(mysqli_stmt_fetch($stmt)) {
		echo ("<br />");
			
			//echo blog post in bootstrap card element
			echo("
			
			<div class='col-sm-11'>
			  <div class='card'>
				<div class='card-body'>
				  <h4 class='card-title'>Blog Title: $btitle</h4>
				  <p class='card-text'>$bCont</p>
				  <p class='card-text'><strong>Posted Date/Time:</strong> $bDateUpload <span class='space'></span><strong>Last Modified On Date/Time:</strong> $bLastEdited</p>
				</div>
				<div class='card-footer'>
					<a href='editStudentBlog.php?blogID=".$bId."' class='btn btn-primary'>Edit Blog post</a>
					<a href='blogComment.php?blogID=".$bId."'class='btn btn-primary'>Comment</a>
					<a href='deleteStudentBlog.php?blogID=".$bId."' class='btn btn-primary'>Delete Blog post?</a><br/>
				</div>
			  </div>
			</div>
			<hr>
			<br/>
			
			
			");//end of echo

		}//end of stmt 		
	}//end if
	
	
?> 	
	
	

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
