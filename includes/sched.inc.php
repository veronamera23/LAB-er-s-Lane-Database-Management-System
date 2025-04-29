<?php
function generateScheduleID($dept_prefix, $lab) {
    global $prefixes;

    if (!isset($prefixes[$dept_prefix])) {
        return false; // Handle invalid department prefix
    }

    $random_num = mt_rand(1000, 9999);
    $prefix = $prefixes[$dept_prefix];
    return $prefix . substr($lab, 0, 3) . $random_num;
}

$prefixes = [
    "CAS Chemistry" => "1001",
    "CAS Physics" => "1002",
    "CAS Biology" => "1003",
    "SOTECH Food Technology" => "2004",
    "SOTECH Chemical Engineering" => "2005",
    "CFOS" => "3006"
];

include 'dbc.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST["start_date"] ?? null;
    $start_time = $_POST["start_time"] ?? null;
    $end_date = $_POST["end_date"] ?? null;
    $end_time = $_POST["end_time"] ?? null;
    $dept_prefix = $_POST["dept_prefix"] ?? null;
    $lab = $_POST["lab"] ?? null;

    if ($start_date && $start_time && $end_date && $end_time && $dept_prefix && $lab) {
        $sql_lab_check = "SELECT COUNT(*) AS lab_count FROM laboratory WHERE lab_name = ?";
        $stmt_lab_check = $conn->prepare($sql_lab_check);
        $stmt_lab_check->bind_param("s", $lab);
        $stmt_lab_check->execute();
        $result_lab_check = $stmt_lab_check->get_result();
        $row_lab_check = $result_lab_check->fetch_assoc();
        $lab_count = $row_lab_check['lab_count'];
        $stmt_lab_check->close();

        if ($lab_count > 0) {
            $start_datetime = $start_date . " " . $start_time;
            $end_datetime = $end_date . " " . $end_time;

            $sched_id = generateScheduleID($dept_prefix, $lab);

            if ($sched_id) {
                $sql = "INSERT INTO schedule (sched_id, start_time, end_time, start_date, end_date, lab_name) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("ERROR: Could not prepare query: $sql. " . $conn->error);
                }
                $stmt->bind_param("ssssss", $sched_id, $start_datetime, $end_datetime, $start_date, $end_date, $lab);
                $stmt->execute();
                $stmt->close();
                ?>
                <script>
                    alert("Lab scheduled successfully.");
                </script>
                <?php
            } 
        } else {
            ?>
            <script>
                alert("Laboratory you want to schedule does not exist!");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("Missing form data.");
        </script>
        <?php
    }

    $conn->close();
}
?>
