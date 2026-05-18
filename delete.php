<?php
require_once 'config.php';

$id = intval($_GET['id']);

if (!$id) {
    header("Location: index.php");
    exit;
}

$sql = "DELETE FROM entries WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
    exit;
} else {
    die("Error deleting entry: " . mysqli_error($conn));
}
?>
