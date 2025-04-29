<?php
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $resName = $_POST["ResName"];
    $resAvail = $_POST["ResAvail"];

    require_once 'dbc.inc.php';

    if (empty($resName) || !isset($resAvail)) {
        echo "<script>alert('Please fill in all details when updating the resource availability!');</script>";
        echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        exit();
    }

    // Check if the resource availability is being updated to zero
    if ($resAvail == 0) {
        // Mark the resource as unavailable
        if (markResourceUnavailable($conn, $resName)) {
            echo "<script>alert('Resource availability updated to zero!');</script>";
            echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        } else {
            echo "<script>alert('Error: Failed to update resource availability');</script>";
            echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        }
    } else {
        // Update the resource availability as usual
        if (updateResourceAvailability($conn, $resName, $resAvail)) {
            echo "<script>alert('Resource availability updated successfully!');</script>";
            echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        } else {
            echo "<script>alert('Error: Failed to update resource availability');</script>";
            echo "<script>window.location.href='../LabersLaneRes.php';</script>";
        }
    }
    exit();
} else {
    header("Location: ../LabersLaneRes.php");
    exit();
}


function updateResourceAvailability($conn, $resName, $resAvail) {
    $sql = "UPDATE resource SET Res_Avail = ? WHERE Res_Name = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $resAvail, $resName);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        return false;
    }
}

// Function to mark resource as unavailable when availability count is zero
function markResourceUnavailable($conn, $resName) {
    $sql = "UPDATE resource SET Res_Avail = 0 WHERE Res_Name = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $resName);

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
