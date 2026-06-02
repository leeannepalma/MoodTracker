<?php require_once 'config.php';
$emojis = [1 => '😢', 2 => '😕', 3 => '😐', 4 => '😊', 5 => '😁'];
$labels = [1 => 'Very Bad', 2 => 'Bad', 3 => 'Neutral', 4 => 'Good', 5 => 'Very Good'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoodTracker - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="members.php">Members</a>
        <a href="add.php">Add Entry</a>
    </nav>
    <div class="container">
        <h1>All Mood Entries</h1>
        <table>
            <thead><tr><th>ID</th><th>Member</th><th>Mood</th><th>Note</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
            <?php
            $sql = "SELECT entries.id, members.name, entries.mood, entries.note, entries.created_at FROM entries JOIN members ON entries.member_id = members.id ORDER BY entries.created_at DESC";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)): $m = $row['mood']; ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><span class="mood-badge mood-badge-<?= $m ?>"><span class="mood-emoji"><?= $emojis[$m] ?></span><?= $labels[$m] ?></span></td>
                    <td><?= $row['note'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this entry?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="6">No entries yet. <a href="add.php">Add one!</a></td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

