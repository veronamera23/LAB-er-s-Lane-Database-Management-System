<?php
if ((isset($_POST["submit"])) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

    $name = $_POST["name"];
    $pwd = $_POST["pwd"];
    $role = $_POST["role"];
    $deptName = $_POST["SelDept"] ?? ''; 

    require_once 'dbc.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignUp($name, $pwd, $role, $role == "staff" ? $deptName : '') !== false) {
        header("location: ../LabersLaneSignUp.php?error=emptyinput");
        exit();
    }

    $id = generateUserId($conn, $role, $deptName);

    createUser($conn, $name, $id, $pwd, $role, $deptName);

    header("Location: ../LabersLaneSignUp.php?userId=" . $id);
    exit();

} else {
    header("Location: ../LabersLaneSignUp.php");
    exit();
}

function generateUserId($conn, $role, $deptName) {
    $prefixes = [
        "CAS Chem" => "1001",
        "CAS Phy" => "1002",
        "CAS Bio" => "1003",
        "SOTECH Food" => "2004",
        "SOTECH Che" => "2005",
        "CFOS" => "3006"
    ];

    if ($role == "staff") {
        $prefix = isset($prefixes[$deptName]) ? $prefixes[$deptName] : "X0000";
        do {
            $randomNum = mt_rand(100000, 999999);
            $userId = $prefix . '-' . $randomNum;

            $sql = "SELECT User_ID FROM users WHERE User_ID = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $stmt->store_result();
            $idExists = $stmt->num_rows > 0;
            $stmt->close();
        } while ($idExists);

    } else {
        do {
            $userId = mt_rand(100000, 999999);
            $sql = "SELECT User_ID FROM users WHERE User_ID = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $stmt->store_result();
            $idExists = $stmt->num_rows > 0;
            $stmt->close();
        } while ($idExists);
    }

    return $userId;
}

function createUser($conn, $name, $id, $pwd, $role){
    $sql = "INSERT INTO users (User_Name, User_ID, User_Password, User_Role)
            VALUES(?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../LabersLaneSignUp.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $id, $hashedPwd, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../LabersLaneLogIn.php");
    exit();
}

