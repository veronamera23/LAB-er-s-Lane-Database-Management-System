<?php
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    require_once 'dbc.inc.php';
    require_once 'functions.inc.php';


    if (emptyInputLogIn($username, $pwd) !== false) {
        header("location: ../LabersLaneLogIn.php?error=emptyinput");
        exit();
    }
    
    loginUser($conn, $username, $pwd);
} else {
    header("location: ../LabersLaneLogIn.php");
    exit();
}

function loginUser($conn, $username, $pwd) {
    $sql = "SELECT * FROM users WHERE User_Name = ?;";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username); // Change $id to $username
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $pwdHashed = $row["User_Password"];
        $checkPwd = password_verify($pwd, $pwdHashed);
        
        if ($checkPwd === false) {
            header("location: ../LabersLaneLogIn.php?error=wrongpassword");
            exit();
        } else {
            session_start();
            $_SESSION["username"] = $row["User_Name"];
            $_SESSION["userrole"] = $row["User_Role"];
            
            if ($row["User_Role"] == "student") {
                header("location: ../LabersLaneStudentHome.php");
            } else if ($row["User_Role"] == "staff") {
                header("location: ../LabersLaneHome.php");
            }
            exit();
        }
    } else {
        header("location: ../LabersLaneLogIn.php?error=nouser");
        exit();
    }
    $stmt->close();
}

