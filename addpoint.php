<?php
session_start();
try {
    require_once 'db.php';
    //$servername = "127.0.0.1";$username = "root";$password = "";$dbname = "jojo2109";
    $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //$data = $conn->query('UPDATE POINTS FROM SCORE WHERE ID==$_SESSION["valid_user"] SET POINTS=:score');
    $stmt = $conn->prepare('UPDATE SCORE SET POINTS = :score WHERE ID = :id');

    $data2 = $conn->prepare('SELECT POINTS, ID FROM SCORE WHERE ID = :id');
    $data2->bindParam(':id', $_SESSION["id"]);
    $data2->execute();
    $row = $data2->fetch(PDO::FETCH_ASSOC);

    $scor =$row['POINTS'];
    $score =$scor+1;
    $stmt->bindParam(':id', $_SESSION["id"]);
    $stmt->bindParam(':score', $score);


    // Execute the UPDATE statement
    $stmt->execute();
//var_dump($score);
// Close connection
    $conn = null;
    header('Location: main.php');
    exit();
}catch (PDOException $e) {
    echo $e->getMessage();
}