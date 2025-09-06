<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
include 'config.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if it's a POST request and the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $task = isset($_POST['task']) ? trim($_POST['task']) : '';
    $start_date = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
    $end_date = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
    
    // Validate that all fields are filled
    if (empty($subject) || empty($task) || empty($start_date) || empty($end_date)) {
        $response['message'] = 'All fields are required';
    } 
    // Validate dates
    elseif ($start_date > $end_date) {
        $response['message'] = 'End date must be after start date';
    } 
    // If validation passes, proceed with database insertion
    else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO tasks (subject, task, start_date, end_date) VALUES (?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssss", $subject, $task, $start_date, $end_date);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Save to CSV file
                if (saveToCSV($subject, $task, $start_date, $end_date)) {
                    $response['success'] = true;
                    $response['message'] = 'Task added successfully and saved to CSV';
                } else {
                    $response['success'] = true;
                    $response['message'] = 'Task added to database but failed to save to CSV';
                }
            } else {
                $response['message'] = 'Database error: ' . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $response['message'] = 'Database preparation error: ' . $conn->error;
        }
    }
} else {
    $response['message'] = 'Invalid request method. Please submit the form.';
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Function to save task to CSV
function saveToCSV($subject, $task, $start_date, $end_date) {
    $filePath = 'study_tasks.csv';
    
    try {
        // Check if file exists to determine if we need headers
        $fileExists = file_exists($filePath);
        
        // Open file for appending
        $file = fopen($filePath, 'a');
        
        if ($file === false) {
            error_log("Cannot open file: $filePath");
            return false;
        }
        
        // Add headers if file doesn't exist
        if (!$fileExists) {
            fputcsv($file, ['Subject', 'Task Description', 'Start Date', 'End Date', 'Added Date']);
        }
        
        // Prepare data row
        $data = [
            $subject,
            $task,
            $start_date,
            $end_date,
            date('Y-m-d H:i:s')
        ];
        
        // Add data to CSV
        fputcsv($file, $data);
        
        // Close file
        fclose($file);
        
        return true;
    } catch (Exception $e) {
        error_log("Error saving to CSV: " . $e->getMessage());
        return false;
    }
}
?>