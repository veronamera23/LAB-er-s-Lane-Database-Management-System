<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../LabersLane.css">
    <title>Signup Successful</title>
</head>
<body>

<div class="WebHead">   
    <h3>Sign Up Successful</h3>
</div>

<div class="success-message">
    <?php
    if (isset($_GET['userId'])) {
        $userId = htmlspecialchars($_GET['userId']);
        echo "<p>Your account has been created successfully. Your user ID is: <strong>$userId</strong></p>";
        echo "<p><a href='login.php'>Click here to log in</a></p>";
    } else {
        echo "<p>Something went wrong. Please try again.</p>";
    }
    ?>
</div>

</body>
</html>
