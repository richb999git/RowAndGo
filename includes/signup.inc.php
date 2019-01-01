<?php
if (isset($_POST["signup-submit"])) {
    
    require "dbh.inc.php";

    $username = $_POST["uid"];
    $email = $_POST["mail"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];
    $dob = $_POST["dob"];
    $club = $_POST["club"];
    $weight = $_POST["weight"];
    $gender = $_POST["gender"];

    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($dob)) {
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidmail=".$username."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob);
        exit();
    }
    else if ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob);
        exit();
    }
    else if (!isValidDate($dob)) {
        header("Location: ../signup.php?error=invaliddate&uid=".$username."&mail=".$email."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob);
        exit();
    }
    else {
        $sql = "SELECT emailUsers FROM rowusers WHERE emailUsers=?"; // was uidUsers
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../signup.php?error=sqlerror1");
            exit(); 
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $email); // was username
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=emailtaken&uid=".$username."&mail=".$email."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob);
                exit();
            }
            else {
                $sql = "INSERT INTO rowusers (uidUsers, emailUsers, pwdUsers, club, male, lightWeight, dob) VALUES(?, ?, ?, ?, ?, ?, ?)"; // was 3 fields
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../signup.php?error=sqlerror2");
                    exit(); 
                }
                else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    //  change string into a date.Then change the date into the correct format for the database yyyy-mm-dd  // format form is dd-mmm-yyyy
                    $dob = date('Y-m-d', strtotime($dob)); 
                    $gender == "M" ? $male = 1 : $male = 0;
                    $weight == "L" ? $lightWeight = 1 : $lightWeight = 0;
                    mysqli_stmt_bind_param($stmt, "ssssiis", $username, $email, $hashedPwd, $club, $male, $lightWeight, $dob); // was 3 fields
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit(); 
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
else {
    header("Location: ../signup.php");
    exit();  
}

function isValidDate2($date) {
    return date('Y-m-d', strtotime($date)) === $date;
}

function isValidDate($date) {
    $timestamp = strtotime($date);
    return $timestamp ? $date : null;
}