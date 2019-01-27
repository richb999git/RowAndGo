<?php
if (isset($_POST["signup-submit"])) { // check user has come from the signup page
    
    require "dbh.inc.php";
    session_start();
    // may not be right - may use POST button
    // ascertain if we need to add or edit the user account
    if (isset($_GET["edit"])) {
        if ($_GET["edit"] == "y") {
            $edit = "y"; 
        } else if ($_GET["edit"] == "n") {
            $edit = "n";
        } else {
            header("Location: ../index.php?error=incorrect_edit_mode");
            exit(); 
        }
    }

    if ($edit == "n") {
        $password = $_POST["pwd"];
        $passwordRepeat = $_POST["pwd-repeat"];
    } else {
        $password = "password";
        $passwordRepeat = "password"; // set password so that check below works when editing. it won't be saved when updating.
    }
    
    
    $username = $_POST["uid"];
    $email = $_POST["mail"];
    $dob = $_POST["dob"];
    $club = $_POST["club"];
    $weight = $_POST["weight"];
    $gender = $_POST["gender"];

    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($club) || empty($dob)) {
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email."&dob=".$dob."&club=".$club."&weight=".$weight."&gender=".$gender."&edit=".$edit);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidmail&uid=".$username."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob."&edit=".$edit);
        exit();
    }
    else if ($edit == "n" && $password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob."&edit=".$edit);
        exit();
    }
    else if (!isValidDate($dob)) {
        header("Location: ../signup.php?error=invaliddate&uid=".$username."&mail=".$email."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob."&edit=".$edit);
        exit();
    }
    else {
        $sql = "SELECT emailUsers FROM rowusers WHERE emailUsers=?"; // was uidUsers
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror&edit=".$edit);
            exit(); 
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $email); // was username
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt); // checking if email already exists. If not then add the user.
            if ($edit == "n" && $resultCheck > 0) {
                header("Location: ../signup.php?error=emailtaken&uid=".$username."&mail=".$email."&club=".$club."&weight=".$weight."&gender=".$gender."&dob=".$dob."&edit=".$edit);
                exit();
            }
            else {

                if ($edit == "n") { 
                    $sql = "INSERT INTO rowusers (uidUsers, emailUsers, pwdUsers, club, male, lightWeight, dob) VALUES(?, ?, ?, ?, ?, ?, ?)";
                } else if ($edit == "y") {
                    $sql = 'UPDATE rowusers SET uidUsers=?, emailUsers=?, club=?, male=?, lightWeight=?, dob=?';
                    $sql .= ' WHERE idUsers=?';
                } else {
                    header("Location: ../index.php?error=option_error&edit=".$edit);
                    exit(); 
                }

                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../index.php?error=sqlerror&edit=".$edit);
                    exit(); 
                }
                else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    //  change string into a date.Then change the date into the correct format for the database yyyy-mm-dd  // format form is dd-mmm-yyyy
                    $dob = date('Y-m-d', strtotime($dob)); 
                    $gender == "M" ? $male = 1 : $male = 0;
                    $weight == "L" ? $lightWeight = 1 : $lightWeight = 0;

                    if ($edit == "n") {
                        mysqli_stmt_bind_param($stmt, "ssssiis", $username, $email, $hashedPwd, $club, $male, $lightWeight, $dob);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?success=signup");
                        exit(); 
                    } if ($edit == "y") {
                        mysqli_stmt_bind_param($stmt, "sssiiss", $username, $email, $club, $male, $lightWeight, $dob, $_SESSION["userId"]);
                        mysqli_stmt_execute($stmt);
                        // set session variables to reflect changes. These will be used on form.
                        $_SESSION["username"] = $username;
                        $_SESSION["club"] = $club;
                        $_SESSION["userEmail"] = $email;
                        $_SESSION["male"] = $male;
                        $_SESSION["dob"] = $dob;
                        $_SESSION["weight"] = $lightWeight;
                        header("Location: ../signup.php?edit=y&success=editAccount");
                        exit(); 
                    }
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