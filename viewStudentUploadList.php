<?php
//session checker code, this checker is actual code instead of a require as two roles need access to this one page. 
require('tutorSessionCheck.php');

if(isset($_SESSION)){
	$uID=$_SESSION['uID'];
	$firstName=$_SESSION['firstName'];
	$lastName=$_SESSION['lastName'];
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
			<a class="BreadEff" href="tutorDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="#.php">Student Upload List</a>
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
			<td><h6><a href="viewStudentBlog.php">View Student Blogs</a></h6></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
		
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	<h1>Student Upload List</h1>
	<?php echo"<p>Hi $firstName $lastName these are all of your students, click on a student to view a list of all their uploads.</p>"?>
	<br/>
	<!--This is where you should do your php-->
	
	<?php
	
	require('DBConnect.php');
		
	//prepare sql statement
			$stmt = mysqli_prepare ($mysqli, 
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID, useraccount.gender, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
			IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
			FROM useraccount, assign
			WHERE useraccount.position=2
			AND useraccount.userID = assign.studentID
			AND assign.tutorID=?
			ORDER BY useraccount.userID");
			if ($stmt)
				{
				//bind variables
				mysqli_stmt_bind_param($stmt, "i", $uID);	
					
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $ln, $sID, $gender, $age);
				
				//store result to check resultSet
				mysqli_stmt_store_result($stmt);
				
				//store number of rows in variable
				$resultSet= mysqli_stmt_num_rows($stmt);
				
				//check if resultset is 1 or higher so table could be displayed
				if($resultSet>=1){
				
				echo "<h5>Click on a student to view their uploads:</h5>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Student ID</th>
							<th>Student First Name</th>
							<th>Student Last Name</th>
							<th>Student Gender</th>
							<th>Student Age</th>
							<th>View Student Uploads</th>
						  </tr>
						  <tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
						{
							echo "<tr>
								<td>".$sID."</td>
								<td>".$fn."</td>
								<td>".$ln."</td>
								<td>".$gender."</td>
								<td>".$age."</td>
								<td><a href= 'viewUploadedDocuments.php?studentID=".$sID."'>View Uploads</a></td>
							</tr>";
						}//end of while 	
					}else{
						echo("<h5>No students have been assigned to you as yet. Please contact the system admin for assistance if necessary.</h5>");
					}
				}//end of stmt	
	
	?>
	</table>
	
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
