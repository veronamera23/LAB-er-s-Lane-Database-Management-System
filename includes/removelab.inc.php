<?php
include 'dbc.inc.php';

if (isset($_POST["LabName"])) {
    $labName = $_POST['LabName'];

    $deleteLab = mysqli_query($conn, "DELETE FROM laboratory WHERE lab_name='$labName'");

    if ($deleteLab) {
        echo "<script>alert('Laboratory removed successfully with name: $labName');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to remove laboratory from the database');</script>";
        echo "<script>window.location.href='../LabersLaneLab.php';</script>";
    }

    $conn->close();
    exit();
}

header("Location: ../LabersLaneLab.php");
exit();
