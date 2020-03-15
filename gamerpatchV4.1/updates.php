<?php
	
    // connect to database
	$conn = mysqli_connect('localhost', 'tyler', 'tyler123', 'tylerdb');
	
	// check database connection- display error if it didn't work
	if(!$conn){
		echo 'Connection error: ' . mysqli_connect_error(); 
	}
    
	
	$string = $_GET['game'];
	$string = '"' . $string . '"';
	
	
	
	// write query. this selects all fields and formats the date to look more readable.
	// note when I tried to order by 'newDate' it was not sorting the updates properly but I am still
	// able to order by just 'date' and it works correctly. 
	$sql = 'SELECT id, game, DATE_FORMAT(date, "%M %e, %Y") AS newDate, filePath FROM updates WHERE game = ' . $string . ' ORDER BY date DESC';
	
	// make query and get results
	$result = mysqli_query($conn, $sql);
	
	// fetch resulting rows as an array
	$updates = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
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
		.game {
			font-size: 72px;
			width: 80%;
			margin: auto;
			margin-top: 30px;
			margin-bottom: 30px;
		}
		.game, .date {
			color: #4ddc0b;
			text-align: center;
			font-family: 'Josefin Sans', sans-serif;
		}
		.update {
			border: 1px solid #191919;
			padding: 20px;
			width: 80%;
			margin: auto;
			margin-bottom: 30px;
			font-family: arial;
			background-color: #f6f6f6;
		}
	</style>
	
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet"> 
</head>


<body>
	<h1 class='game'> <?php echo ($updates[0]['game']) . ' Patch Notes'; ?> </h1>

	<?php for($i = 0; $i < count($updates); $i++){ ?>

		<div class='update'>
			<h1 class='date'> <?php echo ($updates[$i]['newDate']); ?> </h1>
			<p> <?php include($updates[$i]['filePath']); ?>  </p> <br />	
		</div>

	<?php } ?>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>

