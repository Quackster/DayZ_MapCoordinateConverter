<?php
	
	// output a png to the browser
	header('Content-Type: image/png');
	
	include("hub.php");
	
	$m = $_GET['map'];
	$x = (int)$_GET['x'];
	$y = (int)$_GET['y'];
	$x_max = (int)$_GET['xmax'];
	$y_max = (int)$_GET['ymax'];

	if(!in_array($m, $map_id))
		die('Sorry, something went seriously wrong.'); 
	
	$img = "images/" . $m . ".png";
	
	// allocate a png image in memory
	$im = imagecreatefrompng($img);
	
	// draw the position node on the map
	$node_color = imagecolorallocate($im, 255, 102, 51);
	$node_color2 = imagecolorallocate($im, 51, 221, 51);
	imagefilledellipse($im, $x/10, ($y_max-$y)/10, 10, 10, $node_color);
	imagefilledellipse($im, $x/10, ($y_max-$y)/10, 5, 5, $node_color2);

	// output the image as a png from memory
	imagepng($im);
	
	// clear the memory
	imagedestroy($im);

?>