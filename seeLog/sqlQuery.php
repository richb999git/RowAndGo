<?php
// no direct access allowed
if (isset($sortDir)) {
///////////////    SQL STATEMENT   //////////////////////////////////////////////  

    // filters
    $where = $weightString." AND ".$maleString." AND ".$eventTypeString." AND ".$dynamicString." AND ".$ageCatString;
    $having = $event2String;
    $group = ""; // was to test fasted ergs but not used now (queries changed)...

    $sortDir == 0 ? $sortDirSQL = "DESC": $sortDirSQL = "ASC";
    $sortString = $DATE_COL; // default
    $sortType2 = ""; // default
    $userOrClub = ""; // default
    $idPerson = $_SESSION["userId"]; 
    $club = $_SESSION["club"];

    if ($sortType == $TIME_DIST_COL) {
        $sortString = "scoreDistance";
        $sortType2 = ", scoreTime ".$sortDirSQL;
    }

    if ($sortType == $SPLIT_COL) {
        $sortString = "split";
    }

    if ($reportType == "Calendar") {
        
        if ($whichErgs == "Mine") {
            $userOrClub = " AND idPerson=".$idPerson;
        } else if ($whichErgs == "Club") {
            $userOrClub = " AND rowusers.club='".$club."'";
        }

        if ($sortType == $EVENT_SORT_COL) {
            $sortString = "cast(".$EVENT_SORT_COL." as unsigned)";
            $sortType2 = ", rate ".$sortDirSQL;
        } else if ($sortType == $ROWER_NAME_COL) {
            $sortString = "rowusers.".$ROWER_NAME_COL;
        } else if ($sortType == $ROWER_CLUB_COL) {
            $sortString = "rowusers.".$ROWER_CLUB_COL;
        }

        $sql = "SELECT idResults, idPerson, date1, event1, eventType, scoreDistance, scoreTime, dynamic1, weight1, rate, ageCat, rowusers.idUsers, rowusers.uidUsers, rowusers.male, rowusers.club";
        $sql .= ", IFNULL( NULLIF(scoreTime/(event1/500),0), NULLIF(event1*60/(scoreDistance/500),0) ) as split";
        $sql .= ", left(event1, length(event1)-6 ) as event2 FROM `results` INNER JOIN rowusers ON results.idPerson=rowusers.idUsers ";
        $sql .= "WHERE ".$where.$userOrClub.$group." ".$having." ORDER BY ".$sortString." ".$sortDirSQL.$sortType2;
    }
    

    if ($reportType == "BestAll" || $reportType == "BestYear") {

        if ($sortType == $EVENT_SORT_COL) {
            $sortString = "cast(ts.".$EVENT_SORT_COL." as unsigned)";
            $sortType2 = ", rate ".$sortDirSQL;
        } else if ($sortType == $ROWER_NAME_COL) {
            $sortString = "ts.".$ROWER_NAME_COL;
        } else if ($sortType == $ROWER_CLUB_COL) {
            $sortString = "ts.".$ROWER_CLUB_COL;
        } 

        if ($whichErgs == "Mine") {
            $userOrClub = " AND idPerson=".$idPerson;
        } else if ($whichErgs == "Club") {
            $userOrClub = " AND rowusers.club='".$club."'";
        } // else All and no filter - ""
        
        $reportType == "BestYear" ? $thisYear = " AND YEAR(date1) = YEAR(CURDATE()) " : $thisYear = ""; 

        $sql = "SELECT ts.*, left(ts.event1, length(ts.event1)-6 ) as event2 ";
        $sql .= ", IFNULL( NULLIF(scoreTime/(ts.event1/500),0), NULLIF(ts.event1*60/(scoreDistance/500),0) ) as split";
        $sql .= " FROM (";
        $sql .= "SELECT * from results INNER JOIN rowusers on(results.idPerson=rowusers.idUsers) ";
        $sql .= " WHERE ".$where." ";
        $sql .= $userOrClub.$thisYear;
        $sql .= " ) ts ";
        $sql .= "INNER JOIN";
        $sql .= "(SELECT event1, MIN(scoreTime) AS minScore, MAX(scoreDistance) AS maxDistance ";
        $sql .= "FROM (";
        $sql .= "SELECT * from results INNER JOIN rowusers on(results.idPerson=rowusers.idUsers) ";
        $sql .= " WHERE ".$where." ";
        $sql .= $userOrClub.$thisYear;
        $sql .= " ) tmp ";
        $sql .= "GROUP BY event1) groupedts ";
        $sql .= "ON ts.event1 = groupedts.event1 ";
        $sql .= "AND ts.scoreTime = groupedts.minScore AND ts.scoreDistance = groupedts.maxDistance ";
        $sql .= $having;
        $sql .= " ORDER BY ".$sortString." ".$sortDirSQL.$sortType2;

    }

  /////// sql queries in a more readable form:
    /*
    // Best view - new
    SELECT ts.*		
    FROM 		
        (		
        SELECT * from results 		
        INNER JOIN rowusers on(results.idPerson=rowusers.idUsers)		
        where ........................idPerson/rowusers.club AND Year......		
        )		
    ts		
    INNER JOIN		
        (SELECT event1, MIN(scoreTime) AS minScore, MAX(scoreDistance) AS maxDistance		
        FROM		
            (	
            SELECT * from results 	
            inner join rowusers on(results.idPerson=rowusers.idUsers)	
            where .....................idPerson/rowusers.club AND Year......	
            ) tmp	
        GROUP BY event1) groupedts		
    ON ts.event1 = groupedts.event1 		
    AND ts.scoreTime = groupedts.minScore		
    AND ts.scoreDistance = groupedts.maxDistance
    HAVING event2 = '2000m'..................................... or blank		
    ORDER BY `ts`.`event1` ASC	
            
    */  

    //ts = top scores		     
       
    // insert above for individual bests/club bests and current year bests
    // Where idPerson=14		
    // Where rowusers.club="Greenbank"		
    // AND YEAR(date1) = YEAR(CURDATE())


////////////////-------------------- SQL query ------------------------------------------
    // echo ", sql = ".$sql;
    // echo "<br/>**where***:$where";
    // echo "<br/>**userOrClub***:$userOrClub";
    // if (isset($thisYear)) echo "<br/>**thisYear***:$thisYear";
    // echo "<br/>**having***:$having";

} else {
    header("Location: ../index.php?error=nodirectaccess");
    exit(); 
}  
