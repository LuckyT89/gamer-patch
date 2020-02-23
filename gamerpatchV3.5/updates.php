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
    <meta charset="UTF-8">
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



</body>
</html>

