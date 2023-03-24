<?php
session_start();
if(isset($_REQUEST['go'])) {
    try {
        //$servername = "studentmysql.miun.se"; $username = "jojo2109"; $password = "svjyg9gn"; $dbname = "jojo2109";
        $errors = array();
    require_once 'db.php';
        //$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "jojo2109";
        $errors = array();
        $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data = $conn->query('SELECT * FROM LOGIN');
        //while loopen dår igenom hela databasen för att se om det finns matchande användarnamn och lösenord som
        // personen har angivit.
        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
            if ($row['NAME'] == $_REQUEST['user'] && $row['PASSWORD'] == $_REQUEST['pass']) {
                $errors[] = "En matchning hittades";
                //spara id för personen som loggat in.
                $_SESSION["id"]=$row['ID'];
            }
        }
        //om det inte finns några matchande namn eller email läggs informationen in i databasen.
        if(count($errors)!=0){
            $_SESSION["valid_user"] = session_id();
            // Close connection
            $conn = null;
            unset($_REQUEST['go']);
            header("Location: main.php");
            exit();
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body id="body1">

<form id="loginform" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
    <p id="yourName">Your username
        <label id="namel">
            <input type="text" name="user" id="user" autocomplete="off" placeholder="Username"/>
        </label></p>
    <p id="yourAge">Your password
        <label id="passl">
            <input type="password" name="pass" id="pass" placeholder="Password" >
        </label></p>
    <input type="submit" name="go" id="go" value="Sign in">
    <p>Not a member?
    <a href="register.php">Sign up</a></p>
</form>

<script>
    // Create eventlistener for 'formid' submit to check for empty fields
    document.getElementById("formid").addEventListener("submit", (e) => {
        if(document.getElementById("user").value == "" || document.getElementById("pass").value == ""){
            e.preventDefault();
            return false;
        }
        return true;
    })
</script>
</body>
</html>
