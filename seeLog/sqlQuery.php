<?php

///////////////    SQL STATEMENT   //////////////////////////////////////////////  

    // filters
    $where = $weightString." AND ".$maleString." AND ".$eventTypeString." AND ".$dynamicString." AND ".$ageCatString;
    $group = ""; // was to test fasted ergs but not used now (queries changed)...

    $sortDir == 0 ? $sortDirSQL = "DESC": $sortDirSQL = "ASC";
    $sortType == $EVENTSORT ? $sortType2 = ", rate ".$sortDirSQL : $sortType2 = "";
    $idPerson = $_SESSION["userId"]; 
    $club = $_SESSION["club"];

    if ($reportType == "Calendar") {
        // Calendar view - All
        if ($whichErgs == "Mine") {
            $userOrClub = " AND idPerson=".$idPerson;
        } else if ($whichErgs == "Club") {
            $userOrClub = " AND rowusers.club='".$club."'";
        } else {
            $userOrClub = "";
        }
        $sql = "SELECT idResults, idPerson, date1, event1, eventType, scoreDistance, scoreTime, dynamic1, weight1, rate, ageCat, rowusers.idUsers, rowusers.uidUsers, rowusers.male, rowusers.club";
        $sql .= ", left(event1, length(event1)-6 ) as event2 FROM `results` INNER JOIN rowusers ON results.idPerson=rowusers.idUsers ";
        $sql .= "WHERE ".$where.$userOrClub.$group." ORDER BY ".$sortType." ".$sortDirSQL.$sortType2;
    }
    
    if ($reportType == "BestAll" || $reportType == "BestYear") {

        if ($whichErgs == "Mine") {
            $sql = "select *, left(event1, length(event1)-6 ) as event2 from results e";
            $sql .= " inner join rowusers on(e.idPerson=rowusers.idUsers)";
            $sql .= " where scoreDistance in(select max(scoreDistance) from results WHERE idPerson=".$idPerson." group by event1 )  AND";
            $sql .= " scoreTime in(select min(scoreTime) from results WHERE idPerson=".$idPerson." group by event1 )";
            $sql .= " AND idPerson=".$idPerson;
            $sql .= " AND ".$where.$group;
            if ($reportType == "BestYear") {$sql .=" HAVING YEAR(date1) = YEAR(CURDATE())";}
            $sql .= " ORDER BY ".$sortType." ".$sortDirSQL.$sortType2;

        } else if ($whichErgs == "Club") {
            $sql = "select *, left(event1, length(event1)-6 ) as event2 from results";
            $sql .= " inner join rowusers on(idPerson=rowusers.idUsers)";
            $sql .= "where scoreDistance in(select max(scoreDistance) from ";
            $sql .= "( select * from results inner join rowusers on(idPerson=rowusers.idUsers) WHERE rowusers.club ='".$club."' )";
            $sql .= " t2 group by event1)  AND ";
            //$sql .= " t2 group by left(event1, length(event1)-6 ))  AND "; // alternative group
            $sql .= "scoreTime in(select min(scoreTime) from ";
            $sql .= "( select * from results inner join rowusers on(idPerson=rowusers.idUsers) WHERE rowusers.club ='".$club."' )";
            $sql .= " t3 group by event1 ) ";
            //$sql .= " t3 group by left(event1, length(event1)-6 ))"; // alternative group
            $sql .= "HAVING rowusers.club ='".$club."' AND ".$where; // where here is in Having
            if ($reportType == "BestYear") {$sql .=" AND YEAR(date1) = YEAR(CURDATE())";}
            $sql .= " ORDER BY ".$sortType." ".$sortDirSQL.$sortType2;

        } else {  // All
            $sql = "select *, left(event1, length(event1)-6 ) as event2 from results e";
            $sql .= " inner join rowusers on(e.idPerson=rowusers.idUsers)";
            $sql .= " where scoreDistance in(select max(scoreDistance) from results group by event1 )  AND";
            $sql .= " scoreTime in(select min(scoreTime) from results group by event1 )";
            $sql .= " AND ".$where;
            if ($reportType == "BestYear") {$sql .=" AND YEAR(date1) = YEAR(CURDATE()) ";}
            $sql .= $group." ORDER BY ".$sortType." ".$sortDirSQL.$sortType2;            
        }
    }

  /////// sql queries in a more readable form:

  //// Bests view - overall using event1
    /*
    select * from results e
    inner join rowusers d on(e.idPerson=d.idUsers)
    where scoreDistance in(select max(scoreDistance) from results group by event1 )  AND
    scoreTime in(select min(scoreTime) from results group by event1 )
    AND WHERE xxxxxxxxxx
    ORDER BY xxxxxxx
    */


  //// Bests view - individual using event1
    /*
    select * from results e
    inner join rowusers d on(e.idPerson=d.idUsers)
    where scoreDistance in(select max(scoreDistance) from results WHERE idPerson=11 group by event1)  AND
    scoreTime in(select min(scoreTime) from results WHERE idPerson=11 group by event1 )
    AND idPerson=11
    AND WHERE xxxxxxxxxx
    ORDER BY xxxxxxx
    */


  //// Bests view - club using event1
    /*
    select * from results
    inner join rowusers on(idPerson=rowusers.idUsers)
    where scoreDistance in(select max(scoreDistance) from 
    (
        select * from results 
        inner join rowusers on(idPerson=rowusers.idUsers)
        WHERE rowusers.club ="Greenbank" 
    ) t2 group by event1)  AND
    scoreTime in(select min(scoreTime) from 
    (             
        select * from results 
        inner join rowusers on(idPerson=rowusers.idUsers)
        WHERE rowusers.club ="Greenbank"            
    ) t3 group by event1 )
    HAVING xxxxxxxxxxxxx
    ORDER BY xxxxxxx

    */


////////////////-------------------- SQL query ------------------------------------------
    //echo ", sql = ".$sql;

?>