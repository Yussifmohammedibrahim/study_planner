<?php
// Include database configuration
include 'config.php';

// Initialize variables
$task_html = '';
$task_count = 0;

// Fetch tasks from database
$sql = "SELECT id, subject, task, start_date, end_date, created_at FROM tasks ORDER BY start_date ASC, end_date ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $task_count++;
        
        // Calculate days left
        $start_date = new DateTime($row['start_date']);
        $end_date = new DateTime($row['end_date']);
        $today = new DateTime();
        
        if ($end_date < $today) {
            $days_left = 'Completed';
        } else if ($start_date > $today) {
            $interval = $today->diff($start_date);
            $days_left = 'Starts in ' . $interval->days . ' days';
        } else {
            $interval = $today->diff($end_date);
            $days_left = $interval->days . ' days left';
        }
        
        $task_html .= '
        <div class="task">
            <h3>' . htmlspecialchars($row['subject']) . '</h3>
            <p>' . htmlspecialchars($row['task']) . '</p>
            <div class="task-dates">
                <div>
                    <span class="date-label">Start:</span>
                    <span class="start-date">' . htmlspecialchars($row['start_date']) . '</span>
                </div>
                <div>
                    <span class="date-label">End:</span>
                    <span class="end-date">' . htmlspecialchars($row['end_date']) . '</span>
                </div>
            </div>
            <div class="task-actions">
                <span class="days-left">' . $days_left . '</span>
                <button class="delete-btn" onclick="deleteTask(' . $row['id'] . ')">Delete</button>
            </div>
        </div>';
    }
} else {
    $task_html = '<div class="no-tasks">No tasks yet. Add your first task above!</div>';
}

// Close connection
$conn->close();

// If called directly, output the HTML
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    echo $task_html;
    exit;
}
?>