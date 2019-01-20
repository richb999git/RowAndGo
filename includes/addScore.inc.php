<?php
if (isset($_POST["log-submit"])) {
    
    require "dbh.inc.php";
    session_start();
    // field "event1" is name of exercise - either in ditance or time (minutes). e.g. 2000m or 30minutes
    // field "time1" is the time take for the event if it is in meters (otherwise shown as 0)
    // field "distance" is the distance travelled for the event if it is in minutes (otherwise shown as 0)
    // field "rate" is if the event is rate capped (otherwise shown as 0)
    // field "eventType" is either TIME or DIST
    
    // ascertain if we need to add or edit the score
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

    // ascertain if we need to delete the score
    if (isset($_POST["log-submit"])) {
        if($_POST["log-submit"] == "log-delete") {

            $sql = 'DELETE FROM results WHERE idResults='.$_GET["scoreID"];           
            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                header("Location: ../index.php?error=DELETE_OK");
                exit(); 
            } else {
                //echo "Error deleting record: " . mysqli_error($conn);
                mysqli_close($conn);
                header("Location: ../index.php?error=DELETE_ERROR");
                exit(); 
            }
        }
    }    

    $event1 = $_POST["event1"];
    $rate = $_POST["rate"];
    $ergDate = $_POST["ergDate"];
    $dynamic = $_POST["dynamic"];
    $weight = $_POST["weight"];
    
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
            header("Location: ../addScoreMain.php?error=emptyfields&event1=".$event1."&scoreMinutes=".$scoreMinutes."&scoreSeconds=".$scoreSeconds."&distOrTime=".$distOrTime."&rate=".$rate."&dynamic=".$dynamic."&weight=".$weight);
            exit();
        }
    } else {
        // if time check for date, event1, scoreDistance
        if (empty($ergDate) || empty($event1) || empty($scoreDistance) ) {
            header("Location: ../addScoreMain.php?error=emptyfields&event1=".$event1."&scoreDistance=".$scoreDistance."&distOrTime=".$distOrTime."&rate=".$rate."&dynamic=".$dynamic."&weight=".$weight);
            exit();
        }
    }
    
    $ergDate = date('Y-m-d', strtotime($ergDate)); 
    // check date is after today
    if (strtotime($ergDate) > strtotime(date("Y-m-d"))) {
        header("Location: ../addScoreMain.php?error=invaliddate&event1=".$event1."&scoreMinutes=".$scoreMinutes."&scoreSeconds=".$scoreSeconds."&scoreDistance=".$scoreDistance."&distOrTime=".$distOrTime."&rate=".$rate."&dynamic=".$dynamic."&weight=".$weight);
        exit(); 
    }
    
    $dynamic == "Dynamic" ? $dynamic = 1 : $dynamic = 0;
    $weight == "Light" ? $weight = 1 : $weight = 0;
    $ageCat = "temporary";
    if ($rate != "Free rate") {
        $event1 = $event1."R".$rate;
    } else {
        $rate = 0; 
    }   
    
    // add gender, weight, erg type (dynamic/std) to event1
    // later need to add (J)unior and Masters age categories (and SENior). e.g. J15, VTD = masters D, SEN but will have to add a filter
    // J11 to J18, U23, SEN, VTA to VTP
    $event1 .= $_SESSION["male"].$weight.$dynamic."SEN"; // SEN will be for default age category until worked in
    
    // need to get user's id so I can save to results table as PersonId - $_SESSION["userId"]
    $sql = "SELECT * FROM rowusers WHERE emailUsers=?"; // need to double check the user exists
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../signup.php?error=sqlerror");
            exit(); 
        }
        else {
            $mailuid = $_SESSION["userEmail"];
            mysqli_stmt_bind_param($stmt, "s", $mailuid); 
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                // Update would be "UPDATE results SET (idPerson = ?, date1 = ?, eventType = ?, ........ WHERE idResults = ?)

                if ($edit == "n") {
                    $sql = 'INSERT INTO results (idPerson, date1, eventType, event1, rate, scoreDistance, scoreTime, dynamic1, weight1, ageCat) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                } else if ($edit == "y") {
                    $sql = 'UPDATE results SET idPerson=?, date1=?, eventType=?, event1=?, rate=?, scoreDistance=?, scoreTime=?, dynamic1=?, weight1=?, ageCat=?';
                    $sql .= ' WHERE idResults=?';
                } else {
                    header("Location: ../index.php?error=option_error");
                    exit(); 
                }
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../index.php?error=sqlerror");
                    exit(); 
                }
                else {
                    $personId = $_SESSION["userId"];
                    if ($edit == "n") {
                        mysqli_stmt_bind_param($stmt, "isssiidiis", $personId, $ergDate, $eventType, $event1, $rate, $scoreDistance, $scoreTime, $dynamic, $weight, $ageCat); 
                    } else {
                        mysqli_stmt_bind_param($stmt, "isssiidiisi", $personId, $ergDate, $eventType, $event1, $rate, $scoreDistance, $scoreTime, $dynamic, $weight, $ageCat, $_GET["scoreID"]); 
                    }
                    
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?update_success=".$personId.$row["emailUsers"].$row["club"]); // temporary query string
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