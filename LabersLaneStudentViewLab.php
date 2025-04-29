<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LabersLane.css">
    <title>LAB-ers Lane Laboratories</title>
</head>
<body>
    <?php include 'studenthomeview.php'; ?>

    <hr>

    <div class="ViewEquipment">
        <h2>VIEW CURRENTLY AVAILABLE LABORATORIES</h2>
        <table>
            <tr>
                <th>Laboratory Name</th>
                <th>Laboratory Condition</th>
                <th>Department Managing Laboratory</th>
                <th>Staff-IN-Charge</th>
            </tr>

            <?php
            $serverName = "localhost";
            $dbUserName = "root";
            $dbPassword = "";
            $dbName = "laberslanedb";

            $conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

            if($conn->connect_error){
                die("ERROR: Could not connect. " . $conn->connect_error);
            }

            $sql = "SELECT lab_name, lab_con, lab_dept, staff_id FROM laboratory";

            if($result = $conn->query($sql)){
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row['lab_name'] . "</td>";
                        echo "<td>" . $row['lab_con'] . "</td>";
                        echo "<td>" . $row['lab_dept'] . "</td>";
                        echo "<td>" . $row['staff_id'] . "</td>";
                        echo "</tr>";
                    }
                    $result->free();
                } else{
                    echo "<tr><td colspan='4'>No records found.</td></tr>";
                }
            } else{
                echo "ERROR: Could not able to execute $sql. " . $conn->error;
            }

            $conn->close();
            ?>
        </table>
    </div>

    <hr>

    <script src="LabersLane.js"></script>
</body>
</html>
