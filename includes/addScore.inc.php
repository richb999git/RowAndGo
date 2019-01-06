<?php
if (isset($_POST["log-submit"])) {
    
    require "dbh.inc.php";
    session_start();
    // field "event1" is name of exercise - either in ditance or time (minutes). e.g. 2000m or 30minutes
    // field "time1" is the time take for the event if it is in meters (otherwise shown as 0)
    // field "distance" is the distance travelled for the event if it is in minutes (otherwise shown as 0)
    // field "rate" is if the event is rate capped (otherwise shown as 0)
    // field "eventType" is either TIME or DIST
    
    $event1 = $_POST["event1"];
    $rate = $_POST["rate"];
    $ergDate = $_POST["ergDate"];
    
    if (isset($_POST["distance"])) {
        $scoreDistance = $_POST["distance"];
    } else {
        $scoreSeconds = $_POST["timeSec"];
        $scoreMinutes = $_POST["timeMin"];
    }

    if (!isset($scoreDistance)) {  // i.e. if you have an amount travelled it must be a TIME event
        $eventType = "DIST";   // not needed? - change below
        $distOrTime = "distance";
        $scoreDistance = 0;
        
    } else {
        $eventType = "TIME";    // not needed? - change below
        $distOrTime = "time";
    } 
    
    $scoreTime = $scoreMinutes * 60 + $scoreSeconds; // 0 if n/a
    
    // if distance event check for date, event1, scoreMinutes, scoreSeconds
    if ($distOrTime == "distance") {
        if (empty($ergDate) || empty($event1) || $scoreMinutes == "" || $scoreSeconds == "") {
            header("Location: ../addScoreMain.php?error=emptyfields&event1=".$event1."&scoreMinutes=".$scoreMinutes."&scoreSeconds=".$scoreSeconds."&distOrTime=".$distOrTime."&rate=".$rate);
            exit();
        }
    } else {
        // if time check for date, event1, scoreDistance
        if (empty($ergDate) || empty($event1) || empty($scoreDistance) ) {
            header("Location: ../addScoreMain.php?error=emptyfields&event1=".$event1."&scoreDistance=".$scoreDistance."&distOrTime=".$distOrTime."&rate=".$rate);
            exit();
        }
    }
    
    $ergDate = date('Y-m-d', strtotime($ergDate)); 
    // check date is after today
    if (strtotime($ergDate) > strtotime(date("Y-m-d"))) {
        header("Location: ../addScoreMain.php?error=invaliddate&event1=".$event1."&scoreMinutes=".$scoreMinutes."&scoreSeconds=".$scoreSeconds."&scoreDistance=".$scoreDistance."&distOrTime=".$distOrTime."&rate=".$rate);
        exit(); 
    }
    
    if ($rate != "Free rate") {
        $event1 = $event1."R".$rate;
    } else {
        $rate = 0; 
    }    
    
    // need to get user's id so I can save to results table as PersonId - $_SESSION["userId"]
    $sql = "SELECT * FROM rowusers WHERE emailUsers=?"; // need to double check the user exists
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../signup.php?error=sqlerror1");
            exit(); 
        }
        else {
            $mailuid = $_SESSION["userEmail"];
            mysqli_stmt_bind_param($stmt, "s", $mailuid); 
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $sql = "INSERT INTO results (idPerson, date1, eventType, event1, rate, scoreDistance, scoreTime) VALUES(?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../signup.php?error=sqlerror2");
                    exit(); 
                }
                else {
                $personId = $_SESSION["userId"];
                mysqli_stmt_bind_param($stmt, "isssiid", $personId, $ergDate, $eventType, $event1, $rate, $scoreDistance, $scoreTime); 
                mysqli_stmt_execute($stmt);
                header("Location: ../index.php?success=".$personId."ll".$row["emailUsers"].$row["club"]);
                exit(); 
                }

            }
            else {
                header("Location: ../index.php?error=nouser");
                exit(); 
            }

        }

    // temporary
    //header("Location: ../index.php?score=success&eventType=".$eventType."&scoreDistance=".$scoreDistance."&scoreMinutes=".$scoreMinutes."&scoreSeconds=".$scoreSeconds."&ergDate=".$ergDate."&event1=".$event1."&rate=".$rate."&scoreTime=".$scoreTime."&testDate=".$testDate);
    //exit(); 

}
else {
    header("Location: ../index.php");
    exit();  
}