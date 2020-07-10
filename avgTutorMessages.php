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
	
	<!--JavaScript for Graph-->
	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
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
			<a class="BreadEff" href="authorizedUserDashboard.php"> Dashboard &raquo; </a>
			<a class="BreadEff" href="reportMenu.php"> Report Menu &raquo;</a>
			<a class="BreadEff" href="#"> Number of Messages Report</a>
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
	<h1>Average Number of Tutor Messages</h1>
	<br />
	
	
	<!--User Table-->
	<div class="container">
		
		<?php
			
			//Start Chart Code
			//make connection to database
			include('DBConnect.php');
			
			/*
			Code adapted from: https://stackoverflow.com/questions/12994282/php-mysql-google-chart-json-complete-example
			Code accessed on: 24/10/2018
			Code Author: Anam
			*/
			
			//Object-Oriented method of mysqli had to be used, procedural method did not work well with the rest of the code.
			$result=$mysqli->query('SELECT CONCAT(useraccount.firstName," ",useraccount.lastName) AS fullName, COUNT(message.messageID) AS NumMessage
			FROM useraccount, tutor, message
			WHERE message.sender=useraccount.userID AND useraccount.userID=tutor.userID 
			AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID');
			
			include('DBConnect.php');
			$result2=$mysqli->query('SELECT CONCAT(useraccount.firstName," ",useraccount.lastName) AS fullName, COUNT(message.messageID) AS NumMessage
			FROM useraccount, tutor, message
			WHERE message.recipient=useraccount.userID AND useraccount.userID=tutor.userID 
			AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID');
			
			// query to show replies sent
			include('DBConnect.php');
			$result3=$mysqli->query('SELECT CONCAT(useraccount.firstName," ",useraccount.lastName) AS fullName, COUNT(reply.messageID)AS NumReply
			FROM useraccount, tutor, reply
			WHERE reply.sender=useraccount.userID AND useraccount.userID=tutor.userID 
			AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID');
			
			//second query to show replies received
			include('DBConnect.php');
			$result4=$mysqli->query('SELECT CONCAT(useraccount.firstName," ",useraccount.lastName) AS fullName, COUNT(reply.messageID)AS NumReply
			FROM useraccount, tutor, reply
			WHERE reply.recipient=useraccount.userID AND useraccount.userID=tutor.userID 
			AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID');
			
			//create arrays to house data for the messages sent chart
			//this array is for the dataTable row used for the messages chart
			$rows = array();
			//this array is the entire dataTable
		    $table = array();
			//this identifies the "columns" of the dataTable
		    $table['cols'] = array( 
			//table titles
			array('label' => 'Name', 'type' => 'string'),
			array('label' => 'Messages', 'type' => 'number')
			);
			
			//get results from $result
			 // Extract the information from $result by looping through result
			foreach($result as $r) {
			
			  //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the names of the tutors on the chart
			  $temp[] = array('v' => (string) $r['fullName']); 

			  // Values of the each bar of the chart
			  $temp[] = array('v' => (int) $r['NumMessage']/7); 
			  
			  //store values from $temp into $rows
			  $rows[] = array('c' => $temp);
			}
			
			//combine data from $rows into $table
			$table['rows'] = $rows;

			// convert data into JSON format so it can be accessed via JS
			$jsonTable = json_encode($table);
			//echo $jsonTable;
			
		?>
		<!--Start JS Script to display the Messages Sent Chart-->
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
				  height: 400
				};
			  // Instantiate and draw our chart, passing in some options.
			  // Do not forget to check your div ID
			  var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
			  chart.draw(data, options);
			}
		</script>
		
		<h4>Average messages sent in last 7 days</h4>
		<div id="chart_div">
		
		</div>
		
		<?php
		//do some code to show the literal messages sent to the admin
		include('DBConnect.php');
		
		//write query to pull the content from messages in the last 7 days
			$stmt=mysqli_prepare($mysqli, 
			"SELECT useraccount.userID, useraccount.firstName, useraccount.lastName, COUNT(message.messageID)AS NumMessages
			FROM useraccount, tutor, message
			WHERE message.sender=useraccount.userID AND useraccount.userID=tutor.userID 
			AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID");
			if($stmt){
				//execute mysqli statement
				mysqli_stmt_execute($stmt);
				
				//bind result to global variables
				mysqli_stmt_bind_result($stmt, $uID, $uFirstName, $uLastName, $numMessages);
				
				echo"
					<h5>These are all the messages sent in the past 7 days.</h5>
					<table class='table table-bordered table-striped table-hover'> 
					<tr>
						<th>Tutor ID</th>
						<th>Tutor Name</th>
						<th>Number of Messages Sent</th>
						<th>Average Number of Messages</th>
					</tr>";
				
				//echo result
				while(mysqli_stmt_fetch($stmt)){
					$averageMessage=($numMessages/7);
					echo"
						<tr>
							<td>$uID</td>
							<td>$uFirstName".' '."$uLastName</td>
							<td>$numMessages</td>
							<td>$averageMessage</td>
						</tr>
					";
				}//end of while loop
				echo("</table>");
			}//end of if statement
			
			//create arrays to house data for the messages received chart
			//this array is for the dataTable row used for the messages chart
			$rows2 = array();
			//this array is the entire dataTable
		    $table2 = array();
			//this identifies the "columns" of the dataTable
		    $table2['cols'] = array( 
			//table titles
			array('label' => 'Name', 'type' => 'string'),
			array('label' => 'Messages', 'type' => 'number')
			);
			
			//get results from $result
			 // Extract the information from $result by looping through result
			foreach($result2 as $r2) {
			
			  //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the names of the tutors on the chart
			  $temp[] = array('v' => (string) $r2['fullName']); 

			  // Values of the each bar of the chart
			  $temp[] = array('v' => (int) $r2['NumMessage']/7); 
			  
			  //store values from $temp into $rows
			  $rows2[] = array('c' => $temp);
			}
			
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
				  height: 400
				};
			  // Instantiate and draw our chart, passing in some options.
			  // Do not forget to check your div ID
			  var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
			  chart.draw(data, options);
			}
		</script>
		
		<h4>Average messages received in last 7 days</h4>
		<div id="chart_div2">
		
		</div>
		
		<?php
		//do some code to show the literal messages received to the admin
		include('DBConnect.php');
		
		//write query to pull the content from messages in the last 7 days
			$stmt=mysqli_prepare($mysqli, 
			"SELECT useraccount.userID, useraccount.firstName, useraccount.lastName, COUNT(message.messageID)AS NumMessages
			FROM useraccount, tutor, message
			WHERE message.recipient=useraccount.userID AND useraccount.userID=tutor.userID 
			AND message.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID");
			if($stmt){
				//execute mysqli statement
				mysqli_stmt_execute($stmt);
				
				//bind result to global variables
				mysqli_stmt_bind_result($stmt, $uID, $uFirstName, $uLastName, $numMessages);
				
				echo"
					<h5>These are all the messages received in the past 7 days.</h5>
					<table class='table table-bordered table-striped table-hover'> 
					<tr>
						<th>Tutor ID</th>
						<th>Tutor Name</th>
						<th>Number of Messages received</th>
						<th>Average Number of Messages</th>
					</tr>";
				
				//echo result
				while(mysqli_stmt_fetch($stmt)){
					$averageMessage=($numMessages/7);
					echo"
						<tr>
							<td>$uID</td>
							<td>$uFirstName".' '."$uLastName</td>
							<td>$numMessages</td>
							<td>$averageMessage</td>
						</tr>
					";
				}//end of while loop
				echo("</table>");
			}//end of if statement
			
			//create arrays to house data for the replys sent chart
			//this array is for the dataTable row used for the messages chart
			$rows3 = array();
			//this array is the entire dataTable
		    $table3 = array();
			//this identifies the "columns" of the dataTable
		    $table3['cols'] = array( 
			//table titles
			array('label' => 'Name', 'type' => 'string'),
			array('label' => 'Replys', 'type' => 'number')
			);
			
			foreach($result3 as $r3) {
			
			  //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the messageDates of the chart
			  $temp[] = array('v' => (string) $r3['fullName']); 

			  // Values of the each bar of the chart
			  
			  $temp[] = array('v' => (int) $r3['NumReply']/7); 
			  
			  //store values from $temp into $rows2 for the replys
			  $rows3[] = array('c' => $temp);
			}
			
			//combine data from $rows into $table for the replys
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
				  height: 400
				};
			  // Instantiate and draw our chart, passing in some options.
			  // Do not forget to check your div ID
			  var chart = new google.visualization.BarChart(document.getElementById('chart_div3'));
			  chart.draw(data, options);
			}
		</script>
		
		<br/>
		
		<h4>Average replies sent in last 7 days</h4>
		
		<div id="chart_div3">
		
		</div>

		<?php
			
			//do some code to show the literal messages to the admin
		include('DBConnect.php');
		
		//write query to pull the content from messages in the last 7 days
			$stmt=mysqli_prepare($mysqli, 
			"SELECT useraccount.userID, useraccount.firstName, useraccount.lastName, COUNT(reply.messageID)AS NumReply
			FROM useraccount, tutor, reply
			WHERE reply.sender=useraccount.userID AND useraccount.userID=tutor.userID 
			AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID");
			if($stmt){
				//execute mysqli statement
				mysqli_stmt_execute($stmt);
				
				//bind result to global variables
				mysqli_stmt_bind_result($stmt, $uID, $uFirstName, $uLastName, $numReply );
				
				echo"
					<h5>These are all the replies sent in the past 7 days.</h5>
					<table class='table table-bordered table-striped table-hover'> 
					<tr>
						<th>Tutor ID</th>
						<th>Tutor Name</th>
						<th>Number of Replies Sent</th>
						<th>Average Number of Replies</th>
					</tr>";
				
				//echo result
				while(mysqli_stmt_fetch($stmt)){
					$averageReply=$numReply/7;
					echo"
						<tr>
							<td>$uID</td>
							<td>$uFirstName".' '."$uLastName</td>
							<td>$numReply</td>
							<td>$averageReply</td>
						</tr>
					";
				}//end of while loop
				echo("</table>");
			}//end of if statement
			
			//create arrays to house data for the replys sent chart
			//this array is for the dataTable row used for the messages chart
			$rows4 = array();
			//this array is the entire dataTable
		    $table4 = array();
			//this identifies the "columns" of the dataTable
		    $table4['cols'] = array( 
			//table titles
			array('label' => 'Name', 'type' => 'string'),
			array('label' => 'Replys', 'type' => 'number')
			);
			
			foreach($result4 as $r4) {
			
			  //create temporary array to store results 
			  $temp = array();

			  // The following line will be used to display the messageDates of the chart
			  $temp[] = array('v' => (string) $r4['fullName']); 

			  // Values of the each bar of the chart
			  
			  $temp[] = array('v' => (int) $r4['NumReply']/7); 
			  
			  //store values from $temp into $rows2 for the replys
			  $rows4[] = array('c' => $temp);
			}
			
			//combine data from $rows into $table for the replys
			$table4['rows'] = $rows4;

			// convert data into JSON format so it can be accessed via JS
			$jsonTable4 = json_encode($table4);
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
			  var data = new google.visualization.DataTable(<?=$jsonTable4?>);
			  var options = {
				  is3D: 'true',
				  width: 1100,
				  height: 400
				};
			  // Instantiate and draw our chart, passing in some options.
			  // Do not forget to check your div ID
			  var chart = new google.visualization.BarChart(document.getElementById('chart_div4'));
			  chart.draw(data, options);
			}
		</script>
		
		<br/>
		
		<h4>Average replies received in last 7 days</h4>
		
		<div id="chart_div4">
		
		</div>

		<?php
			
			//do some code to show the literal messages to the admin
		include('DBConnect.php');
		
		//write query to pull the content from messages in the last 7 days
			$stmt=mysqli_prepare($mysqli, 
			"SELECT useraccount.userID, useraccount.firstName, useraccount.lastName, COUNT(reply.messageID)AS NumReply
			FROM useraccount, tutor, reply
			WHERE reply.recipient=useraccount.userID AND useraccount.userID=tutor.userID 
			AND reply.messageDate BETWEEN (CURRENT_DATE()+ INTERVAL -7 DAY) AND NOW()
			GROUP BY useraccount.userID");
			if($stmt){
				//execute mysqli statement
				mysqli_stmt_execute($stmt);
				
				//bind result to global variables
				mysqli_stmt_bind_result($stmt, $uID, $uFirstName, $uLastName, $numReply );
				
				echo"
					<h5>These are all the replies received in the past 7 days.</h5>
					<table class='table table-bordered table-striped table-hover'> 
					<tr>
						<th>Tutor ID</th>
						<th>Tutor Name</th>
						<th>Number of Replies Received</th>
						<th>Average Number of Replies</th>
					</tr>";
				
				//echo result
				while(mysqli_stmt_fetch($stmt)){
					$averageReply=$numReply/7;
					echo"
						<tr>
							<td>$uID</td>
							<td>$uFirstName".' '."$uLastName</td>
							<td>$numReply</td>
							<td>$averageReply</td>
						</tr>
					";
				}//end of while loop
				echo("</table>");
			}//end of if statement
		
		?>
	
	</div>
	   
      
      <!-- /.row -->

     
      </div>
	 </div>
      <!-- /.row -->
	</div>
    <!-- /.container -->
	</div>
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
