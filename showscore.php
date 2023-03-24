<?php
session_start();
echo '<div id="showSCore">';
try {
    //$servername = "studentmysql.miun.se"; $username = "jojo2109"; $password = "svjyg9gn"; $dbname = "jojo2109"; $errors = array();
echo '<link rel="stylesheet" href="style.css" />';
    require_once 'db.php';

//$servername = "127.0.0.1";$username = "root";$password = "";$dbname = "jojo2109";
    $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
// Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forgindata = $conn->query('SELECT * FROM SCORE ORDER BY POINTS DESC LIMIT 10');


    //echo '<div id="Showwhile">';
    echo "Top 10 leaderboard 🏆".'<br>'.'<br>';
    $count=0;
    while ($row = $forgindata->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        if($count==1){
            echo "🥇"." ".$row['NAME']. " has: ". $row['POINTS']." points".'<br>'.'<br>';
        }elseif ($count==2){
            echo "🥈"." ".$row['NAME']. " has: ". $row['POINTS']." points".'<br>'.'<br>';
        }elseif ($count==3){
            echo "🥉"." ".$row['NAME']. " has: ". $row['POINTS']." points".'<br>'.'<br>';
        }else{
            echo "(".$count.") ".$row['NAME']. " has: ". $row['POINTS']." points".'<br>'.'<br>';
        }
    }
    //echo '</div>';

    $data3 = $conn->query('SELECT * FROM SCORE');

    while($row2 = $data3->fetch(PDO::FETCH_ASSOC)) {
        //echo '<h1 id="YOURSCORE">';
        if($_SESSION["id"]==$row2['ID']) {
            echo '<br>' . '<br>' . "You have " . $row2['POINTS'] . " points️";
        }
    }
    //echo '</h1>';
    echo '<button type="button" class="return" id="return" onclick="returntomain()">Return to quiz</button>';
    echo '<br>';
    echo'<button type="button" class="signout" id="signout" onclick="logout()">Sign out</button>';

    if(isset($_REQUEST["signout"])){
        unset($_SESSION["valid_user"]);
        session_destroy();
        header("Location: index.php");
        exit;
    }
    echo '<script>
    function logout() {
        window.location.href = "destroy.php";
    }
</script>';

    echo '<script>
        function returntomain() {
            window.location.href = "main.php";
        }
    </script>';
    echo '</div>';

// Close connection
    $conn = NULL;
}catch(PDOException $e){
    echo $e->getMessage();
}
