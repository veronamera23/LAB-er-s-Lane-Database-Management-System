<?php
include 'dbc.inc.php';

if (isset($_GET['dept_prefix'])) {
    $dept_prefix = $_GET['dept_prefix'];
    $sql = "SELECT lab_name FROM laboratory WHERE dept_prefix = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $dept_prefix);
        $stmt->execute();
        $result = $stmt->get_result();

        $labs = array();
        while ($row = $result->fetch_assoc()) {
            $labs[] = $row['lab_name'];
        }
        $stmt->close();
        $conn->close();

        echo json_encode($labs);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
