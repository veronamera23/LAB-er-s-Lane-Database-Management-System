<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LabersLane.css">
    <title>LAB-ers Lane Resources</title>
</head>
<body>
    <div class="WebHead">
        <h3>Resources Management</h3>
    </div>

    <?php include 'header.php'; ?>

    <hr>

    <div class="content">
        <div class="ViewResources">
            <h2>VIEW ALL RESOURCES IN THE DATABASE</h2>
            <form method="post">
                <input type="text" id="searchBar" name="searchBar" placeholder="Search for resources...">
                <button type="submit" name="searchSubmit">Search</button>
                <button type="submit" name="viewAllSubmit">View All</button>
            </form>
            <br>
            
            <?php
                require_once 'includes/dbc.inc.php';

                if (isset($_POST['searchSubmit']) || isset($_POST['viewAllSubmit'])) {
                    if (isset($_POST['searchSubmit'])) {
                        $search = $_POST['searchBar'];
                        $query = "SELECT r.Res_ID, r.Res_Name, r.Res_Type, r.Res_Avail, 
                                  CASE 
                                      WHEN r.Res_Avail > 0 THEN 'Available' 
                                      ELSE 'Unavailable' 
                                  END AS Availability, 
                                  d.Dept_Name 
                                  FROM resource r 
                                  LEFT JOIN department d ON r.Dept_ID = d.Dept_ID
                                  WHERE Res_Name LIKE '%$search%'";
                    } else {
                        $query = "SELECT r.Res_ID, r.Res_Name, r.Res_Type, r.Res_Avail, 
                                  CASE 
                                      WHEN r.Res_Avail > 0 THEN 'Available' 
                                      ELSE 'Unavailable' 
                                  END AS Availability, 
                                  d.Dept_Name 
                                  FROM resource r 
                                  LEFT JOIN department d ON r.Dept_ID = d.Dept_ID";
                    }

                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        echo "<table>";
                        echo "<tr><th>Resource ID</th><th>Resource Name</th><th>Resource Type</th><th>Resource Availability</th><th>Department</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['Res_ID'] . "</td>";
                            echo "<td>" . $row['Res_Name'] . "</td>";
                            echo "<td>" . $row['Res_Type'] . "</td>";
                            echo "<td>" . $row['Res_Avail'] . "</td>";
                            echo "<td>" . (isset($row['Dept_Name']) ? $row['Dept_Name'] : 'N/A') . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No resources found in the database.";
                    }
                }
            ?>
        </div>

        <hr>

        <div class="Add">
            <h2>ADD A RESOURCE TO THE DATABASE</h2>
            <form action="includes/addres.inc.php" method="post">
                <label for="ResName">Resource Name:</label><br>
                <input type="text" id="ResName" name="ResName" required><br>
                <label for="ResType">Resource Type:</label><br>
                <input type="text" id="ResType" name="ResType" required><br>
                <label for="ResAvail">Resource Availability (Count):</label><br>
                <input type="number" id="ResAvail" name="ResAvail" required><br>
                <label for="DeptName">Department Managing Resource:</label><br>
                <select name="DeptName" id="DeptName" required>
                    <option value="CAS Chemistry">College of Arts and Sciences - [CHEMISTRY]</option>
                    <option value="CAS Physics">College of Arts and Sciences - [PHYSICS]</option>
                    <option value="CAS Biology">College of Arts and Sciences - [BIOLOGY]</option>
                    <option value="SOTECH Food Technology">School of Technology - [FOOD TECHNOLOGY]</option>
                    <option value="SOTECH Chemical Engineering">School of Technology - [CHEMICAL ENGINEERING]</option>
                    <option value="CFOS">College of Fisheries and Ocean Sciences</option>
                </select><br><br>
                <button type="submit" name="submit">Add Resource to Database</button>
            </form>
        </div>

        <br><br><br>

        <div class="Remove">
            <h2>REMOVE A RESOURCE FROM THE DATABASE</h2>
            <form action="includes/removeres.inc.php" method="post">
                <label for="ResName">Resource Name:</label><br>
                <input type="text" id="ResName" name="ResName" required><br><br>
                <button type="submit" name="submit">Remove Resource from Database</button>
            </form>
        </div>

        <br><br><br>

        <div class="Update">
            <h2>UPDATE RESOURCE AVAILABILITY IN THE DATABASE</h2>
            <form action="includes/updateres.inc.php" method="post">
                <label for="ResName">Resource Name:</label><br>
                <input type="text" id="ResName" name="ResName" required><br><br>
                <label for="ResAvail">Resource Availability (Count):</label><br>
                <input type="number" id="ResAvail" name="ResAvail" required><br><br>
                <button type="submit" name="submit">Update Resource Availability in Database</button>
            </form>
        </div>

        <hr>
    </div>

    <script src="LabersLane.js"></script>
</body>
</html>