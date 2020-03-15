<?php 
	//this is for the testing site
	
	/*
	V4.1 added images and a jumbotron to the home page. It removed the filter bar.  
	*/


	// connect to database
	$conn = mysqli_connect('localhost', 'tyler', 'tyler123', 'tylerdb');
	
	// check database connection- display error if it didn't work
	if(!$conn){
		echo 'Connection error: ' . mysqli_connect_error(); 
	}
	
	// write query 
	$sql = "SELECT * FROM games ORDER BY game";
	
	// make query and get results
	$result = mysqli_query($conn, $sql);
	
	// fetch resulting rows as an array
	$games = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	// free result from memory
	mysqli_free_result($result);
	
	// close connection
	mysqli_close($conn); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
	<title>Gamer Patch</title>

	<style type='text/css'>
		
		.jumbotron {background-color: #4ddc0b;}

		img {object-fit: contain;}

		.card {border: none; margin: 20px 5px;}

	</style>	
</head>	

<body>

	<div class='jumbotron jumbotron-fluid text-center text-white'>
		<div class='container'>
			<h1 class='display-1'>Gamer Patch</h1>
			<p class='lead'>Stay up to date on the games that you play</p>
		</div>
	</div>
	

	<!--Bootstrap cards start here-->
	<div class='container'>
		<div class='row'>
			<?php for($i = 0; $i < count($games); $i++){ ?>
				<div class='col-md-4'>
					<div class='card text-center'>
						<a href="updates.php?game=<?php echo ($games[$i]['game']); ?>">
						<img src='<?php echo ($games[$i]['gameLogo']); ?>'>
						<div class='card-block'>
							<h3><?php echo ($games[$i]['game']); ?></h3>
						</div>
						</a>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

