<?php
include 'dbc.inc.php';

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $empName = $_POST["EmpName"];
    $empID = $_POST["EmpID"];
    $newEmpName = $_POST["NewEmpName"];
    $deptName = $_POST["DeptName"];

    require_once 'dbc.inc.php';

    if (empty($empName) || empty($empID) || empty($newEmpName) || empty($deptName)) {
        echo "<script>alert('Please fill in all details when updating a staff-in-charge!');</script>";
        echo "<script>window.location.href='../LabersLaneEmp.php';</script>";
        exit();
    }

    if (updateStaffInCharge($conn, $empID, $newEmpName, $deptName)) {
        echo "<script>alert('Staff-in-charge updated successfully with ID: $empID');</script>";
        echo "<script>window.location.href='../LabersLaneEmp.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to update staff-in-charge in the database');</script>";
        echo "<script>window.location.href='../LabersLaneEmp.php';</script>";
    }
    exit();
} else {
    header("Location: ../LabersLaneEmp.php");
    exit();
}

function updateStaffInCharge($conn, $empID, $newEmpName, $deptName) {
    // Get the new prefix based on the department
    $prefixes = [
        "CAS Chem" => "C",
        "CAS Phy" => "P",
        "CAS Bio" => "B",
        "SOTECH Food" => "F",
        "SOTECH Che" => "E",
        "CFOS" => "O"
    ];

    $prefix = isset($prefixes[$deptName]) ? $prefixes[$deptName] : "X";

    // Generate the new staff ID with the updated prefix
    $newStaffID = $prefix . substr($empID, 1);

    $sql = "UPDATE staffincharge SET Staff_Id = ?, Staff_Name = ? WHERE Staff_Id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $newStaffID, $newEmpName, $empID); 

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        return false;
    }
}

