<?php
require('studentSessionCheck.php');

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
			<a class="BreadEff" href="studentMessaging.php"> Message Menu &raquo;</a>
			<a class="BreadEff" href="viewStudentMessagesReceived.php"> Messages Received</a>
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
	<div class="col-sm-10 table-responsive">	
	<div class="container">
	<h1> Messaging </h1>
	<br /> 
	
	<h4>List of Messages Received</h4>
			
	
	<table class='table table-bordered table-striped table-hover'>
		<tr> 
			<th>Message ID </th>
			<th>Message Sender</th>
			<th>Message Title </th>
			<th>Message Content </th>
			<th>Reply</th>
		</tr>
		
		
		<tr>
			<?php
				//include database connection
				include("DBConnect.php");
				
				$stmt = mysqli_prepare($mysqli, "SELECT messageID, sender, messageTitle, contentDetails FROM message WHERE message.recipient = ?");
				if($stmt)
				{
					//bind parameters for makers
					mysqli_stmt_bind_param($stmt,"i", $uID);
					
					//execute query 
					mysqli_stmt_execute($stmt);
					
					//bind the results
					mysqli_stmt_bind_result($stmt, $mID, $s, $mTitle, $cD);
					
					//fetch the values
					while(mysqli_stmt_fetch($stmt))
					{
						echo "<tr> 
							<td>".$mID."</td>
							<td>".$s."</td>
							<td>".$mTitle."</td>
							<td>".$cD."</td>
							<td><a href= 'createStudentReply.php?messageID=".$mID."'>Reply To Message</a></td>
							</tr>";
					}
				}
			?>
		</tr>
	</table>
	</div>
	<br/>
	   
      
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
