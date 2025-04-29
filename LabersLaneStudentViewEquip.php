<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LabersLane.css">
    <title>LAB-ers Lane Equipment</title>
</head>
<body>

    <?php include 'studenthomeview.php'; ?>

    <hr>

    <div class="ViewEquipment">
        <h2>VIEW CURRENTLY AVAILABLE EQUIPMENT</h2>
        <table>
            <tr>
                <th>Equipment Name</th>
                <th>Condition</th>
                <th>Serial Number</th>
                <th>Department Managing Equipment</th>
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

            $sql = "SELECT equipment.Equip_Name, equipment.Equip_Con, equipment.Equip_SerNum, department.Dept_Name 
                    FROM equipment 
                    JOIN department ON equipment.Dept_id = department.Dept_id";

            if($result = $conn->query($sql)){
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row['Equip_Name'] . "</td>";
                        echo "<td>" . $row['Equip_Con'] . "</td>";
                        echo "<td>" . (isset($row['Equip_SerNum']) ? $row['Equip_SerNum'] : "N/A") . "</td>";
                        echo "<td>" . (isset($row['Dept_Name']) ? $row['Dept_Name'] : "N/A") . "</td>";
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
