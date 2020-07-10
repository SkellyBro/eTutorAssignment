<?php
//include security 
//session checker code, this checker is actual code instead of a require as two roles need access to this one page. 
session_start();
if($_SESSION['position']=="2" || $_SESSION['position']=="3"){
	
}else{
	Header("Location:login.php?feedback=You must be logged in to access this page...");
}//end of if-else

	//get the ID from the url 
$docID = $_GET['docID'];

//include database connection 
		include("DBConnect.php");

	$stmt = mysqli_prepare($mysqli, "DELETE * FROM documents WHERE documents.documentID = ?");
	if($stmt) {
		
		//bind parameters for markers 
		mysqli_stmt_bind_param($stmt, "i", $docID);
		
		//execute query 
		mysqli_stmt_execute($stmt);
		
		//close the statement 
		mysqli_stmt_close($stmt);
				
	}//end if
	
	//close the connection
	mysqli_close($mysqli);
	
	
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
			<?php
			
			if(isset($_SESSION)){
				$pos= $_SESSION['position'];
			}
			
			if($pos==3){
				echo"<a class='BreadEff' href='tutorDashboard.php'> Dashboard &raquo;</a>
				<a class='BreadEff' href='viewPersonalUploads.php'> Your Uploads &raquo;</a>
				<a class='BreadEff' href='deleteUpload.php'> Upload Delete</a>";
				
			}else{
				echo"<a class='BreadEff' href='studentDashboard.php'> Dashboard &raquo;</a>
				<a class='BreadEff' href='viewPersonalUploads.php'> Your Uploads &raquo;</a>
				<a class='BreadEff' href='deleteUpload.php'> Upload Delete</a>";
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
					<tr>
			<?php
				//this php is to sort the side-menu options based on user role so that a single upload file could be used by both tutor and student 
				//and the integrity of their personal side-menu options can be maintained.
				if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==3){
					echo"<td><h6><a href='tutorDashboard.php'>Dashboard</a></h6></td>";	
				}else{
					echo"<td><h6><a href='studentDashboard.php'>Dashboard</a></h6></td>";
				}
				
			?>
		</tr>
		
		<tr>
			<td><h6><a href="documentUploadArea.php">Upload Documents</a></h6></td>
		</tr>
		
		<tr>
			<?php 
				if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==3){
					echo"<td><h6><a href='viewStudentUploadList.php'>Student Uploads</a></h6></td>";	
				}else{
					echo"<td><h6><a href='viewTutorUploads.php'>View Tutor Uploads</a></h6></td>";
				}
				
			?>
		</tr>
		
		<tr>
			<td><h6><a href="viewPersonalUploads.php">Your Uploads</a></h6></td>
		</tr>
		
		<tr>
			<?php 
				if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==3){
					echo"<td><h6><a href='tutorBlog.php'>Your Blog</a></h6></td>";	
				}else{
					echo"<td><h6><a href='studentBlog.php'>Your Blog</a></h6></td>";
				}
				
			?>
		</tr>
		
		<tr>	
			<?php
			if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==3){
					echo"<td><h6><a href='messaging.php'>Messaging</a></h6></td>";	
				}else{
					echo"<td><h6><a href='viewStudentBlog.php'>View Student Blogs</a></h6></td>";
				}
			?>
		</tr>
		
		<tr>
			<?php
			if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==3){
					echo"<td><h6><a href='viewStudentBlog.php'>View Student Blog</a></h6></td>";	
				}else{
					echo"<td><h6><a href='viewTutorBlog.php'>View Tutor Blogs</a></h6></td>";
				}
			?>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
		
	<!--Page Header-->
	<div class="col-sm-10">	
	<div class="container">
	<h1>Blog Post Deletion</h1>

		<br />

			<p> Your document has been deleted. You will now be directed back to personal documents shortly. </p>

		<meta http-equiv="refresh" content="3;URL='viewPersonalUploads.php'" />
			
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
