<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Credentials</title>
</head>
<body>

    <h2>New User Credentials</h2>

    <?php
    $userId = $_GET["userID"] ?? "";
    $name = $_GET["name"] ?? "";
    $role = $_GET["role"] ?? "";

    if ($userId !== "" && $name !== "" && $role !== "") {
        echo "<p><strong>User ID:</strong> $userId</p>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Role:</strong> $role</p>";
        echo "<p>Your account has been created successfully.</p>";
        echo "<p>Click <a href='../LabersLaneLogin.php'>here</a> to login.</p>";
    } else {
        echo "<p>Invalid user data.</p>";
    }
    ?>

</body>
</html>
