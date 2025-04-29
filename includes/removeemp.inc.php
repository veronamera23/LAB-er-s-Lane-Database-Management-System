<?php
include 'dbc.inc.php';

if (isset($_POST["EmpName"])) {
    $staffName = $_POST['EmpName'];

    $deleteStaff = mysqli_query($conn, "DELETE FROM `staffincharge` WHERE `staff_name`='$staffName'");

    if ($deleteStaff) {
        echo "<script>alert('Staff removed successfully with name: $staffName');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to remove staff from the database');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    }

    $conn->close();
    exit();
}

header("Location: ../LabersLaneEmp.php");
exit();

