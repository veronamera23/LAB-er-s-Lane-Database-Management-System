<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $resName = $_POST["ResName"];
    $resType = $_POST["ResType"];
    $resAvail = intval($_POST["ResAvail"]);
    $deptName = $_POST["DeptName"]; // This should be Dept_ID now

    require_once 'dbc.inc.php';

    if (empty($resName) || empty($resType) || !is_int($resAvail) || empty($deptName)) {
        echo "<script>alert('Please fill in all details when adding a resource!');</script>";
        echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        exit();
    }

    // Assuming you have a function to fetch the department ID based on its name
    $deptID = fetchDeptID($conn, $deptName);

    if ($deptID) {
        $resID = generateResId($conn, $deptID);

        if (addResource($conn, $resID, $resName, $resType, $resAvail, $deptID)) {
            echo "<script>alert('New resource added successfully with ID: $resID');</script>";
            echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        } else {
            echo "<script>alert('Error: Failed to add resource to the database');</script>";
            echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        }
    } else {
        echo "<script>alert('Error: Department ID not found');</script>";
        echo "<script>window.location.href='../LabersLaneRes.php';</script>";
    }
    exit();
} else {
    header("Location: ../LabersLaneRes.php");
    exit();
}

function fetchDeptID($conn, $deptName) {
    $sql = "SELECT Dept_ID FROM department WHERE Dept_Name = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $deptName);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($deptID);
        $stmt->fetch();
        $stmt->close();
        return $deptID;
    } else {
        return false;
    }
}

function generateResId($conn, $deptID) {
    do {
        $randomNum = mt_rand(10000, 99999);
        $resID = $deptID . str_pad($randomNum, 4, '0', STR_PAD_LEFT);

        $sql = "SELECT Res_ID FROM resource WHERE Res_ID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $resID);
        $stmt->execute();
        $stmt->store_result();
        $idExists = $stmt->num_rows > 0;
        $stmt->close();
    } while ($idExists);

    return $resID;
}


function addResource($conn, $resID, $resName, $resType, $resAvail, $deptID) {
    $sql = "INSERT INTO resource (Res_ID, Res_Name, Res_Type, Res_Avail, Dept_ID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssi", $resID, $resName, $resType, $resAvail, $deptID);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        return false;
    }
}
