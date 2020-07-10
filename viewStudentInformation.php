<?php 
session_start();
if($_SESSION['position']=="1" || $_SESSION['position']=="3"){
		
	}else{
		Header("Location:login.php?feedback=You must be logged in to access this page...");
	}//end of if-else

$feedback="";
$count=0;
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>eTutor</title>
	
	<script src="bootstrap/jquery/jquery.min.js"></script>
	
	<!--Link Javascript-->
    <script type="text/javascript" src="authorizedUserAJAX.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
	
	<!--JavaScript for Graph-->
	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  </head>

  <body>

    <!-- Navigation -->
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
			<a class="BreadEff" href="tutorDashboard.php">Dashboard &raquo;</a>
			<a class="BreadEff" href="#.php">User View</a>
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
			<td><h6><a href="messaging.php">Messaging</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="tutorBlog.php">Your Blog</a></h6></td>
		</tr>
		
		<tr>
			<td><h6><a href="viewStudentBlog.php">View Student Blogs</a></h6></td>
		</tr>
	 </tbody>
	 </table>
	</div>
	</div>
	
	<!--Page Header-->
	<div class="col-sm-10">	
	<div class="container table-responsive">
	<h1>Student Information</h1>
	
	
	<h4>Selected user information: </h4>	
	<br />
	
	<?php
		
		$uID=$_GET['userID'];
		
		if(isset($_SESSION)){
			//$uID=$_SESSION['viewID'];
		}
		
		//perform database query
		//initialize variables to be used
		$age=0;
		$address="";
		$email="";
		$fn="";
		$ln="";
		$pos=0;
		
		include('DBConnect.php');
		
		$stmt= mysqli_prepare($mysqli, 
		"SELECT useraccount.firstName, position.positionName, useraccount.lastName, useraccount.email, useraccount.address, YEAR(CURDATE()) - YEAR(useraccount.dateOfBirth) - 
		IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(useraccount.dateOfBirth), '-', DAY(useraccount.dateOfBirth)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
		FROM useraccount, position
		WHERE useraccount.userID=?
		AND useraccount.position= position.positionId");
		if($stmt){
			//bind entered parameters to mysqli statement
				mysqli_stmt_bind_param($stmt, "s", $uID);
				
				//execute query 
				mysqli_stmt_execute ($stmt);
				
				//bind the results
				mysqli_stmt_bind_result ($stmt, $fn, $pos, $ln, $email, $address, $age);
				
				//create table header
				echo"<table class='table table-bordered table-striped table-hover'>
					  <tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Age</th>
						<th>Address</th>
						<th>Email</th>
						<th>Role</th>
					  </tr>
					  <tr>";
				//fetch the values
				while(mysqli_stmt_fetch($stmt))
				{
					echo "
					<tr>
						<td>".$uID ."</td>
						<td>".$fn."</td>
						<td>".$ln."</td>
						<td>".$age."</td>
						<td>".$address."</td>
						<td>".$email."</td>
						<td>".$pos."</td>
					</tr>
					</table>";
				}//end of while
				
		}//end of stmt if
		
		echo("</div>");
		
		//create arrays to house data for the selected user sent messages chart
		//this array is for the dataTable row used for the messages chart
		$rows = array();
		//this array is the entire dataTable
		$table = array();
		//this identifies the "columns" of the dataTable
		$table['cols'] = array( 
		//table titles
		array('label' => 'Status', 'type' => 'string'),
		array('label' => 'Amount', 'type' => 'number')
		);
		
		//do query to get informaiton for chart
		/*Code adapted from: http://www.mustbebuilt.co.uk/php/using-object-oriented-php-with-the-mysqli-extension/
		Code used on: 27/10/2018
		Code Author: mustbebuilt.co.uk*/
		include("DBConnect.php");
		$stmt=$mysqli->prepare('SELECT COUNT(message.messageID) AS messageCount
		FROM message
		WHERE message.sender=?
		AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()');
		$stmt->bind_param('i', $uID);
		$stmt->execute();
		$stmt->bind_result($mC);
		while($stmt->fetch()){
			
			 //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the names of the tutors on the chart
			  $temp[] = array('v' => (string) "Messages Sent"); 

			  // Values of the each bar of the chart
			  $temp[] = array('v' => (int) $mC); 
			  
			  //store values from $temp into $rows
			    //store values from $temp into $rows
			  $rows[] = array('c' => $temp);
			
		}//end of while
		
		//combine data from $rows into $table
		$table['rows'] = $rows;
		
		//do query to get informaiton for chart
		/*Code adapted from: http://www.mustbebuilt.co.uk/php/using-object-oriented-php-with-the-mysqli-extension/
		Code used on: 27/10/2018
		Code Author: mustbebuilt.co.uk*/
		include("DBConnect.php");
		$stmt2=$mysqli->prepare('SELECT COUNT(message.messageID) AS messageCount
		FROM message
		WHERE message.recipient=?
		AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()');
		$stmt2->bind_param('i', $uID);
		$stmt2->execute();
		$stmt2->bind_result($mC);
		while($stmt2->fetch()){
			
			 //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the names of the tutors on the chart
			  $temp[] = array('v' => (string) "Messages Received"); 

			  // Values of the each bar of the chart
			  $temp[] = array('v' => (int) $mC); 
			  
			  //store values from $temp into $rows
			    //store values from $temp into $rows
			  $rows[] = array('c' => $temp);
			
		}//end of while
			
			//combine data from $rows into $table
			$table['rows'] = $rows;

			// convert data into JSON format so it can be accessed via JS
			$jsonTable = json_encode($table);
			//echo $jsonTable;
		?>
		
		<!--Start JS Script to display the Chart-->
		<script type="text/javascript">

			 // Load the Visualization API and the corechart package.
				google.charts.load('current', {'packages':['corechart']});

			  // Set a callback to run when the Google Visualization API is loaded.
				google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
			  // Create our data table out of JSON data loaded from server.
			  var data = new google.visualization.DataTable(<?=$jsonTable?>);
			  var options = {
				  is3D: 'true',
				  width: 1100,
				  height: 300
				};
			  // Instantiate and draw our chart, passing in some options.
			  // Do not forget to check your div ID
			  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
			  chart.draw(data, options);
			}
		</script>
		
		<br/>
		<h4>Messages Sent/Received by <?php echo("$fn".' '."$ln");?> in the last 7 days</h4>
		<div id="chart_div">
		
		</div>
		
		<?php
		
				
			//create arrays to house data for the messages chart
			//this array is for the dataTable row used for the messages chart
			$rows2 = array();
			//this array is the entire dataTable
			$table2 = array();
			//this identifies the "columns" of the dataTable
			$table2['cols'] = array( 
			//table titles
			array('label' => 'Status', 'type' => 'string'),
			array('label' => 'Amount', 'type' => 'number')
		);
		
			//do query to get informaiton for chart
			/*Code adapted from: http://www.mustbebuilt.co.uk/php/using-object-oriented-php-with-the-mysqli-extension/
			Code used on: 27/10/2018
			Code Author: mustbebuilt.co.uk*/
			include("DBConnect.php");
			$stmt=$mysqli->prepare('SELECT COUNT(reply.replyID) AS replyCount
			FROM reply
			WHERE reply.recipient=?
			AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY reply.messageDate');
			$stmt->bind_param('i', $uID);
			$stmt->execute();
			$stmt->bind_result($rC);
			while($stmt->fetch()){
			
			 //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the names of the tutors on the chart
			  $temp[] = array('v' => (string) "Replies Received"); 

			  // Values of the each bar of the chart
			  $temp[] = array('v' => (int) $rC); 
			  
			  //store values from $temp into $rows
			    //store values from $temp into $rows
			  $rows[] = array('c' => $temp);
			
		}//end of while
		
		//combine data from $rows into $table
			$table2['rows'] = $rows;
		
		//do query to get informaiton for chart
		/*Code adapted from: http://www.mustbebuilt.co.uk/php/using-object-oriented-php-with-the-mysqli-extension/
		Code used on: 27/10/2018
		Code Author: mustbebuilt.co.uk*/
			include("DBConnect.php");
			$stmt=$mysqli->prepare('SELECT COUNT(reply.replyID) AS replyCount
			FROM reply
			WHERE reply.sender=?
			AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY reply.messageDate');
			$stmt->bind_param('i', $uID);
			$stmt->execute();
			$stmt->bind_result($rC);
			while($stmt->fetch()){
			
			 //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the names of the tutors on the chart
			  $temp[] = array('v' => (string) "Replies Sent"); 

			  // Values of the each bar of the chart
			  $temp[] = array('v' => (int) $rC); 
			  
			  //store values from $temp into $rows
			    //store values from $temp into $rows
			  $rows2[] = array('c' => $temp);
			
		}//end of while
		
		//combine data from $rows into $table
			$table2['rows'] = $rows2;

			// convert data into JSON format so it can be accessed via JS
			$jsonTable2 = json_encode($table2);
			//echo $jsonTable;
		
		?>
		
		<!--Start JS Script to display the Chart-->
		<script type="text/javascript">

			 // Load the Visualization API and the corechart package.
				google.charts.load('current', {'packages':['corechart']});

			  // Set a callback to run when the Google Visualization API is loaded.
				google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
			  // Create our data table out of JSON data loaded from server.
			  var data = new google.visualization.DataTable(<?=$jsonTable2?>);
			  var options = {
				  is3D: 'true',
				  width: 1100,
				  height: 300
				};
			  // Instantiate and draw our chart, passing in some options.
			  // Do not forget to check your div ID
			  var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
			  chart.draw(data, options);
			}
		</script>
		
		<h4>Number of Replies Sent/Received by <?php echo("$fn".' '."$ln");?> in the last 7 days</h4>
		<div id="chart_div2">
		
		</div>
		
		<?php
		
			//create arrays to house data for the messages chart
			//this array is for the dataTable row used for the messages chart
			$rows3 = array();
			//this array is the entire dataTable
			$table3 = array();
			//this identifies the "columns" of the dataTable
			$table3['cols'] = array( 
			//table titles
			array('label' => 'Uploads', 'type' => 'string'),
			array('label' => 'Upload Amount', 'type' => 'number')
		);
		
			//do query to get informaiton for chart
			/*Code adapted from: http://www.mustbebuilt.co.uk/php/using-object-oriented-php-with-the-mysqli-extension/
			Code used on: 27/10/2018
			Code Author: mustbebuilt.co.uk*/
			include("DBConnect.php");
			$stmt=$mysqli->prepare('SELECT COUNT(documents.documentID) AS docCount, documents.uploadDate
			FROM documents
			WHERE documents.uploadedBy= ?
			AND documents.uploadDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()');
			$stmt->bind_param('i', $uID);
			$stmt->execute();
			$stmt->bind_result($dC, $dUD);
			while($stmt->fetch()){
			
			 //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the names of the tutors on the chart
			  $temp[] = array('v' => (string) $dUD); 

			  // Values of the each bar of the chart
			  $temp[] = array('v' => (int) $dC); 
			  
			  //store values from $temp into $rows
			    //store values from $temp into $rows
			  $rows3[] = array('c' => $temp);
			
		}//end of while
		
		//combine data from $rows into $table
			$table3['rows'] = $rows3;

			// convert data into JSON format so it can be accessed via JS
			$jsonTable3 = json_encode($table3);
			//echo $jsonTable;
		
		?>
		
		<!--Start JS Script to display the Chart-->
		<script type="text/javascript">

			 // Load the Visualization API and the corechart package.
				google.charts.load('current', {'packages':['corechart']});

			  // Set a callback to run when the Google Visualization API is loaded.
				google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
			  // Create our data table out of JSON data loaded from server.
			  var data = new google.visualization.DataTable(<?=$jsonTable3?>);
			  var options = {
				  is3D: 'true',
				  width: 1100,
				  height: 300
				};
			  // Instantiate and draw our chart, passing in some options.
			  // Do not forget to check your div ID
			  var chart = new google.visualization.BarChart(document.getElementById('chart_div3'));
			  chart.draw(data, options);
			}
		</script>
		
		<h4>Number of Uploads made by <?php echo("$fn".' '."$ln");?> in the last 7 days</h4>
		<div id="chart_div3">
		
		</div>
      
      <!-- /.row -->

     
     
	 </div>
      <!-- /.row -->
	</div>
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
