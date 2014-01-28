<?php

	// available and supported maps for the converted.
	// $map_name = array("..."Full Map Name"...");
	// $map_id = array("..."simple_name"...");
	$map_names = array("Celle","Chernarus","Lingor Island");
	$map_id = array("celle","chernarus","lingor_island");
	
	// map actual dimensions in meters
	// $mapid_dimension = array(xMax, yMax)
	$celle_dimension = array(12290.0, 12290.0);
	$chernarus_dimension = array(15360.0, 15360.0);
	$lingor_island_dimension = array(10240.0, 10240.0);
	
	// in game gps coordinates
	// $mapid_gps = array(xMin, yMin, xMax, yMax, scale, digits on GPS, direction)
	$celle_gps = array(5957, 1130, 7186, 2359, 10, 4, "up");
	$chernarus_gps = array(000, 153, 153, 000, 100, 3, "down");
	$lingor_island_gps = array(000, 000, 102, 102, 100, 3, "up");
	

?>