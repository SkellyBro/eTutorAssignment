<?php
//include security 
require('tutorSessionCheck.php');

//get the id from session 
$uploadedBy = $_SESSION["uID"];
	//get the ID from the url 
$blogID = $_GET ['blogID'];


		//include the database connection
		include("DBConnect.php");

				$stmt = mysqli_prepare($mysqli, "DELETE * FROM Blog WHERE Blog.blogID = ?");
			
		if($stmt)
			{
			//bind parameters for markers
			mysqli_stmt_bind_param($stmt,"i",$blogID);
				
			//execute query
			mysqli_stmt_execute($stmt);
				
				
			//close the statement
			mysqli_stmt_close($stmt);
		
		}
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
	
			<style> 
	input[type=text] {
    width:390px;
}

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
			<a class="BreadEff" href="tutorDashboard.php"> Dashboard</a> >
			<a class="BreadEff" href="blogTutor.php"> Blogs</a>
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
			<td><a href="blogTutor.php">Blogs</a></td>
		</tr>
		
		<tr>
			<td><a href="#">Lorum Ipsum</a></td>
		</tr>
		
		<tr>
			<td><a href="#">Lorum Ipsum</a></td>
		</tr>
		
		<tr>
			<td><a href="#">Lorum Ipsum</a></td>
		</tr>
		
		<tr>
			<td><a href="#">Lorum Ipsum</a></td>
		</tr>
		
		<tr>
			<td><a href="#">Lorum Ipsum</a></td>
		</tr>
		
		<tr>
			<td><a href="#">Lorum Ipsum</a></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
	
		<!--Page Header-->
	<div class="col-sm-10">	
	<div class="container">
	<h1> Blogs</h1>

	
		<br />
		
	<h1> Delete Blog</h1>

	
		<br />

		 <p>
			The Blog details have been deleted. You will be directed to the Blog page.
			</p>
			
			<meta http-equiv="refresh" content= "5;URL='blogTutor.php'"/>
			<!--End of Tutor edit Blog post Form-->
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
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	