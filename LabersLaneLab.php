<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LabersLane.css">
    <title>LAB-ers Lane Laboratory</title>
</head>
<body>
    <div class="WebHead">
        <h2>Laboratory Management</h2>
    </div>

    <?php include 'header.php'; ?>

    <hr>

    <div class="content">
        <div class="ViewLabs">
            <h2>VIEW ALL LABORATORIES IN THE DATABASE</h2>
            <form method="post">
                <input type="text" id="searchBar" name="searchBar" placeholder="Search for laboratories...">
                <button type="submit" name="searchSubmit">Search</button>
                <button type="submit" name="viewAllSubmit">View All</button>
            </form>
            <br>
            <?php
            require_once 'includes/dbc.inc.php';

            if (isset($_POST['searchSubmit']) || isset($_POST['viewAllSubmit'])) {
                if (isset($_POST['searchSubmit'])) {
                    $search = $_POST['searchBar'];
                    $query = "SELECT * FROM laboratory WHERE lab_name LIKE '%$search%'";
                } else {
                    $query = "SELECT * FROM laboratory";
                }

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Lab ID</th><th>Lab Name</th><th>Lab Condition</th><th>Lab Department</th><th>Staff ID</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Lab_ID'] . "</td>";
                        echo "<td>" . $row['Lab_Name'] . "</td>";
                        echo "<td>" . $row['Lab_Con'] . "</td>";
                        echo "<td>" . $row['Lab_Dept'] . "</td>";
                        echo "<td>" . $row['Staff_ID'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No laboratories found in the database.";
                }
            }
            ?>
        </div>

        <hr>

        <div class="Add">
            <h2>ADD A LABORATORY TO THE DATABASE</h2>
            <form action="includes/addlab.inc.php" method="post">
                <label for="LabName">Laboratory Name:</label><br>
                <input type="text" id="LabName" name="LabName"><br>
                <label for="LabCon">Laboratory Condition:</label><br>
                <select name="LabCon" id="LabCon">
                    <option value="Normal">Normal Operation</option>
                    <option value="Construction">Under Construction/Renovation</option>
                    <option value="Unsafe">Unsafe for Operation</option>
                    <option value="Health">Potential Health Hazards</option>
                </select><br><br>
                <label for="LabDept">Department Managing Laboratory:</label><br><br>
                <select name="LabDept" id="LabDept">
                    <option value="CAS Chem">College of Arts and Sciences - [CHEMISTRY]</option>
                    <option value="CAS Phy">College of Arts and Sciences - [PHYSICS]</option>
                    <option value="CAS Bio">College of Arts and Sciences - [BIOLOGY]</option>
                    <option value="SOTECH Food">School of Technology - [FOOD TECHNOLOGY]</option>
                    <option value="SOTECH Che">School of Technology - [CHEMICAL ENGINEERING]</option>
                    <option value="CFOS">College of Fisheries and Ocean Sciences</option>
                </select><br><br>
                <button type="submit" name="submit">ADD LABORATORY TO DATABASE</button>
            </form>
        </div>

        <br><br><br>

        <div class="Remove">
            <h2>REMOVE A LABORATORY FROM THE DATABASE</h2>
            <form action="includes/removelab.inc.php" method="post">
                <label for="LabName">Laboratory Name:</label><br>
                <input type="text" id="LabName" name="LabName"><br><br>
                <button type="submit" name="submit">Remove Laboratory from Database</button>
            </form>
        </div>

        <br><br><br>

        <div class="Update">
            <h2>UPDATE LABORATORY CONDITION IN THE DATABASE</h2>
            <form action="includes/updatelab.inc.php" method="post">
                <label for="LabName">Laboratory Name:</label><br>
                <input type="text" id="LabName" name="LabName"><br><br>
                <label for="LabCon">Laboratory Condition:</label><br>
                <select name="LabCon" id="LabCon">
                    <option value="Normal Operation - Ongoing Classes">Normal Operation</option>
                    <option value="Normal Operation - No Class">Normal Operation</option>
                    <option value="Under Construction/Renovation">Under Construction/Renovation</option>
                    <option value="Unsafe for Operation">Unsafe for Operation</option>
                    <option value="Potential Health Hazards">Potential Health Hazards</option>
                </select><br><br>
                <button type="submit" name="submit">Update Laboratory Condition in Database</button>
            </form>
        </div>

        <hr>
    </div>
</body>
</html>
