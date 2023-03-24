<?php
session_start();
if($_SESSION["valid_user"] != session_id()){
header("Location: index.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multiplication App</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body id="body2">
<form class="form" id="form">
    <h4 class="score" id="score"></h4>
    <h1 id="question">What is 1 multiply by 1?</h1>
    <input
            type="text"
            class="input"
            id="input"
            placeholder="Enter your answer"
            autofocus
            autocomplete="off"
                />
    <button type="submit" class="btn">Submit</button>
    <button type="button" class="scorebtn" id="scorebtn">Leaderboard</button>
    <button type="button" class="signout" id="signout" onclick="logout()">Sign out</button>

</form>
<script src="js/main.js"></script>
<script>
    function logout() {
        window.location.href = "destroy.php";
    }
</script>
</body>
</html>

