<?php
include 'dbc.inc.php';

if (isset($_POST["equipName"])) {
    $equipName = $_POST['equipName'];

    $deleteEquipment = mysqli_query($conn, "DELETE FROM `equipment` WHERE `Equip_Name`='$equipName'");

    if ($deleteEquipment) {
        echo "<script>alert('Equipment ".$equipName." has been successfully removed.');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to remove equipment from the database');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    }

    $conn->close();
    exit();
}

header("Location: ../LabersLaneEquip.php");
exit();
?>
