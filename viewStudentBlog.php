<?php
//include security 
session_start();
	if($_SESSION['position']=="1" || $_SESSION['position']=="2" || $_SESSION['position']=="3"){
		
	}else{
		Header("Location:login.php?feedback=You must be logged in to access this page...");
	}//end of if-else
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
			<?php
			if($_SESSION['position']=="2"){
				echo("
				<a class='BreadEff' href='studentDashboard.php'> Dashboard &raquo; </a> 
				<a class='BreadEff' href='viewStudentBlog.php'> Student Blogs</a>
				");
			}elseif($_SESSION['position']=="3"){
				echo("
				<a class='BreadEff' href='tutorDashboard.php'> Dashboard &raquo; </a> 
				<a class='BreadEff' href='viewStudentBlog.php'> Student Blogs</a>
				");
			}else{
				echo("
				<a class='BreadEff' href='authorizedUserDashboard.php'> Dashboard &raquo; </a> 
				<a class='BreadEff' href='viewStudentBlog.php'> Student Blogs</a>
				");
			}
			
			?>
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
		<?php
		if($_SESSION['position']=="2"){
		echo("
		<tr>
			<td><h6><a href='studentDashboard.php'>Dashboard</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='documentUploadArea.php'>Upload Documents</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewTutorUploads.php'>View Tutor Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewPersonalUploads.php'>Your Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='studentBlog.php'>Your Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewStudentBlog.php'>View Student Blogs</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewTutorBlog.php'>View Tutor Blogs</a></h6></td>
		</tr>
		");
		}elseif($_SESSION['position']=="3"){
		echo("
		<tr>
			<td><h6><a href='tutorDashboard.php'>Dashboard</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='documentUploadArea.php'>Upload Documents</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewStudentUploadList.php'>Student Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewPersonalUploads.php'>Your Uploads</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='tutorBlog.php'>Your Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='messaging.php'>Messaging</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewStudentBlog.php'>View Student Blogs</a></h6></td>
		</tr>
		");

		}else{
			echo("
		<tr>
			<td><h6><a href='authorizedUserDashboard.php'>Dashboard</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='studentTutorStatus.php'>View All Students</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='studentAllocation.php'>Student Allocation</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='allocate.php'>Tutor Re-Allocation</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='deleteTutorFromStudent.php'>Delete Student from Tutor</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewTutorBlog.php'>View Tutor Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href='viewStudentBlog.php'>View Student Blog</a></h6></td>
		</tr>
		<tr>
			<td><h6><a href='reportMenu.php'>Report Menu</a></h6></td>
		</tr>		
		");
		}
		?>
	 </tbody>
	 </table>
	</div>
	</div>
		
	<!--Page Header-->
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	<h1>Student Blogposts</h1>
	<?php
	
	if($_SESSION['position']=="2"){
		echo("<p>These are all the blogposts made by your collegues, you can comment on any post you like!</p>");
	}elseif($_SESSION['position']=="3"){
		echo("<p>These are all the blogposts made by all students. Keep in mind these may not be your students!</p>");
	}else{
		echo("<p>These are all the blogposts made by students.</p>");
	}	
	?>		
	</div>

	<div class="container">
		
	
	<!--Viewing of all blogs made by the Student -->
	<?php
		//include the database connection
		include("DBConnect.php");
	//query
	$stmt = mysqli_prepare($mysqli, "SELECT blog.blogID, blog.title, blog.content, blog.uploadedBy, blog.dateUploaded, blog.dateLastEdited, useraccount.firstName, useraccount.lastName
	FROM blog, student, useraccount
	WHERE blog.uploadedBy= useraccount.userID
	AND useraccount.userID=student.userID
	ORDER BY blog.dateUploaded DESC
	");
	if($stmt) {
		
		
		
		//execute query 
		mysqli_stmt_execute($stmt);
				
		//bind the results
		mysqli_stmt_bind_result($stmt, $bId, $btitle, $bCont, $bUploader, $bDateUpload, $bLastEdited, $fName, $lName);
	echo("<hr>");
	
		//fetch the values 
		while(mysqli_stmt_fetch($stmt)) {
		echo ("<br />");
		
		//echo blog post in bootstrap card element
			echo("
			
			<div class='col-sm-11'>
			  <div class='card'>
				<div class='card-body'>
				<h4 class='card-title'>$fName $lName</h4>
				  <h4 class='card-title'>Blog Title: $btitle</h4>
				  <p class='card-text'>$bCont</p>
				  <p class='card-text'><strong>Posted Date/Time:</strong> $bDateUpload <span class='space'></span><strong>Last Modified On Date/Time:</strong> $bLastEdited</p>
				</div>
				<div class='card-footer'>
					<a href='blogComment.php?blogID=".$bId."' class='btn btn-primary'>Comment on Post</a>
				</div>
			  </div>
			</div>
			<hr>
			<br/>");		

		} 		
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
