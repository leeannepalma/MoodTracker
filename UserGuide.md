# User Guide

## Accessing the Application

Open your browser and navigate to:

http://<raspberry-pi-ip>/mood-tracker/index.php

## Pages Overview

### Home Page (index.php)

The home page is your main hub. It includes:

- **Welcome Banner** — a greeting message with the app tagline
- **Mood of the Day** — shows the average mood logged today with an emoji
- **Total Entries** — how many mood entries have been logged overall
- **Team Members** — number of active members
- **Daily Quote** — a motivational wellness quote that changes each day
- **Quick Add Button** — click "How are you feeling today?" to quickly log your mood
- **Entries Table** — view all mood entries with emoji badges, notes, dates, and action buttons to edit or delete

### Add Entry (add.php)

To log a new mood entry:

1. Click "Add Entry" in the navigation bar or the quick add button on the home page
2. Select your name from the dropdown menu
3. Choose your mood rating (1 to 5) with emoji indicators
4. Write an optional note about how you are feeling
5. Select the date
6. Click "Submit"

### Dashboard (dashboard.php)

The dashboard provides an overview of all mood data:

- **Stat Cards** — total entries, total members, average mood, and most active member
- **Mood Distribution Chart** — colored bar chart showing how many entries for each mood level
- **Mood Activity Heatmap** — a GitHub-style grid for each member showing their mood entries over the last 12 weeks, color-coded from red (very bad) to green (very good)
- **Mindfulness Corner** — three embedded YouTube videos for guided meditation, breathing exercises, and relaxation
- **Recent Entries** — the last 5 mood entries with emoji, member name, note, and date

### Edit Entry (edit.php)

To edit an existing entry:

1. Go to the Home page
2. Find the entry you want to change
3. Click "Edit"
4. Update the mood, note, or date
5. Click "Update"

### Delete Entry (delete.php)

To delete an entry:

1. Go to the Home page
2. Find the entry you want to remove
3. Click "Delete"
4. Confirm the deletion

### Members Page (members.php)

View all team members with their student IDs. Click "View" to see each member's personal introduction page.

## Mood Scale

| Rating | Emoji | Meaning |
|--------|-------|---------|
| 1 | 😢 | Very Bad |
| 2 | 😕 | Bad |
| 3 | 😐 | Neutral |
| 4 | 😊 | Good |
| 5 | 😁 | Very Good |

## Mood Heatmap Colors

| Color | Meaning |
|-------|---------|
| Gray | No entry |
| Red | Very Bad (1) |
| Orange | Bad (2) |
| Yellow | Neutral (3) |
| Light Green | Good (4) |
| Dark Green | Very Good (5) |
