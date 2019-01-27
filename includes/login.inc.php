<?php
if (isset($_POST["login-submit"])) { // check user has come from the login page

    require "dbh.inc.php";
    session_start();
    $mailuid = $_POST["mailuid"];
    $password = $_POST["pwd"];

    if (empty($mailuid) || empty($password)) {
        header("Location: ../login.php?error=emptyfields");
        exit();  
    }
    else {
        $sql = "SELECT * FROM rowusers WHERE emailUsers=?;";  // was user and email
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();  
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $mailuid); // was twice
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row["pwdUsers"]);
                if ($pwdCheck == false) {
                    header("Location: ../login.php?error=wrongpwd&mailuid=".$mailuid);
                    exit();
                }
                else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION["userId"] = $row["idUsers"];
                    $_SESSION["username"] = $row["uidUsers"];
                    $_SESSION["club"] = $row["club"];
                    $_SESSION["userEmail"] = $row["emailUsers"];
                    $_SESSION["male"] = $row["male"];
                    $_SESSION["dob"] = $row["dob"];
                    $_SESSION["weight"] = $row["lightWeight"];
                    header("Location: ../index.php?login=success");
                    exit(); 
                }
                else {
                    header("Location: ../login.php?error=wrongpwd&mailuid=".$mailuid);
                    exit();
                }
            }
            else {
                header("Location: ../login.php?error=nouser");
                exit(); 
            }
        }
    }

}
else {
   header("Location: ../index.php");
   exit();   
}