<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LLStudentuiLabersLaneStudentUI.css">
    <title>Lab Scheduler</title>
</head>
<body>
    <div class="WebHead">
        <h2>Schedule Laboratory</h2>
    </div>

    <?php include 'studenthomeview.php'; ?>

            <center><div class="ViewLabs"><br><br>
                <h2>VIEW ALL LABORATORIES</h2>
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
        </center>

    <div class="scheduler content">
        <h2>Lab Scheduler</h2>
        <form action="includes/sched.inc.php" method="post">
            <label for="dept_prefix">Department:</label>
            <select id="dept_prefix" name="dept_prefix" required>
                <option value="">Select a department</option>
                <option value="CAS Chemistry">CAS Chemistry</option>
                <option value="CAS Physics">CAS Physics</option>
                <option value="CAS Biology">CAS Biology</option>
                <option value="SOTECH Food Technology">SOTECH Food Technology</option>
                <option value="SOTECH Chemical Engineering">SOTECH Chemical Engineering</option>
                <option value="CFOS">CFOS</option>
            </select><br><br>
            <label for="lab">Lab Name:</label>
            <input type="text" id="lab" name="lab" required><br><br>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required><br><br>
            <label for="start_time">Start Time:</label>
            <input type="time" id="start_time" name="start_time" required><br><br>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required><br><br>
            <label for="end_time">End Time:</label>
            <input type="time" id="end_time" name="end_time" required><br><br>
            <input type="submit" value="Schedule Lab">
        </form>
    </div>
</body>
</html>
