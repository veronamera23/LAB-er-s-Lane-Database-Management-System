<?php

function generateEquipID($conn, $deptID) {
    do {
        $randomNum = mt_rand(10000, 99999);
        $resID = $deptID . str_pad($randomNum, 4, '0', STR_PAD_LEFT);

        $sql = "SELECT Equip_ID FROM equipment WHERE Equip_ID = ?";
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

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $equipName = $_POST["EquipName"];
    $equipSN = $_POST["EquipSN"];
    $equipCon = $_POST["EquipCon"];
    $deptName = $_POST["DeptName"];  // Department name from the form

    require_once 'dbc.inc.php';

    if (empty($equipName) || empty($equipSN) || empty($equipCon) || empty($deptName)) {
        echo "<script>alert('Please fill in all details when adding equipment!');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
        exit();
    }

    // Retrieve dept_id from dept_name
    $sql = "SELECT dept_id FROM department WHERE dept_name = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<script>alert('Statement preparation failed');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $deptName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $deptID);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!$deptID) {
        echo "<script>alert('Department not found');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
        exit();
    }

    // Generate Equip_ID
    $equipID = generateEquipID($conn, $deptID);

    if (addEquipment($conn, $equipID, $equipName, $equipSN, $equipCon, $deptID)) {
        echo "<script>alert('New equipment added successfully with ID: $equipID');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to add equipment to the database');</script>";
        echo "<script>window.location.href='../LabersLaneEquip.php';</script>";
    }
    exit();

} else {
    header("Location: ../LabersLaneEquip.php");
    exit();
}

function addEquipment($conn, $equipID, $equipName, $equipSN, $equipCon, $deptID) {
    $sql = "INSERT INTO equipment (Equip_ID, Equip_Name, Equip_SerNum, Equip_Con, dept_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssi", $equipID, $equipName, $equipSN, $equipCon, $deptID);

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
