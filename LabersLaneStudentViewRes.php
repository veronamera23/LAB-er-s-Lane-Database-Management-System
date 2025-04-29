<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LabersLane.css">
    <title>LAB-ers Lane Resources</title>
</head>
<body>

    <?php include 'studenthomeview.php'; ?>

    <hr>

    <div class="ViewEquipment">
        <h2>VIEW CURRENTLY AVAILABLE RESOURCES</h2>
        <table>
            <tr>
                <th>Resource Name</th>
                <th>Resource Type</th>
                <th>Resource Availability Count</th>
                <th>Department Managing Resource</th>
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

            $sql = "SELECT resource.res_name, resource.res_type, resource.res_avail, department.Dept_Name 
                    FROM resource
                    JOIN department ON resource.Dept_ID = department.Dept_ID";

            if($result = $conn->query($sql)){
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row['res_name'] . "</td>";
                        echo "<td>" . $row['res_type'] . "</td>";
                        echo "<td>" . $row['res_avail'] . "</td>";
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
