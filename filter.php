<?php
require "connection.php";

if (isset($_POST["filter"])){
    $user_id=$_POST['user_id'];
    $priority=$_POST['priority'];

  

    $sql = "SELECT 
                user.username AS username,
                project.Pname AS project_name,
                task.Tname AS task_name,
                task.priority AS priority
            FROM user
            INNER JOIN project ON user.userID = project.userid
            INNER JOIN task ON project.Pid = task.Pid
            WHERE user.userID = ? 
              AND task.priority = ? 
              AND task.archived = 0
            ORDER BY project.Pname ASC";

    $stmt = $connection->prepare($sql);
    $stmt->execute([$user_id, $priority]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        $output = "";
        foreach ($results as $row) {
            $output .= "User: {$row['username']} | 
                        Project: {$row['project_name']} | 
                        Task: {$row['task_name']} | 
                        Priority: {$row['priority']} <br>";
        }
        echo $output;
    } else {
        echo "No active tasks found with this priority.";
    }
}
?>