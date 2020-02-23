<?php 
	//this is for the testing site
	
	/*
	V3 adds filter/search functionality. As the list of games grows, instead of having to scroll and look for a particular game,
	the user can start typing the name of the game and it will filter the results. I found this example on w3 schools site and 
	copied it over to my site. 
	This version also includes some Google fonts. 
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
	<meta charset="UTF-8">
	<title>Gamer Patch</title>
	<style type='text/css'>
		h1 {
			color: #4ddc0b;
			text-align: center;
			font-size: 72px;
			font-family: 'Josefin Sans', sans-serif;
		}
		div {
			width: 600px;
			margin: auto;
			/*border: 1px solid grey;*/
		}
		#myInput {
			width: 568px; /* Full-width */
			font-size: 16px; /* Increase font-size */
			padding: 12px 20px 12px 10px; /* Add some padding */
			border: 1px solid #ddd; /* Add a grey border */
			margin-bottom: 12px; /* Add some space below the input */
			}

		#myUL {
			/* Remove default list styling */
			list-style-type: none;
			padding: 0;
			margin: 0;
			}

		#myUL li a {
			border: 1px solid #ddd; /* Add a border to all links */
			margin-top: -1px; /* Prevent double borders */
			background-color: #f6f6f6; /* Grey background color */
			padding: 12px; /* Add some padding */
			text-decoration: none; /* Remove default text underline */
			font-size: 18px; /* Increase the font-size */
			color: black; /* Add a black text color */
			display: block; /* Make it into a block element to fill the whole list */
			}

		#myUL li a:hover:not(.header) {
			background-color: #eee; /* Add a hover effect to all links, except for headers */
			}
	</style>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet"> 	
</head>	


<body onload="clearInput()">
	<h1>Gamer Patch</h1>
	

	<div>
		<input type="text" id="myInput" onkeyup="filterFunction()" placeholder="Search for game...">

		<ul id="myUL">
			<?php for($i = 0; $i < count($games); $i++){ ?>
				<li><a href="updates.php?game=<?php echo ($games[$i]['game']); ?>"><?php echo ($games[$i]['game']); ?></a></li>
			<?php } ?>
		</ul> 
	</div>




<script>
	function filterFunction() {
	// Declare variables
	var input, filter, ul, li, a, i, txtValue;
	input = document.getElementById('myInput');
	filter = input.value.toUpperCase();
	ul = document.getElementById("myUL");
	li = ul.getElementsByTagName('li');

	// Loop through all list items, and hide those who don't match the search query
	for (i = 0; i < li.length; i++) {
		a = li[i].getElementsByTagName("a")[0];
		txtValue = a.textContent || a.innerText;
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
		li[i].style.display = "";
		} else {
		li[i].style.display = "none";
		}
	}
	}


	// This clears the input field so that if you type the name of a game, click on the game and view the patch notes,
	// then click the back arrow to return to the main page, what you typed in the box will not still be there. 
	function clearInput() {
		input = document.getElementById('myInput');
		input.value = '';
		//document.write('hey');
	}
</script>

</body>
</html>

