<?php

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $labName = $_POST["LabName"];
    $labCon = $_POST["LabCon"];
    $labDept = $_POST["LabDept"];

    require_once 'dbc.inc.php';

    if (empty($labName) || empty($labCon) || empty($labDept)) {
        echo "<script>alert('Please fill in all details when adding a lab!');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
        exit();
    }

    list($labID, $labName) = generateLabId($conn, $labDept, $labName);

    $deptPrefix = substr($labID, 0, 4);

    $staffID = selectRandomStaffInCharge($conn, $deptPrefix);

    if (addLab($conn, $labID, $labName, $labCon, $labDept, $staffID)) {
        
        assignStaffInCharge($conn, $staffID, $labID);

        echo "<script>alert('New laboratory added successfully with ID: $labID');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to add laboratory to the database');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
    }
    exit();

} else {
    header("Location: ../LabersLaneLab.php");
    exit();
}


function generateLabId($conn, $labDept, $labName) {
    $prefixes = [
        "CAS Chem" => "1001",
        "CAS Phy" => "1002",
        "CAS Bio" => "1003",
        "SOTECH Food" => "2004",
        "SOTECH Che" => "2005",
        "CFOS" => "3006"
    ];

    $prefix = isset($prefixes[$labDept]) ? $prefixes[$labDept] : "0000";

    do {
        $randomNum = mt_rand(10000, 99999);
        $labID = $prefix . str_pad($randomNum, 4, '0', STR_PAD_LEFT);

        $sql = "SELECT lab_id FROM laboratory WHERE lab_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $labID);
        $stmt->execute();
        $stmt->store_result();
        $idExists = $stmt->num_rows > 0;
        $stmt->close();
    } while ($idExists);

    return array($labID, $labName);
}

function addLab($conn, $labID, $labName, $labCon, $labDept, $staffID) {
    $sql = "INSERT INTO laboratory (lab_id, lab_name, lab_con, lab_dept, Staff_ID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssss", $labID, $labName, $labCon, $labDept, $staffID);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        return false;
    }
}


function selectRandomStaffInCharge($conn, $deptPrefix) {
    $sql = "SELECT Staff_ID FROM staff WHERE Staff_ID LIKE ? ORDER BY RAND() LIMIT 1";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $deptPrefixLike = $deptPrefix . '%';
    $stmt->bind_param("s", $deptPrefixLike);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row["Staff_ID"];
    }
    $stmt->close();
    return null;
}


// function updateDepartment($conn, $labDept, $labName) {
//     $sql = "UPDATE department SET Dept_Name = CONCAT(Dept_Name, ', $labName') WHERE Dept_ID = ?";
//     $stmt = $conn->prepare($sql);
//     if ($stmt === false) {
//         die("Prepare failed: " . $conn->error);
//     }
//     $stmt->bind_param("s", $labDept);
//     $stmt->execute();
//     $stmt->close();
// }

function assignStaffInCharge($conn, $staffInCharge, $labID) {
    $sql = "UPDATE laboratory SET Staff_ID = ? WHERE lab_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $staffInCharge, $labID);
    $stmt->execute();
    $stmt->close();
}

