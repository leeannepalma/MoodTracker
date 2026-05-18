<?php
require_once 'config.php';

$success = '';
$error = '';

$id = intval($_GET['id']);
$entry = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM entries WHERE id = $id"));

if (!$entry) {
    die("Entry not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mood = intval($_POST['mood']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    if ($mood < 1 || $mood > 5) {
        $error = "Mood must be between 1 and 5.";
    } else {
        $sql = "UPDATE entries SET mood=$mood, note='$note', created_at='$date' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            $success = "Entry updated successfully!";
            $entry = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM entries WHERE id = $id"));
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoodTracker - Edit Entry</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="members.php">Members</a>
        <a href="add.php">Add Entry</a>
    </nav>

    <div class="container">
        <h1>Edit Entry</h1>

        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Mood (1-5):</label>
            <select name="mood" required>
                <option value="1" <?= $entry['mood']==1?'selected':'' ?>>1 - Very Bad</option>
                <option value="2" <?= $entry['mood']==2?'selected':'' ?>>2 - Bad</option>
                <option value="3" <?= $entry['mood']==3?'selected':'' ?>>3 - Neutral</option>
                <option value="4" <?= $entry['mood']==4?'selected':'' ?>>4 - Good</option>
                <option value="5" <?= $entry['mood']==5?'selected':'' ?>>5 - Very Good</option>
            </select>

            <label>Note:</label>
            <textarea name="note" rows="4"><?= $entry['note'] ?></textarea>

            <label>Date:</label>
            <input type="date" name="date" value="<?= $entry['created_at'] ?>" required>

            <button type="submit">Update</button>
            <a href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>
