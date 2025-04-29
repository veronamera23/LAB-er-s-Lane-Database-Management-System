<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Success</title>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('userId');
            if (userId) {
                alert('Your account has been created. Your user ID is: ' + userId);
                window.location.href = 'LabersLaneSignUp.php';
            } else {
                alert('Error: User ID not found.');
                window.location.href = 'LabersLaneSignUp.php';
            }
        };
    </script>
</head>
<body>
</body>
</html>
