<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizo - Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f7f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            margin: 0;
        }

        form, .results-container {
            background: #fff;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 500px;
        }

        h3 {
            color: #1a73e8;
            margin-top: 0;
            border-bottom: 2px solid #e8f0fe;
            padding-bottom: 10px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            font-size: 13px;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover { background-color: #1557b0; }

        .success-msg { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        .error-msg { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        .data-item { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        .data-item:last-child { border-bottom: none; }
        
        br { display: none; } 
    </style>
</head>
<body>

   <form METHOD="POST" action="insert.php">
    <h3> Add Project + Task</h3>
    
    <label>Project Name:</label> 
    <input type="text" name="project_name" required>
    
    <label>User ID:</label> 
    <input type="number" name="user_id" required>

    <hr style="margin-top: 20px; border: 0; border-top: 1px solid #eee;">

    <label>Task Name:</label> 
    <input type="text" name="task_name" required>

    <label>Description:</label> 
    <input type="text" name="description">

    <label>Start Date:</label> 
    <input type="date" name="start_date">

    <label>End Date:</label> 
    <input type="date" name="end_date">

    <label>Project ID :</label> 
    <input type="number" name="pid" required>

    <label>Priority:</label> 
    <select name="priority">
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
    </select>

    <label>Status:</label> 
    <select name="status">
        <option value="To Do">To Do</option>
        <option value="In Progress">In Progress</option>
        <option value="Done">Done</option>
    </select>

    <label>Category:</label> 
    <select name="category">
        <option value="Bug">Bug</option>
        <option value="Fix">Fix</option>
    </select>

    <label>Archived:</label>
    <select name="archived">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>

    <button type="submit" name="submit">Add Project + Task</button>
</form>

<form METHOD="POST" ACTION="fetch.php">
        <h3>Fetch User Data</h3>
        <label>User ID:</label> <input type="number" name="user_id" required>
        <button type="submit" name="fetch_user">Fetch Projects + Tasks</button>
    </form>

<form METHOD="POST" ACTION="filter.php">
        <h3>Filter Tasks by Priority</h3>
        <label>User ID:</label> <input type="number" name="user_id" required>
        <label>Priority:</label> 
        <select name="priority">
            <option>High</option><option>Medium</option><option>Low</option>
        </select>
        <button type="submit" name="filter">Filter Tasks</button>
    </form>
