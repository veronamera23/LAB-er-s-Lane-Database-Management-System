<?php

function idExists($conn, $id) {
    $sql = "SELECT * FROM users WHERE User_ID = ?;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../LabersLaneSignUp.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function emptyInputSignUp($name, $pwd, $role, $deptName) {
    if (empty($name) || empty($pwd) || empty($role) || ($role == "staff" && empty($deptName))) {
        return true;
    }
    return false;
}


function emptyInputLogIn($id, $pwd) {
    $result;

    if ((empty($id)) || (empty($pwd))) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}


