<?php 
require('adminSessionCheck.php')
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
	<!--Main Content Container-->
    <div class="container col-lg-12">
	<meta name="viewport" content="width=device-width, initial-scale=1">


      <div class="row">
	  
         <div class="col-lg-12">
		 
		 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="authorizedUserDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="#"> Delete Tutor From Student </a>
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
			<td><h6><a href="authorizedUserDashboard.php">Dashboard</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="studentTutorStatus.php">View All Students</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="studentAllocation.php">Student Allocation</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="allocate.php">Tutor Re-Allocation</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="deleteTutorFromStudent.php">Delete Student from Tutor</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewTutorBlog.php">View Tutor Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewStudentBlog.php">View Students Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="reportMenu.php">Report Menu</a></h6></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
	
	<!--Page Header-->
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	<h1>Delete Tutor from student</h1>
	<h3><a>	
				Welcome <?php if(isset($_SESSION['position'])){
				$firstName= $_SESSION['firstName'];
				$lastName=$_SESSION['lastName'];
				echo($firstName.' '.$lastName);}?> 
	</a></h3>
	
	<h4>List of Students that has Tutors: </h4>	
	<br />
	
	
	<!--User Table-->
	<div class="container">

		
	</div>
	<br/>
	
	<?php
	//One Student is chosen from menu this code runs.
		
			//include database connection
			include("DBConnect.php");
			
			//prepare sql statement
			$stmt = mysqli_prepare ($mysqli,
			"SELECT useraccount.firstName, useraccount.lastName, useraccount.userID
			FROM useraccount
			WHERE useraccount.position=2
            AND useraccount.userID  IN (SELECT useraccount.userID FROM useraccount, assign WHERE useraccount.userID=assign.studentID)
            GROUP BY useraccount.userID");
			if ($stmt)
			{
				
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $ln, $uid);
				
				
				//create table header
				echo"<table class='table table-bordered table-striped table-hover'>
					  <tr>
						<th>Student's ID</th>
						<th>Student's First Name</th>
						<th>Student's Last Name</th>
						<th>Delete Tutor from this student </th>
					  </tr>
					  <tr>";
				
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
				{
					echo "<tr>
						<td>".$uid ."</td>
						<td>".$fn."</td>
						<td>".$ln."</td>
						<td><a href= 'deleteTutor.php?userID=".$uid."'>Delete Tutor from this student </a></th>
					</tr>";
				}
			}
		
		
		//this runs if the "reset table" button was clicked to recover the table with all records in the event of a search
			//it litterally does nothing but force the page to reload the table
			//without calling a header
			if(isset($_POST['loadAll'])){
			}//end of isset
		
	?>
	  </tr>
	</table>
	</div>
	   
      
      <!-- /.row -->

     
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
