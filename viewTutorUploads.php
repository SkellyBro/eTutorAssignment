<?php
//include call to session check for student
require('studentSessionCheck.php');

//use isset to get userid from session for query lower down file. 
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
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
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

     <div class="container col-sm-12">
	<meta name="viewport" content="width=device-width, initial-scale=1">


       <div class="row">
	  
         <div class="col-lg-12">
		 
		 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="studentDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="#">View Tutor Uploads</a>
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
		</tr> </tbody>
	 </table>
	</div>
	</div>
		
	<div class="col-sm-10">	
	<div class="container">
	<h1>Document Viewing Area</h1>
	
	<?php
	
	
	//perform query to get student name to display who the uploads belong to. 
	//make call to dbconnector
	require('DBConnect.php');
	
	$stmt= mysqli_prepare($mysqli, 
	"SELECT useraccount.userID, useraccount.firstName, useraccount.lastName
	FROM useraccount, assign
	WHERE useraccount.userID=assign.tutorID
	AND assign.studentID=?");
	if($stmt){
		//bind variables
		mysqli_stmt_bind_param($stmt, "i", $uID);
		
		//execute query
		mysqli_stmt_execute($stmt);
		
		//bind the results
		mysqli_stmt_bind_result($stmt, $tID, $fn, $ln);
		
		//get results
		if (mysqli_stmt_fetch($stmt))
			{
				echo("<h4>These are all the uploads made by your tutor; $fn $ln</h4>");
			}else{
				return false;
			}//end of mysqli_stmt_fetch
	}//end of stmt
	
	//perform query to pull all the uploads made by the student
	//make call to db connecter
	require('DBConnect.php');
	//create query to display all documents uploaded by student
	$stmt = mysqli_prepare ($mysqli, 
		"SELECT documents.documentID, documents.documentTitle, documents.documentDescription, documents.documentName, documents.uploadDate
		FROM documents, assign, useraccount
		WHERE useraccount.userID=assign.tutorID
		AND assign.tutorID=documents.uploadedBy
		AND assign.studentID=?");
			if ($stmt)
				{
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);	
					
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $docID, $docTitle, $docDesc, $docName, $docDate);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
				{	
					//start of while echo, this echo takes all pulled database variables and populates it into a bootstrap "card" class
					echo"
						<div class='col-sm-11'>
						  <div class='card'>
							<div class='card-body'>
							  <h4 class='card-title'>Document Title: $docTitle</h4>
							  <p class='card-text'>Document Description: $docDesc</p>
							  <p class='card-text'>Upload Date: $docDate</p>
							</div>
							<div class='card-footer'>
							  <a href='uploads/$docName' class='btn btn-primary'>Download File</a>
							  <a href='documentComment.php' class='btn btn-primary'>Comment</a>
							  ";if(isset($_SESSION)){$_SESSION['docID']=$docID;}echo"
							</div>
						  </div>
						</div>
						<br/>
					";//end of echo
				}//end of while 	
					}else{
						echo("<h5>Student has made no uploads.</h5>");
					}
				}//end of stmt	
	
	?>
	
      
    <!-- /.row -->

	</div><!--Table Container end-->
    </div><!--Row End-->
	</div><!--Main Container End-->
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
