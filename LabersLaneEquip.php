<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LabersLane.css">
    <title>LAB-ers Lane Equipment Management</title>
</head>
<body>
    <div class="WebHead">
        <h3>Equipment Management</h3>
    </div>

    <?php include 'header.php'; ?>

    <hr>

    <div class="content">
        <div class="ViewEquipments">
            <h2>VIEW ALL EQUIPMENT IN THE DATABASE</h2>
            <form method="post">
                <input type="text" id="searchBar" name="searchBar" placeholder="Search for equipment...">
                <button type="submit" name="searchSubmit">Search</button>
                <button type="submit" name="viewAllSubmit">View All</button>
            </form>
            <br>
            
            <?php
                require_once 'includes/dbc.inc.php';

                if (isset($_POST['searchSubmit']) || isset($_POST['viewAllSubmit'])) {
                    if (isset($_POST['searchSubmit'])) {
                        $search = $conn->real_escape_string($_POST['searchBar']);
                        $query = "SELECT e.equip_id, e.equip_name, e.equip_con, e.equip_sernum, 
                                  d.dept_name 
                                  FROM equipment e 
                                  LEFT JOIN department d ON e.dept_id = d.dept_id
                                  WHERE e.equip_name LIKE '%$search%'";
                    } else {
                        $query = "SELECT e.equip_id, e.equip_name, e.equip_con, e.equip_sernum, 
                                  d.dept_name 
                                  FROM equipment e 
                                  LEFT JOIN department d ON e.dept_id = d.dept_id";
                    }

                    $result = $conn->query($query);

                    if ($result) {
                        if ($result->num_rows > 0) {
                            echo "<table>";
                            echo "<tr><th>Equipment ID</th><th>Equipment Name</th><th>Equipment Condition</th><th>Equipment Serial Number</th><th>Department</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['equip_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['equip_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['equip_con']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['equip_sernum']) . "</td>";
                                echo "<td>" . (isset($row['dept_name']) ? htmlspecialchars($row['dept_name']) : 'N/A') . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "No equipment found in the database.";
                        }
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
            ?>
        </div>

        <hr>

        <div class="Add">
            <h2>ADD EQUIPMENT TO THE DATABASE</h2>
            <form action="includes/addequip.inc.php" method="post">
                <label for="EquipName">Equipment Name:</label><br>
                <input type="text" id="EquipName" name="EquipName" required><br>
                <label for="EquipSN">Equipment Serial Number:</label><br>
                <input type="text" id="EquipSN" name="EquipSN" required><br>
                <label for="EquipCon">Equipment Condition:</label><br>
                <select name="EquipCon" id="EquipCon" required>
                    <option value="Good">Good Condition</option>
                    <option value="Requires Calibration">Requires Calibration</option>
                    <option value="Defective">Defective Condition</option>
                    <option value="Under Repair/Maintenance">Under Repair/Maintenance</option>
                </select><br><br>
                <label for="DeptName">Department Managing Equipment:</label><br>
                    <select name="DeptName" id="DeptName" required>
                        <option value="CAS Chemistry">College of Arts and Sciences - [CHEMISTRY]</option>
                        <option value="CAS Physics">College of Arts and Sciences - [PHYSICS]</option>
                        <option value="CAS Biology">College of Arts and Sciences - [BIOLOGY]</option>
                        <option value="SOTECH Food Technology">School of Technology - [FOOD TECHNOLOGY]</option>
                        <option value="SOTECH Chemical Engineering">School of Technology - [CHEMICAL ENGINEERING]</option>
                        <option value="CFOS">College of Fisheries and Ocean Sciences</option>
                    </select><br><br>
                <button type="submit" name="submit">Add Equipment to Database</button>
            </form>
        </div>


        <br><br><br>

        <div class="Remove">
            <h2>REMOVE EQUIPMENT FROM THE DATABASE</h2>
            <form action="includes/removeequip.inc.php" method="post">
                <label for="equipName">Equipment Name:</label><br>
                <input type="text" id="equipName" name="equipName" required><br><br>
                <button type="submit" name="submit">Remove Equipment from Database</button>
            </form>
        </div>

        <br><br><br>

        <div class="Update">
            <h2>UPDATE EQUIPMENT CONDITION IN THE DATABASE</h2>
            <form action="includes/updateequip.inc.php" method="post">
                <label for="EquipName">Equipment Name:</label><br>
                <input type="text" id="EquipName" name="EquipName" required><br><br>
                <label for="EquipCon">Equipment Condition:</label><br>
                <select name="EquipCon" id="EquipCon" required>
                    <option value="Good">Good Condition</option>
                    <option value="Requires Calibration">Requires Calibration</option>
                    <option value="Defective">Defective Condition</option>
                    <option value="Under Repair/Maintenance">Under Repair/Maintenance</option>
                </select><br><br>
                <button type="submit" name="submit">Update Equipment Condition in Database</button>
            </form>
        </div>

        <hr>
    </div>

    <script src="LabersLane.js"></script>
</body>
</html>
