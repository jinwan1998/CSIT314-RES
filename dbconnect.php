<?php
$servername = "cdm1s48crk8itlnr.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "wxlmw1lx35aonx2n";
$password = "emg03gpbd89tdw3a";
$dbname = "fddwxl3t1j0vixe2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>