<?php

	include("hub.php");
	
	$map = $_GET['map'];
	if(!in_array($map, $map_id))
		die('Sorry, something went seriously wrong.');

	// assign variables based on the map selection
	switch($map) {
		case "celle" :
			$gxMin = $celle_gps[0];
			$gyMin = $celle_gps[1];
			$gxMax = $celle_gps[2];
			$gyMax = $celle_gps[3];
			$scale = $celle_gps[4];
			$digits = $celle_gps[5];
			$dir = $celle_gps[6];
			$xMax = $celle_dimension[0];
			$yMax = $celle_dimension[1];
		break;
		case "chernarus" :
			$gxMin = $chernarus_gps[0];
			$gyMin = $chernarus_gps[1];
			$gxMax = $chernarus_gps[2];
			$gyMax = $chernarus_gps[3];
			$scale = $chernarus_gps[4];
			$digits = $chernarus_gps[5];
			$dir = $chernarus_gps[6];
			$xMax = $chernarus_dimension[0];
			$yMax = $chernarus_dimension[1];
		break;
		case "lingor_island" :
			$gxMin = $lingor_island_gps[0];
			$gyMin = $lingor_island_gps[1];
			$gxMax = $lingor_island_gps[2];
			$gyMax = $lingor_island_gps[3];
			$scale = $lingor_island_gps[4];
			$digits = $lingor_island_gps[5];
			$dir = $lingor_island_gps[6];
			$xMax = $lingor_island_dimension[0];
			$yMax = $lingor_island_dimension[1];
		break;
	}

	if(!isset($_POST['formSubmit'])) {
		// the user did not click submit yet
		$gpsvalue = "";
		$dbvalue = "";
		$x = -15;
		$y = -15;
	} else {
		// the user clicked submit
		$c = $_GET['c'];
		switch($c) {
			case "GPS2DB" : // convert GPS to DB formula
				$gpsvalue = $_POST['gps'];
				$x = ((int) substr($gpsvalue, 0, $digits))*$scale - ($gxMin*$scale);
				$y = $yMax - abs($gyMax - (int) substr($gpsvalue, $digits, $digits))*$scale;
				$dbvalue = "[0[$x.0,$y.0,0.001]]";
			break;
			case "DB2GPS" : // convert DB to GPS
				$dbvalue = $_POST['db'];
				
				// conversion format:
				// [###[#######,########,#####]]
				// remove first [ and last 2 ]] => ###[######,#######,######
				// get index of first [, return substr from index to end
				// expand ######,######,###### into an array where x[0], y[1], z[2]
				
				$str = substr($dbvalue, 1, strlen($dbvalue)-3);
				$index = strpos($str, "[")+1;
				$str = substr($str, $index, strlen($str));
				$vals = explode(",", $str);
				$x = $vals[0]; // x db coordinate
				$y = $vals[1]; // y db coordinate
				
				// gps x coordinate
				$gx = str_pad((int)($x/$scale)+$gxMin, $digits, "0", STR_PAD_LEFT);
				
				// some maps y increases Northwards, and some maps
				// y increases Southwards, so add the lowest value
				// y to the calculated y coordinate
				// gps y coordinate
				$pos = (int)(($yMax - $y)/$scale);
				if($dir == "up") {
					$pos = $pos + $gyMin;
				} else {
					$pos = $pos + $gyMax;
				}
				$gy = str_pad($pos, $digits, "0", STR_PAD_LEFT);
				
				$gpsvalue = $gx . $gy;
			break;
		}
	}
	
	if($digits == 3) {
		$gps_eg = "059074";
	} else {
		$gps_eg = "03110766";
	}

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
	coordinates into hive Database Coordinates and vice-versa.</h3><br />
    <a href="index.php" style="text-decoration: none;"><h3><< Select new map.</h3></a>
    <br />
</center>
<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td width="500"><a href="gen_image.php<?php echo "?map=$map&x=$x&xmax=$xMax&y=$y&ymax=$yMax&t=" . time(); ?>" target="_blank"><img src="gen_image.php<?php echo "?map=$map&x=$x&xmax=$xMax&y=$y&ymax=$yMax&t=" . time(); ?>" width="500" style="border: 0;" /></a></td>
        <td width="300" align="center"><h3>Convert GPS/MAP to/from HiveDB</h1><br />
        
        <?php
			
			echo "<form action=\"converter.php?map=$map&c=GPS2DB\" method=\"post\">";
			echo "<h3>GPS Coordinates to DB String<br />[*Format ($digits digits xy): \"$gps_eg\"]</h3>\n";
			echo "<input type=\"text\" name=\"gps\" value=\"$gpsvalue\" style=\"width: 180px;\" />";
			echo "<input type=\"hidden\" name=\"formSubmit\" value=\"true\" />";
			echo "<input type=\"submit\" value=\"GO\" name=\"convertGPS\" />";
			echo "</form>\n<br />";
			
			echo "<form action=\"converter.php?map=$map&c=DB2GPS\" method=\"post\">";
			echo "<h3>DB String to GPS Coordinates<br />[*Format \"[direction[x,y,z]]\"]</h3>\n";
			echo "<input type=\"text\" name=\"db\" value=\"$dbvalue\" style=\"width: 180px;\" />";
			echo "<input type=\"hidden\" name=\"formSubmit\" value=\"true\" />";
			echo "<input type=\"submit\" value=\"GO\" name=\"convertGPS\" />";
			echo "<h3>(all directions, 0 - face North)</h3>";
			echo "</form>\n<br />";
		
		?>
       
        </td>
    </tr>
</table>

</body>
</html>
