<?php
require_once 'config.php';
$emojis = [1 => '😢', 2 => '😕', 3 => '😐', 4 => '😊', 5 => '😁'];
$labels = [1 => 'Very Bad', 2 => 'Bad', 3 => 'Neutral', 4 => 'Good', 5 => 'Very Good'];
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM entries"))['count'];
$total_members = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM members"))['count'];
$avg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ROUND(AVG(mood), 1) as avg_mood FROM entries"))['avg_mood'];
$avg = $avg ? $avg : 0;
$avg_emoji = $emojis[round($avg)] ?? '😐';
$active = mysqli_fetch_assoc(mysqli_query($conn, "SELECT members.name, COUNT(*) as count FROM entries JOIN members ON entries.member_id = members.id GROUP BY member_id ORDER BY count DESC LIMIT 1"));
$mood_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
$dist_result = mysqli_query($conn, "SELECT mood, COUNT(*) as count FROM entries GROUP BY mood");
while ($row = mysqli_fetch_assoc($dist_result)) { $mood_counts[$row['mood']] = $row['count']; }
$max_count = max($mood_counts) ?: 1;
$recent = mysqli_query($conn, "SELECT entries.mood, entries.note, entries.created_at, members.name FROM entries JOIN members ON entries.member_id = members.id ORDER BY entries.created_at DESC LIMIT 5");
$all_members = mysqli_query($conn, "SELECT * FROM members");
$start_date = date('Y-m-d', strtotime('-83 days'));
$entry_data = [];
$heatmap_query = mysqli_query($conn, "SELECT member_id, created_at, mood FROM entries WHERE created_at >= '$start_date'");
while ($row = mysqli_fetch_assoc($heatmap_query)) { $entry_data[$row['member_id']][$row['created_at']] = $row['mood']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoodTracker - Dashboard</title>
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
        <h1>Dashboard</h1>
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-emoji">📝</div><div class="stat-number"><?= $total ?></div><div class="stat-label">Total Entries</div></div>
            <div class="stat-card"><div class="stat-emoji">👥</div><div class="stat-number"><?= $total_members ?></div><div class="stat-label">Members</div></div>
            <div class="stat-card"><div class="stat-emoji"><?= $avg_emoji ?></div><div class="stat-number"><?= $avg ?></div><div class="stat-label">Average Mood</div></div>
            <div class="stat-card"><div class="stat-emoji">⭐</div><div class="stat-number"><?= $active ? $active['name'] : 'N/A' ?></div><div class="stat-label">Most Active (<?= $active ? $active['count'] . ' entries' : '' ?>)</div></div>
        </div>
        <div class="chart-container">
            <h2>Mood Distribution</h2>
            <div class="bar-chart">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="bar-group">
                    <div class="bar-count"><?= $mood_counts[$i] ?></div>
                    <div class="bar bar-<?= $i ?>" style="height: <?= ($mood_counts[$i] / $max_count) * 150 ?>px;"></div>
                    <div class="bar-label"><?= $emojis[$i] ?><br><?= $labels[$i] ?></div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="chart-container">
            <h2>Mood Activity</h2>
            <div class="heatmap-legend">
                <span class="legend-label">Less</span>
                <span class="heatmap-cell cell-empty"></span>
                <span class="heatmap-cell cell-mood-1"></span>
                <span class="heatmap-cell cell-mood-2"></span>
                <span class="heatmap-cell cell-mood-3"></span>
                <span class="heatmap-cell cell-mood-4"></span>
                <span class="heatmap-cell cell-mood-5"></span>
                <span class="legend-label">Better</span>
            </div>
            <?php mysqli_data_seek($all_members, 0);
            while ($member = mysqli_fetch_assoc($all_members)):
                $mid = $member['id']; ?>
            <div class="heatmap-member">
                <div class="heatmap-name"><?= $member['name'] ?></div>
                <div class="heatmap-grid">
                    <?php for ($d = 83; $d >= 0; $d--):
                        $date = date('Y-m-d', strtotime("-$d days"));
                        $mood = isset($entry_data[$mid][$date]) ? $entry_data[$mid][$date] : 0;
                        $cell_class = $mood > 0 ? "cell-mood-$mood" : "cell-empty";
                        $title_text = date('M j', strtotime($date));
                        if ($mood > 0) { $title_text .= " - " . $emojis[$mood] . " " . $labels[$mood]; }
                    ?>
                    <div class="heatmap-cell <?= $cell_class ?>" title="<?= $title_text ?>"></div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="mindfulness-section">
            <h2>Mindfulness Corner</h2>
            <p class="mindfulness-desc">Take a moment to breathe, reflect, and reset your mind.</p>
            <div class="video-grid">
                <div class="video-card">
                    <iframe src="https://www.youtube.com/embed/-2zdUXve6fQ" allowfullscreen></iframe>
                    <div class="video-title">Guided Meditation</div>
                </div>
                <div class="video-card">
                    <iframe src="https://www.youtube.com/embed/cyMxWXlX9sU" allowfullscreen></iframe>
                    <div class="video-title">Breathing Exercise</div>
                </div>
                <div class="video-card">
                    <iframe src="https://www.youtube.com/embed/QHkXvPq2pQE" allowfullscreen></iframe>
                    <div class="video-title">Mindful Relaxation</div>
                </div>
            </div>
        </div>
        <div class="recent-section">
            <h2>Recent Entries</h2>
            <?php if (mysqli_num_rows($recent) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($recent)): ?>
                <div class="recent-entry">
                    <div class="entry-emoji"><?= $emojis[$row['mood']] ?></div>
                    <div class="entry-info">
                        <div class="entry-name"><?= $row['name'] ?></div>
                        <div class="entry-note"><?= $row['note'] ? $row['note'] : 'No note' ?></div>
                    </div>
                    <div class="entry-date"><?= $row['created_at'] ?></div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No entries yet. <a href="add.php">Add one!</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
