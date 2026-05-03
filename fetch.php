<?php
require "connection.php";

if (isset($_POST['fetch_user'])) {

    $user_id = $_POST['user_id'];

    $sql = "SELECT 
        user.username AS username,
        project.Pname AS project_name,
        task.Tname AS task_name
    FROM user
    INNER JOIN project ON user.userID = project.userid
    INNER JOIN task ON project.Pid = task.Pid
    WHERE user.userID = ?
    ORDER BY project.Pname ASC";

    $stmt = $connection->prepare($sql);
    $stmt->execute([$user_id]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        $output = "";
        foreach ($results as $row) {
            $output .= "User: {$row['username']} |
                        Project: {$row['project_name']} |
                        Task: {$row['task_name']} <br>";
        }
        echo $output;
    } else {
        echo "No data found for this ID.";
    }
}
?>