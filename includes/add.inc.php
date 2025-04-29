<?php

// Include database connection file
require_once 'dbc.inc.php';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to generate IDs
function generateId($conn, $prefixes, $tableName) {
    do {
        $randomNum = mt_rand(10000, 99999);
        $id = $prefix . str_pad($randomNum, 4, '0', STR_PAD_LEFT);

        $sql = "SELECT {$tableName}_id FROM $tableName WHERE {$tableName}_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $idExists = $stmt->num_rows > 0;
        $stmt->close();
    } while ($idExists);

    return $id;
}

function addRecord($conn, $id, $name, $con, $additionalColumn, $tableName) {
    $sql = "INSERT INTO $tableName ({$tableName}_id, {$tableName}_name, {$tableName}_con, $additionalColumn) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssss", $id, $name, $con, $additionalColumn);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        return false;
    }
}

// Handling form submissions
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    
    // Common variables
    $name = $_POST["Name"];
    $con = $_POST["Con"];
    $deptName = $_POST["DeptName"];

    // Variables specific to each action
    switch ($action) {
        case 'lab':
            $tableName = "laboratory";
            $prefixes = [
                "CAS Chem" => "1001",
                "CAS Phy" => "1002",
                "CAS Bio" => "1003",
                "SOTECH Food" => "2004",
                "SOTECH Che" => "2005",
                "CFOS" => "3006"
            ];
            $additionalColumn = "lab_dept";
            break;

        case 'equip':
            $tableName = "equipment";
            $prefixes = [
                "CAS Chem" => "1001",
                "CAS Phy" => "1002",
                "CAS Bio" => "1003",
                "SOTECH Food" => "2004",
                "SOTECH Che" => "2005",
                "CFOS" => "3006"
            ];
            $additionalColumn = "";
            break;

        case 'staff':
            $tableName = "staffincharge";
            $prefixes = [
                "CAS Chem" => "C",
                "CAS Phy" => "P",
                "CAS Bio" => "B",
                "SOTECH Food" => "F",
                "SOTECH Che" => "E",
                "CFOS" => "O"
            ];
            $additionalColumn = "";
            break;

        case 'resource':
            $tableName = "resource";
            $prefixes = [
                "CAS Chem" => "1001",
                "CAS Phy" => "1002",
                "CAS Bio" => "1003",
                "SOTECH Food" => "2004",
                "SOTECH Che" => "2005",
                "CFOS" => "3006"
            ];
            $additionalColumn = "res_avail";
            break;

        default:
            echo "Invalid action.";
            exit();
    }

    // Generate ID
    $id = generateId($conn, $prefixes, $tableName);

    // Add record
    if (addRecord($conn, $id, $name, $con, $deptName, $tableName)) {
        echo "<script>alert('New record added successfully with ID: $id');</script>";
        echo "<script>window.location.href='../LabersLane{$action}.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to add record to the database');</script>";
        echo "<script>window.location.href='../LabersLane{$action}.php';</script>";
    }
    exit();
} else {
    header("Location: ../LabersLane.php");
    exit();
}
?>
