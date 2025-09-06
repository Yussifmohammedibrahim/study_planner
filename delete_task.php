<?php
// Include database configuration
include 'config.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if ID parameter is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Task deleted successfully';
    } else {
        $response['message'] = 'Error deleting task: ' . $stmt->error;
    }
    
    $stmt->close();
} else {
    $response['message'] = 'No task ID provided';
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>