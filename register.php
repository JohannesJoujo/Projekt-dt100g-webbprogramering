<?php
session_start();
if(isset($_REQUEST['goo'])) {
    if ($_REQUEST['Pass'] == $_REQUEST['Pass2'] && $_REQUEST['Pass']!="") {
        try {
            //$servername = "studentmysql.miun.se"; $username = "jojo2109"; $password = "svjyg9gn"; $dbname = "jojo2109";
            $errors = array();
            require_once 'db.php';
            //$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "jojo2109";$errors=array();
            $matching = array();
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            // Set PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $data = $conn->query('SELECT * FROM LOGIN');
            $forgindata = $conn->query('SELECT * FROM SCORE');
            $stmt = $conn->prepare('INSERT INTO LOGIN (NAME, PASSWORD, EMAIL) VALUES (:NAME, :PASSWORD, :EMAIL)');
            $score = $conn->prepare('INSERT INTO SCORE (ID,POINTS,NAME) VALUES (:id, :POINTS,:NAME)');
            //while loopen dår igenom hela databasen för att se om det finns matchande användarnamn eller mail som
            // personen har angivit.
            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                if ($row['NAME'] == $_REQUEST['User'] || $row['EMAIL'] == $_REQUEST['email']) {
                    $errors[] = "Finns redan i databasen";
                }
            }


            //om det inte finns några matchande namn eller email läggs informationen in i databasen.
            if (count($errors) == 0) {
                $new_user = $_REQUEST['User'];
                $new_password = $_REQUEST['Pass'];
                $new_email = $_REQUEST['email'];

                // Prepare sql and bind parameters for LOGIN
                $stmt->bindParam(':NAME', $new_user);
                $stmt->bindParam(':PASSWORD', $new_password);
                $stmt->bindParam(':EMAIL', $new_email);
                $stmt->execute();

            } else {
                header("Location: register.php");
                exit();
            }

            $data2 = $conn->query('SELECT * FROM LOGIN');
            while ($row2 = $data2->fetch(PDO::FETCH_ASSOC)) {
                $forginrow = $forgindata->fetch(PDO::FETCH_ASSOC);
                if ($row2['ID'] == $forginrow['ID']) {
                    $matching[] = "Finns redan i databasen";
                } else {
                    $new_id = $row2['ID'];
                    $new_points = 0;
                    $new_name = $row2['NAME'];
                    // Prepare sql and bind parameters for SCORE
                    $score->bindParam(':id', $new_id);
                    $score->bindParam(':POINTS', $new_points);
                    $score->bindParam(':NAME', $new_name);
                    $score->execute();
                }
            }

            // Close connection
            $conn = null;
            unset($_REQUEST['goo']);
            header('Location: index.php');
            exit();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" type="text/css">

    <title>Document</title>
</head>
<body id="body3">
<form id="form2" method="post">
    <p id="YourName">Create username
        <label id="Namel">
            <input type="text" name="User" id="User" autocomplete="off" placeholder="Username"/>
        </label></p>
    <p id="yourAge">Create password
        <label id="Passl">
            <input type="password" name="Pass" id="Pass" placeholder="Password" >
        </label></p>
        <p>Repeat password
        <label id="Passl2">
            <input type="password" name="Pass2" id="Pass2" placeholder="Password" >
        </label></p>
    <p id="yourEmail"> Your E-mail
    <label id="Email">
        <input type="email" name="email" id="email" placeholder="E-mail" >
    </label></p>
    <input type="submit" name="goo" id="goo" onclick="check()" value="Create account">
    <p>
        Already a member? <a href="index.php">Sign in</a>
    </p>
</form>

<script>
    function check(){
    // Create eventlistener for 'formid' submit to check for empty fields
        if(document.getElementById("User").value == "" || document.getElementById("Pass").value == ""
            ||document.getElementById("Pass2").value != document.getElementById("Pass").value){
            {
                window.alert("Wrong input!");
                return false;
        }
        }
        return true;
    }

</script>
</body>
</html>

