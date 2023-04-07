<?php
if (isset($_POST["login-submit"])) { // check user has come from the login page

    require "dbh.inc.php";
    if(!isset($_SESSION))
    {
        session_start();
    }
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
                    if(!isset($_SESSION))
                    {
                        session_start();
                    }
                    $_SESSION["userId"] = $row["idUsers"];
                    $_SESSION["username"] = $row["uidUsers"];
                    $_SESSION["club"] = $row["club"];
                    $_SESSION["userEmail"] = $row["emailUsers"];
                    $_SESSION["male"] = $row["male"];
                    $_SESSION["dob"] = $row["dob"];
                    $_SESSION["weight"] = $row["lightWeight"];
                    $_SESSION["event2WRate"] = array("250m","500m","1000m","1500m","2000m","2000mR24","2000mR26","2000mR28","2500m","3000m","5000m","5000mR24","5000mR26","6000m","10000m","10000mR18","10000mR20","15000m","20000m","20000mR18","21097m","42195m","1min","2mins","3mins","4mins","5mins","6 mins","7mins","10mins","12mins","15mins","20mins","20minsR20","20minsR22","30mins","30minsR18","30minsR20","45mins","45minsR18","45minsR20","60mins","60minsR18","60minsR20");
                    $_SESSION["ageDescFull"] = array("SEN","U23","Juniors","Masters","J18","J17","J16","J15","J14","J13","J12","J11","MastersA","MastersB","MastersC","MastersD","MastersE","MastersF","MastersG","MastersH","MastersI","MastersJ");
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