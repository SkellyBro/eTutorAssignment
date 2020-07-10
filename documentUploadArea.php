<?php
//session checker code, this checker is actual code instead of a require as two roles need access to this one page. 
session_start();
	if($_SESSION['position']=="2" || $_SESSION['position']=="3"){
		
	}else{
		Header("Location:login.php?feedback=You must be logged in to access this page...");
	}//end of if-else
	
	//variable declaration
	$rand=rand(1, 10000000);
	$fileName="";
	$uploadedFile="";
	$feedback="";
	$error="";
	$count=0;
	$date=date("Y-m-d");
	
	//start of isset to get non-file form elements	
	if(isset($_POST['submit'])){
		$docTitle=$_POST['docTitle'];
		$docDesc=$_POST['docDesc'];
		
		//call to validation method
		validateData($docTitle, $docDesc);
		
		//call to sanitize method
		sanitizeData($docTitle);
		sanitizeData($docDesc);
		
		//get userID for db insert
		if(isset($_SESSION)){
			$uID=$_SESSION['uID'];
		}
		
		//check to ensure that if errors in validation occured the database insert would not run
		if($count==0){
			saveDocument($docTitle, $docDesc, $date, $uID);
		}
	}//end of isset	
	//Start of Function Dump
	

	//start of sanitize function to filter out non-text elements
	function sanitizeData($val){
		$val= filter_var($val, FILTER_SANITIZE_STRING);
		
			//include php code
			include('DBConnect.php');
			
			//sanitize data going into MySQL
			$val= mysqli_real_escape_string($mysqli, $val);
			
			return $val;
	}//end of sanitizeData
	
	function saveDocument($dT, $dD, $date, $uID){
		global $feedback;
		global $count;
		global $uploadedFile;
		global $fileName;
		global $rand;
		
		//work with the file upload first
		if((($_FILES['fileUpload']['type']== 'image/jpg')||
		($_FILES['fileUpload']['type']== 'image/jpeg')||
		($_FILES['fileUpload']['type']== 'image/pjpeg')||
		($_FILES['fileUpload']['type']== 'image/bmp')||
		($_FILES['fileUpload']['type']== 'image/png'))||
		($_FILES['fileUpload']['type']== 'application/pdf')||
		($_FILES['fileUpload']['type']== 'application/doc')
		&&
		($_FILES['fileUpload']['size']<1000000))
		{
			$uploadedFile = $_FILES['fileUpload']['name']."(".$_FILES['fileUpload']['type'].",".ceil($_FILES['fileUpload']['size']/1024).")Kb"."<br />";
		}
			move_uploaded_file($_FILES['fileUpload']['tmp_name'],'uploads/'.$rand.$_FILES['fileUpload']['name']);

		$fileName= $rand.$_FILES['fileUpload']['name'];
		
		require('DBConnect.php');
		
		//store filename in database
		if ($stmt = mysqli_prepare($mysqli,
			"INSERT INTO documents(documentTitle, documentDescription, documentName, uploadDate, uploadedBy)
			VALUES(?, ?, ?, ?, ?)")){
			
			//Bind parameters to SQL Statement Object
			mysqli_stmt_bind_param($stmt, "ssssi", $dT, $dD, $fileName, $date, $uID);
			
			//Execute statement object and check if successful
			if(mysqli_stmt_execute($stmt)){
				$feedback.= "<br/>Document uploaded Successfully!";
			
			}else{
				$error.= "<br/>Document uploaded Unsuccessfully. Please contact a technician.";
				$count++;
			}//end of feedback if else 
			
		}//end mysqli prepare statement
	}//end of saveDocument
	
	//function to validate non-file form elements
	function validateData($dT, $dD){
		global $feedback;
		global $error;
		global $count;
		
		$count=0;
		
		//document title validation
		if($dT=="" || $dT==null){
			$count++;
			$error.="<br/> You must include a title for the uploaded document.";
		}
		
		if(strlen($dT)>=50){
			$count++;
			$error.="<br/>Document title cannot be more than 50 characters";
		}
		
		//document description validation
		if($dD=="" || $dD==null){
			$count++;
			$error.="<br/ >You must include a description for the uploaded document";
		}
		
		if(strlen($dD)>200){
			$count++;
			$error.="<br/>Your description cannot be more than 200 characters";
		}
		
		//uploaded file validation
		//code adapted from:https://www.w3schools.com/php/php_file_upload.asp
		//accessed on: 26/11/2017
		$allowed =  array('docx', 'doc', 'pdf', 'jpeg', 'png', 'jpg', 'bmp', 'pjpeg', 'JPEG', 'PNG', 'JPG', 'BMP', 'PJPEG', 'PDF', 'DOCX', 'PPTX');
		
		$path = $_FILES['fileUpload']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed)){
				$error.="<br/> Document uploaded is not of type: .jpg, .jpeg, .bmp, .pjpeg, .png, .pdf, .doc or .docx";
				$count++;
		}//end of if
		
	}//end of function validateData
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
		
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	
	 <h1>Document Upload Area</h1>
	  <p>Please note that when uploading files ensure that files are less than 10MB and that files are of the type; .pdf, .docx, .pptx, .png, .jpeg and .jpg</p>
	  
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
	  
		  <form class="form-horizontal" method="post" action="documentUploadArea.php" enctype="multipart/form-data">
			<div class="form-group"> 
				<label class="control-label">Document Title:</label>
				<input type="text" class="form-control" name="docTitle" aria-labelledby="document title"/> 
			</div>
			
			<!--
			Code Adapted from: https://mdbootstrap.com/components/bootstrap-textarea/
			Code Author: mdbootstrap.com
			Code Accessed On: 11/10/2018
			-->
			<div class="form-group green-border-focus">
				<label for="exampleFormControlTextarea5">Document Description</label>
				<textarea class="form-control" name="docDesc"  rows="3"></textarea>
			</div>
			
			<div class="form-group"> 
				<label class="control-label">Select Document to Upload:</label>
				<!--Code Adapted from:http://www.javascripthive.info/php/php-multiple-files-upload-validation/-->
				<!--Accessed on: 26/11/2017-->
				<input type="file" class="form-control" name="fileUpload" aria-labelledby="Select the images you want to upload"/> 
			</div>

			 <input type="submit" class="btn btn-primary form-control" name="submit"/>
			
		  </form>	
		<br/>
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
