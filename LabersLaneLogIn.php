<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LabersLane.css">
    <title>LAB-ers Lane Log In</title>
</head>
<body>
    
    <div class="WebHead">   
        <h3>Log In</h3>
    </div>

    <?php
        if (isset($_GET["error"]) && $_GET["error"] == "wrongpassword") {
            echo "<p class='error-msg'>Incorrect password. Please try again.</p>";
        }
    ?>

    <form class="userSULI" action="includes/login.inc.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <br><br>
        <input type="password" name="pwd" placeholder="Password" required>
        <br><br>
        <button type="submit" name="submit">LOG IN</button>
    </form>

</body>
</html>
