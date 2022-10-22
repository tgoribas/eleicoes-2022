<?php
//BD Novo
$servername = $dbConfig ['db_host'];
$username =  $dbConfig ['db_user'];
$password = $dbConfig ['db_pass'];
$dbname = $dbConfig ['db_name'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
