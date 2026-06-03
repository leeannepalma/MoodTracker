<?php require_once 'config.php';
$emojis = [1 => '😢', 2 => '😕', 3 => '😐', 4 => '😊', 5 => '😁'];
$labels = [1 => 'Very Bad', 2 => 'Bad', 3 => 'Neutral', 4 => 'Good', 5 => 'Very Good'];

$today = date('Y-m-d');
$today_mood = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ROUND(AVG(mood)) as avg_mood, COUNT(*) as count FROM entries WHERE created_at = '$today'"));
$mood_today = $today_mood['avg_mood'] ? intval($today_mood['avg_mood']) : 0;

$quotes = [
    "Take a deep breath. You are exactly where you need to be.",
    "Your mental health is a priority. Your happiness is essential.",
    "It is okay to not be okay, as long as you are not giving up.",
    "Every day may not be good, but there is something good in every day.",
    "Be gentle with yourself. You are doing the best you can.",
    "Small steps every day lead to big changes over time.",
    "You do not have to control your thoughts. You just have to stop letting them control you.",
    "Happiness is not something ready-made. It comes from your own actions.",
    "The greatest glory in living lies not in never falling, but in rising every time we fall.",
    "Mental health is not a destination, but a process."
];
$daily_quote = $quotes[date('z') % count($quotes)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoodTracker - Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #6b3fa0, #9b59b6, #8e44ad);
            border-radius: 16px;
            padding: 40px 32px;
            color: #fff;
            text-align: center;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(107,63,160,0.3);
        }
        .welcome-banner h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #fff;
        }
        .welcome-banner p {
            font-size: 16px;
            opacity: 0.9;
        }
        .home-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        .home-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(107,63,160,0.1);
            text-align: center;
        }
        .home-card .card-emoji {
            font-size: 48px;
            margin-bottom: 12px;
        }
        .home-card .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #6b3fa0;
            margin-bottom: 6px;
        }
        .home-card .card-value {
            font-size: 18px;
            font-weight: 700;
            color: #2d2d2d;
        }
        .home-card .card-sub {
            font-size: 13px;
            color: #888;
            margin-top: 4px;
        }
        .quote-card {
            background: linear-gradient(135deg, #faf8ff, #ede8f5);
            border-radius: 16px;
            padding: 24px 32px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(107,63,160,0.1);
            text-align: center;
            border-left: 4px solid #6b3fa0;
        }
        .quote-card .quote-icon {
            font-size: 28px;
            margin-bottom: 8px;
        }
        .quote-card .quote-text {
            font-size: 16px;
            font-style: italic;
            color: #4a4a4a;
            line-height: 1.6;
        }
        .quick-add {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #6b3fa0, #9b59b6);
            color: #fff;
            padding: 18px 32px;
            border-radius: 14px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(107,63,160,0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .quick-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107,63,160,0.4);
        }
        .quick-add .add-emoji {
            font-size: 24px;
            margin-right: 10px;
        }
        .entries-section {
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 16px rgba(107,63,160,0.1);
        }
        .entries-section h2 {
            font-size: 18px;
            color: #6b3fa0;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="members.php">Members</a>
        <a href="add.php">Add Entry</a>
    </nav>
    <div class="container">

        <div class="welcome-banner">
            <h2>Welcome to MoodTracker</h2>
            <p>Track your emotions. Understand yourself. Grow every day.</p>
        </div>

        <div class="home-grid">
            <div class="home-card">
                <div class="card-emoji"><?= $mood_today ? $emojis[$mood_today] : '🌤️' ?></div>
                <div class="card-title">Mood of the Day</div>
                <div class="card-value"><?= $mood_today ? $labels[$mood_today] : 'No entries yet' ?></div>
                <div class="card-sub"><?= $today_mood['count'] ?> entries today</div>
            </div>
            <div class="home-card">
                <div class="card-emoji">📊</div>
                <div class="card-title">Total Entries</div>
                <div class="card-value"><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM entries"))['c'] ?></div>
                <div class="card-sub">All time</div>
            </div>
            <div class="home-card">
                <div class="card-emoji">👥</div>
                <div class="card-title">Team Members</div>
                <div class="card-value"><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM members"))['c'] ?></div>
                <div class="card-sub">Active members</div>
            </div>
        </div>

        <div class="quote-card">
            <div class="quote-icon">💜</div>
            <div class="quote-text">"<?= $daily_quote ?>"</div>
        </div>

        <a href="add.php" class="quick-add">
            <span class="add-emoji">✨</span> How are you feeling today? Log your mood!
        </a>

        <div class="entries-section">
            <h2>All Mood Entries</h2>
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
    </div>
</body>
</html>
