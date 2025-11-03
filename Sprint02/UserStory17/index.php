<?php
require_once __DIR__ . '/Boundary/searchMyRequestsBoundary.php';
require_once __DIR__ . '/Entity/Request.php';

$userID = 1; // Simulated logged-in user

echo "<form method='GET'>
        <label>Title: <input type='text' name='title'></label>
        <label>Status: 
            <select name='status'>
                <option value=''>Any</option>
                <option value='Open'>Open</option>
                <option value='Closed'>Closed</option>
                <option value='Pending'>Pending</option>
            </select>
        </label>
        <button type='submit'>Search</button>
      </form><hr>";

$boundary = new searchMyRequestsBoundary();
$boundary->handleSearch($userID);
