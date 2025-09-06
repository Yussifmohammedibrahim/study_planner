<?php
include 'config.php';

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="all_study_tasks_' . date('Y-m-d') . '.csv"');

// Create output stream
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, ['ID', 'Subject', 'Task Description', 'Start Date', 'End Date', 'Created At']);

// Fetch tasks from database
$sql = "SELECT * FROM tasks ORDER BY start_date ASC, end_date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($task = $result->fetch_assoc()) {
        fputcsv($output, [
            $task['id'],
            $task['subject'],
            $task['task'],
            $task['start_date'],
            $task['end_date'],
            $task['created_at']
        ]);
    }
}

fclose($output);
exit;
?>