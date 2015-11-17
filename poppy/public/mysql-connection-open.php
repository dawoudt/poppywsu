<?php

// declare common connection close for all files to easily use,
// and allow for easy change of multiple files connection settings
// easily

$conn = mysqli_connect("localhost", "root", "root", "poppydb");

// display error if mysqli_connect_error() triggers
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>