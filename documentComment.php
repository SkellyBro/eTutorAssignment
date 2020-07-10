<?php
//session checker code, this checker is actual code instead of a require as two roles need access to this one page. 
session_start();
	if($_SESSION['position']=="2" || $_SESSION['position']=="3"){
		
	}else{
		Header("Location:login.php?feedback=You must be logged in to access this page...");
	}//end of if-else
		
	$feedback="";
	$error="";
	$count=0;
	
	//get documentID
	$docID=$_SESSION['docID'];

	if(isset($_POST['submit'])){
		//get comment made by user
		$comment=$_POST['docComment'];
		
		//get userID
		$uID=$_SESSION['uID'];

		

		//validate comment
		validateData($comment);
		
		//santize comment
		sanitizeData($comment);
		
		if($count==0){
		
		//make insert into database
		//require DBConnect
		require('DBConnect.php');
		
		if ($stmt = mysqli_prepare($mysqli,
			"INSERT INTO comments(commentDetails, madeBy, documentID)
			VALUES(?, ?, ?)")){
			
				//Bind parameters to SQL Statement Object
				mysqli_stmt_bind_param($stmt, "sii", $comment, $uID, $docID);
				
				//Execute statement object and check if successful
				if(mysqli_stmt_execute($stmt)){
					$feedback.= "<br/>Comment made Successfully!";
				
				}else{
					$error.= "<br/>Comment made Unsuccessfully. Please contact a technician.";
					$count++;
				}//end of feedback if else 
			
			}//end mysqli prepare statement
		
		}//end of isset
	}//end of if-check
	function validateData($comment){
		global $error;
		global $count;
		
		if($comment=="" || $comment==null){
			$count++;
			$error.="<br/ >You must include a description for the uploaded document";
		}
		
		if(strlen($comment)>300){
			$count++;
			$error.="<br/>Your description cannot be more than 200 characters";
		}
	}//end of validateData
	
	function sanitizeData($val){
		$val= filter_var($val, FILTER_SANITIZE_STRING);
		
			//include db connector code
			include('DBConnect.php');
			
			//sanitize data going into MySQL
			$val= mysqli_real_escape_string($mysqli, $val);
			
			return $val;
	}//end of sanitizeData

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
			
			<?php
			
			if(isset($_SESSION)){
				$pos= $_SESSION['position'];
			}
			
			if($pos==3){
				echo"<a class='BreadEff' href='tutorDashboard.php'> Dashboard &raquo;</a>
				<a class='BreadEff' href='#'> Document Upload Area</a>";
				
			}else{
				echo"<a class='BreadEff' href='studentDashboard.php'> Dashboard &raquo;</a>
				<a class='BreadEff' href='#'> Document Upload Area</a>";
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
					echo"<td><h6><a href='messaging.php'>Messaging</a></h6></td>";	
				}else{
					echo"<td><h6><a href='studentMessaging.php'>Messaging</a></h6></td>";
				}
				
			?>
		</tr>
		
		<tr>
			<?php 
				if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==3){
					echo"<td><h6><a href='tutorBlog.php'>Your Blog</a></h6></td>";	
				}else{
					echo"<td><h6><a href='meeting.php'>Meeting Arrangement</a></h6></td>";
				}
				
			?>
		</tr>
		
		<tr>
			<?php 
				if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==3){
					echo"<td><h6><a href='viewStudentBlog.php'>View Student Blogs</a></h6></td>";	
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
				
				if($pos==2){
					echo"<td><h6><a href='viewStudentBlog.php'>View Student Blogs</a></h6></td>";
				}
				
			?>
		</tr>
		<tr>
			<?php 
				if(isset($_SESSION)){
					$pos=$_SESSION['position'];
				}
				
				if($pos==2){
					echo"<td><h6><a href='viewTutorBlog.php'>View Tutor Blogs</a></h6></td>";
				}
				
			?>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
		
	<div class="col-sm-10">	
	<div class="container">
	
	 <h1>Document Commenting</h1>
	  <p>This is the commenting area for uploaded documents. You can see all previous comments or make your own.</p>
	  
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
			
			require('DBConnect.php');
			//make sql statement to pull all comments for the current document
			
			$stmt=mysqli_prepare($mysqli, 
			"SELECT documents.documentID, comments.commentDetails, comments.commentDate, useraccount.firstName, useraccount.lastName
			FROM documents, comments, useraccount
			WHERE documents.documentID=comments.documentID
			AND comments.madeBy= useraccount.userID
			AND documents.documentID=?");
			if ($stmt)
				{
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $docID);	
					
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $dID, $comment, $commentDate, $fName, $lName);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				echo("<h5>All Comments:</h5>");
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
				{	
					//start of while echo, this echo takes all pulled database variables and populates it into a bootstrap "card" class
					echo"
						<div class='col-sm-12'>
						  <div class='card'>
							<div class='card-body'>
							  <h4 class='card-title'>$fName $lName</h4>
							  <p class='card-text'>Comment Date: $commentDate</p>
							  <p class='card-text'>$comment</p>
							</div>
						  </div>
						</div>
					";//end of echo
				}//end of while 	
					}else{
						echo("<h5>No Comments have been made on this document.</h5><br/>");
					}
				}//end of stmt	

			
		
	 ?>
		<br/>
		<!--HTML Goes Here-->
		<form class="form-horizontal" method="post" action="documentComment.php">
		
			<!--
			Code Adapted from: https://mdbootstrap.com/components/bootstrap-textarea/
			Code Author: mdbootstrap.com
			Code Accessed On: 11/10/2018
			-->
			<div class="form-group green-border-focus">
				<textarea class="form-control" name="docComment"  rows="3" placeholder="Please do not post inapproprate comments on the uploader's document. Write your comment here.."></textarea>
				</br>
				<input type="submit" class="btn btn-primary form-control" name="submit"/>
			</div>
		
		</form>
		
	</div>
      
      <!-- /.row -->

	</div><!--Table Container end-->
    </div><!--Row End-->
	</div><!--Main Container End-->
      <!-- /.row -->
	
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
