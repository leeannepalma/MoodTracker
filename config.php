<?php
$host     = 'localhost';
$db       = 'moodtracker';
$user     = 'root';
$password = 'Twin200';

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
