<?php
function getDBConnection() {
    $conn = mysqli_connect("localhost", "root", "", "CSRPIN_platform",3307);

    if (!$conn) 
	{
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
