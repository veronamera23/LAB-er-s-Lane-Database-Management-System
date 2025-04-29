<?php
include 'dbc.inc.php';

if (isset($_POST["ResName"])) {
    $resName = $_POST['ResName'];

    $deleteResource = mysqli_query($conn, "DELETE FROM `resource` WHERE `Res_Name`='$resName'");

    if ($deleteResource) {
        echo "<script>alert('Resource removed successfully with name: $resName');</script>";
        echo "<script>window.location.href='../LabersLaneRes.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to remove resource from the database');</script>";
        echo "<script>window.location.href='../LabersLaneRes.php';</script>";
    }

    $conn->close();
    exit();
}

header("Location: ../LabersLaneRes.php");
exit();
?>
