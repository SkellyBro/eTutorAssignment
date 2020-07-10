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
   <!-- Page Content -->
	<!--Main Content Container-->
    <div class="container col-lg-12">
	<meta name="viewport" content="width=device-width, initial-scale=1">


      <div class="row">
	  
         <div class="col-lg-12">
		 
		 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="authorizedUserDashboard.php"> Dashboard &raquo;</a>
			<a class="BreadEff" href="#.php">View All Students</a>
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
	<div class="col-sm-10">	
	<div class="container">

	<h1>List of Students With Tutors/Without Tutors: </h1>	
	<p>Use the select box to see students with tutors or students without tutors</p>
	<br />
	
	
	<!--Student List Selection-->
	<div class="container">
		
	<!--Select Box-->
	<form class="horizontal" method="post" action="studentTutorStatus.php">
		<select class="form-control" name="option">
			<option value="">---Choose what you would like to view---</option>
			<option value="1">View Students With Tutors</option>
			<option value="2">View Students Without Tutors</option>
		</select>
		<input type="submit" class="btn btn-sm btn-primary btn-block" name="submit"/>
		
	
	</form>
	
	<br/>
		
	</div>
	<br/>
	
	<?php

	//runs query for showing students that are assigned to a tutor from the assign table
		if(isset($_POST['submit'])){
				//get post variable
				$option=$_POST['option'];
				//include database connection
				
				if($option==1){
				include("DBConnect.php");
				
				//prepare sql statement
				$stmt = mysqli_prepare ($mysqli, 
				"SELECT assign.studentID, useraccount.firstName, useraccount.lastname FROM assign, useraccount WHERE useraccount.userID=assign.studentID");
				if ($stmt)
				{
					//execute query 
					mysqli_stmt_execute ($stmt);
					
					//bind the results
					mysqli_stmt_bind_result ($stmt, $uid, $fn, $ln);
					
					
					//create table header
					echo"<h4>This is a list of all students who have been allocated to tutors</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Student ID</th>
							<th>Student First Name</th>
							<th>Student Last Name</th>
						  </tr>
						  <tr>";
					
					//fetch the values
					while(mysqli_stmt_fetch($stmt))
					{
						echo "<tr>
							<td>".$uid ."</td>
							<td>".$fn."</td>
							<td>".$ln."</td>
						</tr>";
					}
				}
			} else{
			//include database connection
				include("DBConnect.php");
				
				//runs query for showing students that do not have a tutor 
				//prepare sql statement
				$stmt = mysqli_prepare ($mysqli, 
				"SELECT useraccount.userID, useraccount.firstName, useraccount.lastName FROM useraccount WHERE useraccount.position=2 AND useraccount.userID NOT IN (SELECT useraccount.userID FROM useraccount, assign WHERE useraccount.userID=assign.studentID) GROUP BY useraccount.userID");
				if ($stmt)
				{
					
					//execute query 
					mysqli_stmt_execute ($stmt);
					
					//bind the results
					mysqli_stmt_bind_result ($stmt, $uid, $fn, $ln);
					
					//create table header
					echo"<h4>This is a list of all students who have not been allocated to a tutor</h4>
						<table class='table table-bordered table-striped table-hover'>
						  <tr>
							<th>Student/Tutor ID</th>
							<th>Student/Tutor First Name</th>
							<th>Student/Tutor Last Name</th>
						  </tr>
						  <tr>";
					//fetch the values
					while(mysqli_stmt_fetch($stmt))
					{
						echo "
						<tr>
							<td>".$uid ."</td>
							<td>".$fn."</td>
							<td>".$ln."</td>
						</tr>";
					}//end of while
				}//end of stmt if
			}//end of if-else
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
