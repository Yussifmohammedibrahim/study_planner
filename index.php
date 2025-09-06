<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Study Planner</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #eeeaf2ff 0%, #d2d6dcff 100%);
            color: #333;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            padding: 40px;
            overflow: hidden;
        }

        header {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        h1 {
            color: #2c3e50;
            font-size: 2.8rem;
            margin-bottom: 10px;
            font-weight: 700;
            background: linear-gradient(to right, #3498db, #2c3e50);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 1.2rem;  
            font-weight: 400;
        }

        .form-container {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        input, textarea, select {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.2);
            transform: translateY(-2px);
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        button {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            display: block;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.5);
        }

        button:active {
            transform: translateY(1px);
        }

        .tasks-container {
            margin-top: 50px;
        }

        .tasks-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .tasks-title {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 700;
        }

        .task-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .task {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #3498db;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .task:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .task::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #3498db, #2980b9);
        }

        .task h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .task p {
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .task-dates {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .date-label {
            font-weight: 600;
            color: #7f8c8d;
        }

        .start-date {
            color: #27ae60;
            font-weight: 500;
        }

        .end-date {
            color: #e74c3c;
            font-weight: 500;
        }

        .task-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            align-items: center;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .days-left {
            font-weight: 600;
            color: #f39c12;
            font-size: 1rem;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: none;
            animation: fadeIn 0.5s;
            border-left: 5px solid #28a745;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: none;
            animation: fadeIn 0.5s;
            border-left: 5px solid #dc3545;
        }

        .no-tasks {
            text-align: center;
            padding: 50px;
            color: #7f8c8d;
            font-style: italic;
            grid-column: 1 / -1;
            font-size: 1.2rem;
        }

        .export-btn {
            background: linear-gradient(to right, #27ae60, #2ecc71);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3);
            margin-left: 15px;
        }

        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(39, 174, 96, 0.4);
        }

        #taskCount {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .container {
                padding: 30px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .form-group.full-width {
                grid-column: span 1;
            }
            
            .task-grid {
                grid-template-columns: 1fr;
            }
            
            .tasks-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            h1 {
                font-size: 2.3rem;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }
            
            .container {
                padding: 25px 20px;
                border-radius: 15px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .tasks-title {
                font-size: 1.7rem;
            }
            
            .task {
                padding: 20px;
            }
            
            button {
                padding: 14px 20px;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3498db, #2980b9);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2980b9, #2573a7);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Student Study Planner</h1>
            <p class="subtitle">Plan your study tasks with start and end dates</p>
        </header>
        
        <div class="success-message" id="successMessage">
            Task added successfully!
        </div>
        
        <div class="error-message" id="errorMessage">
            Error adding task. Please try again.
        </div>
        
        <div class="form-container">
            <form id="plannerForm" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="e.g. Mathematics" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date">Due Date</label>
                        <input type="date" id="end_date" name="end_date" required>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="task">Task Description</label>
                        <textarea id="task" name="task" placeholder="Describe the study task in detail..." required></textarea>
                    </div>
                </div>
                
                <button type="submit" name="add_to_planner">Add To Planner</button>
            </form>
        </div>
        
        <div class="tasks-container">
            <div class="tasks-header">
                <h2 class="tasks-title">Your Study Tasks</h2>
                <div>
                    <span id="taskCount">0 tasks</span>
                    <button onclick="exportToCSV()" style="margin-left: 15px; padding: 8px 15px; background: #27ae60; color: white; border: none; border-radius: 5px; cursor: pointer;">Export to CSV</button>
                </div>
            </div>
            
            <div class="task-grid" id="taskList">
                <!-- Tasks will be loaded here via JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Set default date values to today and 7 days from today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);
            
            document.getElementById('start_date').valueAsDate = today;
            document.getElementById('end_date').valueAsDate = nextWeek;
            
            // Load tasks on page load
            loadTasks();
        });
        
        document.getElementById('plannerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple client-side validation
            const subject = document.getElementById('subject').value;
            const task = document.getElementById('task').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (!subject || !task || !startDate || !endDate) {
                alert('Please fill in all fields');
                return;
            }
            
            if (startDate > endDate) {
                alert('End date must be after start date');
                return;
            }
            
            // Submit the form via AJAX
            const formData = new FormData(this);
            
            fetch('save_task.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successMessage').style.display = 'block';
                    document.getElementById('errorMessage').style.display = 'none';
                    
                    // Clear form
                    this.reset();
                    
                    // Set default dates again
                    const today = new Date();
                    const nextWeek = new Date();
                    nextWeek.setDate(today.getDate() + 7);
                    
                    document.getElementById('start_date').valueAsDate = today;
                    document.getElementById('end_date').valueAsDate = nextWeek;
                    
                    // Reload tasks
                    loadTasks();
                    
                    // Hide success message after 3 seconds
                    setTimeout(() => {
                        document.getElementById('successMessage').style.display = 'none';
                    }, 3000);
                } else {
                    document.getElementById('errorMessage').textContent = 'Error: ' + data.message;
                    document.getElementById('errorMessage').style.display = 'block';
                    document.getElementById('successMessage').style.display = 'none';
                    
                    // Hide error message after 5 seconds
                    setTimeout(() => {
                        document.getElementById('errorMessage').style.display = 'none';
                    }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('errorMessage').textContent = 'Network error. Please try again.';
                document.getElementById('errorMessage').style.display = 'block';
                document.getElementById('successMessage').style.display = 'none';
            });
        });
        
        function loadTasks() {
            fetch('display_tasks.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('taskList').innerHTML = data;
                    // Update task count
                    const taskCount = document.querySelectorAll('.task').length;
                    document.getElementById('taskCount').textContent = taskCount + ' tasks';
                });
        }
        
        function deleteTask(id) {
            if (confirm('Are you sure you want to delete this task?')) {
                fetch('delete_task.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadTasks();
                        } else {
                            alert('Error deleting task: ' + data.message);
                        }
                    });
            }
        }
        
        function exportToCSV() {
            window.location.href = 'export_tasks.php';
        }
    </script>
</body>
</html>