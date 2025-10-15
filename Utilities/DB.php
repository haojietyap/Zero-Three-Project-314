<?php
function getDBConnection() {
    $conn = mysqli_connect("localhost", "root", "", "c2c_platform",3307);

    if (!$conn) 
	{
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
