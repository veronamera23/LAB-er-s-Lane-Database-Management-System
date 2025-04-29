<?php

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $equipName = $_POST["EquipName"];
    $equipCon = $_POST["EquipCon"];

    require_once 'dbc.inc.php';

    if (empty($equipName) || empty($equipCon)) {
        echo "<script>alert('Please fill in all details when updating equipment!');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
        exit();
    } else {
        echo "<script>console.log('Form data received: EquipName = $equipName, EquipCon = $equipCon');</script>";
    }

    if (updateEquipCondition($conn, $equipName, $equipCon)) {
        echo "<script>alert('Equipment condition updated successfully!');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to update equipment condition');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    }
    exit();
} else {
    header("Location: ../LabersLaneEquip.php");
    exit();
}

function updateEquipCondition($conn, $equipName, $equipCon) {
    $sql = "UPDATE equipment SET equip_con = ? WHERE equip_name = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    echo "<script>console.log('SQL Query Prepared: $sql');</script>";

    $stmt->bind_param("ss", $equipCon, $equipName);

    echo "<script>console.log('Parameters bound: EquipCon = $equipCon, EquipName = $equipName');</script>";

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        return false;
    }
}
?>
