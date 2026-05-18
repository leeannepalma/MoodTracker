<?php
require_once 'config.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = intval($_POST['member_id']);
    $mood      = intval($_POST['mood']);
    $note      = mysqli_real_escape_string($conn, $_POST['note']);
    $date      = mysqli_real_escape_string($conn, $_POST['date']);

    if ($mood < 1 || $mood > 5) {
        $error = "Mood must be between 1 and 5.";
    } else {
        $sql = "INSERT INTO entries (member_id, mood, note, created_at)
                VALUES ($member_id, $mood, '$note', '$date')";
        if (mysqli_query($conn, $sql)) {
            $success = "Entry added successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

$members = mysqli_query($conn, "SELECT * FROM members");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoodTracker - Add Entry</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="members.php">Members</a>
        <a href="add.php">Add Entry</a>
    </nav>

    <div class="container">
        <h1>Log Your Mood</h1>

        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Member:</label>
            <select name="member_id" required>
                <option value="">-- Select Member --</option>
                <?php while ($row = mysqli_fetch_assoc($members)): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>

            <label>Mood (1-5):</label>
            <select name="mood" required>
                <option value="1">1 - Very Bad</option>
                <option value="2">2 - Bad</option>
                <option value="3">3 - Neutral</option>
                <option value="4">4 - Good</option>
                <option value="5">5 - Very Good</option>
            </select>

            <label>Note:</label>
            <textarea name="note" rows="4" placeholder="How are you feeling?"></textarea>

            <label>Date:</label>
            <input type="date" name="date" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
