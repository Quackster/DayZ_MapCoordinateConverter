<?php
	
	include("hub.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>DayZ Map Coordinate Converter</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<center>
	<h1>DayZ Map Coordinate Converter</h1>
	<h3>This web utility will allow you to convert in-game GPS and Map<br />
	coordinates into hive Database Coordinates and vice-versa.</h3>
    <br />
    <h3>Please select a map: <select onchange="window.open(this.value,'_self');">
    	<option value="#">-Select Map-</option>
    	<?php
			
			// display all the map names within a dropdown box
			for($i = 0; $i < sizeof($map_names); $i++)
				echo "<option value=\"converter.php?map=$map_id[$i]\">$map_names[$i]</option>\n";
		
		?>
    </select></h3>
	</center>
</body>

</html>
