<?php
require "connection.php";

if (isset($_POST['submit'])){
    $projname=$_POST['project_name'];
    $userID=1;
    $taskname=$_POST['task_name'];
    $description=$_POST['description'];
    $startdate=$_POST['start_date'];
    $enddate=$_POST['end_date'];
    $priority=$_POST['priority'];
    $status=$_POST['status'];
    $archived=$_POST['archived'];
    $category=$_POST['category'];
    $projID=1;


if(empty($projname)){
    echo "project name is required";
    exit;
}

if(empty($userID)){
    echo "user ID is required";
    exit;
}

if(empty($taskname)){
    echo "task name is required";
    exit;
}
if(empty($projID)){
    echo "project ID is required";
    exit;
}

$statementP=$connection->prepare("INSERT INTO project(Pname,userid) values(?,?)");
$statementP->execute([$projname,$userID]);
echo " project inserted successfully";


$stmt_task = $connection->prepare("INSERT INTO task(Tname,description,startDate,endDate,priority,status,archived,category,Pid) VALUES (?,?, ?, ?, ?,?,?,?,?)");
$stmt_task->execute([$taskname, $description, $startdate, $enddate, $priority, $status, $archived, $category,$projID]);
echo " task inserted successfully";

}
?>