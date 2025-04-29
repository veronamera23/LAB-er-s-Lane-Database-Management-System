<?php
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $labName = $_POST["LabName"];
    $labCon = $_POST["LabCon"];

    require_once 'dbc.inc.php';

    if (empty($labName) || empty($labCon)) {
        echo "<script>alert('Please fill in all details when updating a lab!');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
        exit();
    }

    if (updateLabCondition($conn, $labName, $labCon)) {
        echo "<script>alert('Laboratory condition updated successfully!');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to update laboratory condition');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
    }
    exit();
} else {
    header("Location: ../LabersLaneLab.php");
    exit();
}

function updateLabCondition($conn, $labName, $labCon) {
    $sql = "UPDATE laboratory SET lab_con = ? WHERE lab_name = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $labCon, $labName);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        return false;
    }
}
