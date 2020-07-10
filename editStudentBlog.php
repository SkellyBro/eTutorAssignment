<?php
//include security 
require('studentSessionCheck.php');

//get the id from session 
$uploadedBy = $_SESSION["uID"];
	//get the ID from the url 
$blogID = $_GET ['blogID'];
//create error holders
$error="";
$feedback="";
$count=0;

		//include the database connection
		include("DBConnect.php");
	
	//write a query to retrieve the blog details 
	//set up value holders 
	$value1 = "";
	$value2 = "";

	$stmt = mysqli_prepare($mysqli, "SELECT blog.blogID, blog.title, blog.content, blog.uploadedBy, blog.dateUploaded FROM blog WHERE blog.blogID = ?");
	if($stmt) {
		
		//bind parameters for markers 
		mysqli_stmt_bind_param($stmt, "i", $blogID);
		
		//execute query 
		mysqli_stmt_execute($stmt);
		
		//bind the results
		mysqli_stmt_bind_result($stmt, $bId, $btitle, $bCont, $bUploader, $bDateUpload);
		
		//fetch the values 
		if(mysqli_stmt_fetch($stmt)) {
			
	$value1 = $btitle;
	$value2 = $bCont;
					
		}//end fetch values
			
	}//end if

	//determine if the submit button was pressed 
if(isset($_POST["submitEdit"])){
	$title = $_POST["title"];
	$content = $_POST["content"];

	
	//do validation 
		
		if($title == "" || $title == null ) {
		$error.="<br/>You must enter a title for your Blog post";
		$count++;
	}//end name validation 	
		
			if($content == "" || $content == null ) {
		$error.="<br/>You must enter some content for your Blog post";
		$count++;
	}//end generalDescription validation
		
	
	if($count == 0) {
		//capitalise
		$title = ucfirst($title);
		
		//sanitise
		$title = filter_var($title, FILTER_SANITIZE_STRING);
		$content = filter_var($content, FILTER_SANITIZE_STRING);
		
	//include the database connection
		include("DBConnect.php");
						
		//do blog update
		if ($stmt = mysqli_prepare($mysqli, "UPDATE blog SET title = ?, content = ?, dateLastEdited=NOW() WHERE blogID = ?"))
		{
			//bind parameters for markers
			mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $blogID);
			
			//execute query 
			if(mysqli_stmt_execute($stmt)){
				$feedback.= "<br/>Your blog post has been updated Successfully!";
			
			}else{
				$error.= "<br/>Blog post has not been updated successfully. Please contact a technician.";
				$count++;
			}	
			//close statement
			mysqli_stmt_close($stmt);				
		}//end of stmt
	
				//close connection
			mysqli_close($mysqli);
			echo("<br />");

		
	}//end errorCount

}//end submit

if(isset($_POST['return'])){
	Header("Location:studentBlog.php");
}//end of isset
	


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
			<a class="BreadEff" href="studentBlog.php"> Blogs &raquo;</a> 
			<a class="BreadEff" href="editStudentBlog.php"> Blog Edit</a> 
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
	<h1> Blogs</h1>
	
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

		<!--Student Blog post Form-->
		<form class="horizontal" method="post" action="editStudentBlog.php?blogID=<?php echo($blogID); ?>">
		<input type="hidden" name="blogID" value="<?php echo($blogID); ?>" />
		<div class="form-group">
			<label class="control-label">Edit your Blog post below:</label> </br>

			<input type="text" class="form-control" name="title" value="<?php echo($value1); ?>" placeholder="Blog Title"/>
			
			</br>
			
			<textarea class="form-control" name="content" value="" placeholder="Enter your text here.."><?php echo($value2);?></textarea>

			<input type="submit" class="btn btn-sm btn-primary form-control" name="submitEdit" value="Edit"/>
		 </div>
			<input type="submit" class="btn btn-sm btn-primary form-control" name="return" value="Return to Blog"/>
		</form>
		
		
		<!--End of student edit Blog post Form-->
		<br/>
			
		
			
	</div>

	<br/>
	<div class="container">
		
		
		
		
		
		
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
