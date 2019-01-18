<?php
    require "header.php";

    echo '<img width=100% src="pics/header2.jpg" alt="rowing 8 header">';
    
    if (isset($_SESSION["userId"])) {

    require "includes/dbh.inc.php"; // don't include a / before folder name (works on localhost but not heroku)

    if(isset($_POST["whichErgs"])) {        // from report choice page
        $whichErgs = $_POST["whichErgs"];   // Mine, Club, All
        $reportType = $_POST["reportType"]; // Calendar, BestAll, BestSeason
    }

    if(isset($_GET["whichErgs"])) {         // from this page (filters & sorts)
        $whichErgs = $_GET["whichErgs"];
        $reportType = $_GET["reportType"];
    } 

    function floatToDateFormat($score) {
        $h = floor($score / (60 * 60));
        $m = floor(($score - ($h * 60 * 60)) / 60);
        $s = floor(($score - ($h * 60 * 60) - ($m * 60)));
        $ts = round(($score - ($h * 60 * 60) - ($m * 60) - $s), 1) * 10;
        $m = str_pad($m, 2, '0', STR_PAD_LEFT);
        $s = str_pad($s, 2, '0', STR_PAD_LEFT);
        return $h.":".$m.":".$s.".".$ts;
    }

    ///////////////////////////////////////////////////////////////////////////////
    //
    //  Query string parameters are used extensively to pass back current status
    //  of data output
    //
    ///////////////////////////////////////////////////////////////////////////////

    // sort directions 0 or 1
    $dateSort = 0; 
    $eventSort = 0;
    $nameSort = 0;
    $clubSort = 0;
    $sortDir = 0; // overall sort direction

    $cast = ""; // for event sort
    $EVENTSORT = "cast(event2 as unsigned)";

    $sortType = "date1"; // default
    if(isset($_GET["sortType"])) {      // returned when pagination used
        $sortType = $_GET["sortType"];
        if ($sortType == "event1") { $sortType = $EVENTSORT; }
        $sortDir = $_GET["sortDir"];  
    }

///////////////    SORT TYPES    ////////////////////////////////////////////

    if(isset($_GET["dateSort"])) {      // returned when sort used
        $sortDir = $_GET["dateSort"]; 
        $sortType = "date1";
    }
    if(isset($_GET["eventSort"])) {      // returned when sort used
        $sortDir = $_GET["eventSort"];
        $sortType = $EVENTSORT;
    }
    if(isset($_GET["nameSort"])) {      // returned when sort used
        $sortDir = $_GET["nameSort"];  
        $sortType = "rowusers.uidUsers";
    }
    if(isset($_GET["clubSort"])) {      // returned when sort used
        $sortDir = $_GET["clubSort"]; 
        $sortType = "rowusers.club";
    }

    

///////////////    FILTERS    //////////////////////////////////////////////

    $male = 99; // default 99 = no filter
    $maleString = "rowusers.male!=99";
    if(isset($_GET["male"])) {      // returned when filter used
        $male = $_GET["male"];
        if ($male != 99) {
            $maleString = "rowusers.male=".$male;
        } else {
            $maleString = "rowusers.male!=99"; 
        }
    }

    $weight = 99; // default 99 = no filter
    $weightString = "weight1!=99";
    if(isset($_GET["weight"])) {      // returned when filter used
        $weight = $_GET["weight"];
        if ($weight != 99) {
            $weightString = "weight1=".$weight;
        } else {
            $weightString = "weight1!=99"; 
        }
    }

    $eventType = 99; // default 99 = no filter
    $eventTypeString = "eventType!=99";
    if(isset($_GET["eventType"])) {      // returned when filter used
        $eventType = $_GET["eventType"];
        if ($eventType != 99) {
            $eventType == 1 ? $eventTypeString = "eventType='TIME'" : $eventTypeString = "eventType='DIST'";
        } else {
            $eventTypeString = "eventType!=99"; 
        }
    }
    
    $dynamic = 99; // default 99 = no filter
    $dynamicString = "dynamic1!=99";
    if(isset($_GET["dynamic"])) {      // returned when filter used
        $dynamic = $_GET["dynamic"];
        if ($dynamic != 99) {
            $dynamicString = "dynamic1=".$dynamic;
        } else {
            $dynamicString = "dynamic1!=99"; 
        }
    }

    

    // filters
    $where = "WHERE ".$weightString." AND ".$maleString." AND ".$eventTypeString." AND ".$dynamicString;

    $group = ""; // was to test fasted ergs but not used now (queries changed)...

///////////////    SQL STATEMENT   //////////////////////////////////////////////  

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
        $sql = "SELECT idResults, idPerson, date1, event1, eventType, scoreDistance, scoreTime, dynamic1, weight1, ageCat, rowusers.idUsers, rowusers.uidUsers, rowusers.male, rowusers.club";
        $sql .= ", left(event1, length(event1)-6 ) as event2 FROM `results` INNER JOIN rowusers ON results.idPerson=rowusers.idUsers ";
        $sql .= $where.$userOrClub.$group." ORDER BY ".$sortType." ".$sortDirSQL.$sortType2;
    }
    
    $where = $weightString." AND ".$maleString." AND ".$eventTypeString." AND ".$dynamicString; // take WHERE off the start for the next queries

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
            //$sql .= " t2 group by left(event1, length(event1)-6 ))  AND ";
            $sql .= "scoreTime in(select min(scoreTime) from ";
            $sql .= "( select * from results inner join rowusers on(idPerson=rowusers.idUsers) WHERE rowusers.club ='".$club."' )";
            $sql .= " t3 group by event1 ) ";
            //$sql .= " t3 group by left(event1, length(event1)-6 ))";  
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


////////////////--------------------------------------------------------------
    //echo "sql = ".$sql;

    
    //$sortDir == "DESC" ? $sortDir = 0: $sortDir = 1;
    $eventSort = $sortDir; // reverses direction
    $nameSort = $sortDir; // reverses direction
    $clubSort = $sortDir; // reverses direction
    $dateSort = $sortDir; // reverses direction

///////////////    PAGINATION CONTROLS STRING CREATION  //////////////////////////

    $result = mysqli_query($conn, $sql);  // <<<<<<< Need to use prepared statements? Is sql injection a risk? No user text can be entered.
    ////////////////////////////////////////////// check for error and handle  <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    $noOfLines = mysqli_num_rows($result);

    $linesPerPage = 15;
    $page = 1;
    if(isset($_GET["page"])) {
        $page = $_GET["page"];
    }
    $lastPage = ceil($noOfLines / $linesPerPage); // rounds up
    $lastPage < 1 ? $lastPage = 1: $lastPage = $lastPage;
    if($page < 1) {
        $page = 1;
    } else if ($page > $lastPage) {
        $page = $lastPage;
    }
    $limit = " LIMIT ". ($page -1) * $linesPerPage.",".$linesPerPage; // from x, and linesPerPage
    $sql .= $limit;
    $result = mysqli_query($conn, $sql);
    $scoresNum = "Scores: $noOfLines";
    $pageNum = "Page $page of $lastPage";

    $pageControls = "";
    $qstring = '&sortType='.$sortType.'&sortDir='.$sortDir.'&male='.$male.'&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic; // use this to pass query string data from sorts and filters
    $qstring .= '&whichErgs='.$whichErgs.'&reportType='.$reportType;
    
    if ($lastPage != 1) { // if more than one page render controls else nothing to render
        // show previous pages on control
        if ($page == 1) {
            $pageControls .= '<li class="disabled"><a href="#"><i class="material-icons">chevron_left</i></a></li>';
        } else {
            $prev = $page - 1;
            $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$prev.$qstring.'"><i class="material-icons">chevron_left</i></a></li>';
            for ($i=$page-8; $i<$page; $i++) {
                if ($i > 0) {
                    $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$i.$qstring.'">'.$i.'</a></li>';
                }
            }
        }
        // show target page number with link on control
        $pageControls .= '<li class="active"><a href="'.$_SERVER["PHP_SELF"].'?page='.$page.$qstring.'">'.$page.'</a></li>';
        // show next pages on control
        for ($i=$page+1; $i<=$lastPage; $i++) {
            $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$i.$qstring.'">'.$i.'</a></li>';
            if ($i >= $page + 8) {
                break;
            }
        }
        if ($page != $lastPage) {
            $nextPage = $page + 1;
            $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$nextPage.$qstring.'"><i class="material-icons">chevron_right</i></a></li>';
        } else {
            $pageControls .= '<li class="disabled"><a href="#"><i class="material-icons">chevron_right</i></a></li>';
        }
    } 

///////////////    TITLE and DROPDOWN FILTERS  //////////////////////////
    
    $sortQString = '&sortType='.$sortType.'&sortDir='.$sortDir.'&whichErgs='.$whichErgs.'&reportType='.$reportType;

    echo '
        <main>';
    if ($reportType == "Calendar") {
        echo '<span class="btn-small">Calendar View</span>';
    } else {
        echo '<span class="btn-small">Bests View</span>';
    }
    
    echo '<div class="right-align" id="reportDropdowns">';
    
    echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="gender">Gender - ';
    if      ($male == 1) { echo 'Male</a>'; }
    else if ($male == 0) { echo 'Female</a>'; }
    else                 { echo 'All</a>'; }  
              
    echo '      <ul id="gender" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?male=99&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.$sortQString.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?male=1&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.$sortQString.'">Male</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?male=0&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.$sortQString.'">Female</a></li>
                </ul>';

 
    echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="weight">Weight - ';
    if      ($weight == 1) { echo 'Light</a>'; }
    else if ($weight == 0) { echo 'Heavy</a>'; }
    else                   { echo 'All</a>'; }    
    
    echo '      <ul id="weight" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?weight=99&male='.$male.'&eventType='.$eventType.'&dynamic='.$dynamic.$sortQString.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?weight=1&male='.$male.'&eventType='.$eventType.'&dynamic='.$dynamic.$sortQString.'">Light</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?weight=0&male='.$male.'&eventType='.$eventType.'&dynamic='.$dynamic.$sortQString.'">Heavy</a></li>
                </ul>
            </div>
            <br/><br/>
            <div class="right-align" id="reportDropdowns2">';

    echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="eventType">Event - ';
    if      ($eventType == 1) { echo 'Time</a>'; }
    else if ($eventType == 0) { echo 'Dist</a>'; }
    else                      { echo 'All</a>'; }   
    
    echo '      <ul id="eventType" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=99&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=1&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">Time</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=0&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">Meters</a></li>
                </ul>';

    echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="ergType">Erg - ';
    if      ($dynamic == 1) { echo 'Dynamic</a>'; }
    else if ($dynamic == 0) { echo 'Standard</a>'; }
    else                    { echo 'All</a>'; }      
              
    echo '      <ul id="ergType" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=99&weight='.$weight.'&male='.$male.'&eventType='.$eventType.$sortQString.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=1&weight='.$weight.'&male='.$male.'&eventType='.$eventType.$sortQString.'">Dynamic</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=0&weight='.$weight.'&male='.$male.'&eventType='.$eventType.$sortQString.'">Std</a></li>
                </ul>
            </div>   
            <div>
                <p class="tableStyle1">'.$scoresNum.' - '.$pageNum.'</p>
                <ul class="pagination">';
    echo  $pageControls.'
                </ul>
                
            </div>
            
            <!-- TABLE HEADERS WITH SORTABLE HEADINGS SHOWN IN BLUE -->
            <hr/>
            <table class="striped tableStyle1 centered" >
                <thead>
                    <tr>
                        <th id="editDel"></th>';

    $filterQString = '&male='.$male.'&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&whichErgs='.$whichErgs.'&reportType='.$reportType;              
    
    if ($sortType == "date1") {
        echo '<th id="dateCol"><a href="'.$_SERVER["PHP_SELF"].'?dateSort='.!$dateSort.$filterQString.'" class="sortedCol">Date</th>';
    } else {
        echo '<th id="dateCol"><a href="'.$_SERVER["PHP_SELF"].'?dateSort='.!$dateSort.$filterQString.'" >Date</th>';
    } 
    
    if ($sortType == $EVENTSORT) {
        echo '<th id="eventCol"><a href="'.$_SERVER["PHP_SELF"].'?eventSort='.!$eventSort.$filterQString.'" class="sortedCol">Event</th>';
    } else {
        echo '<th id="eventCol"><a href="'.$_SERVER["PHP_SELF"].'?eventSort='.!$eventSort.$filterQString.'" >Event</th>';
    }

    echo '              <th id="timeDistCol">Time/Dist</th>
                        <th id="splitCol">/500m</th>
                        <th id="dynStdCol">Std/Dyn</th>';
     
    if ($sortType == "rowusers.uidUsers") {
        echo '<th><a href="'.$_SERVER["PHP_SELF"].'?nameSort='.!$nameSort.$filterQString.'" class="sortedCol">Name</th>';
    } else {
        echo '<th><a href="'.$_SERVER["PHP_SELF"].'?nameSort='.!$nameSort.$filterQString.'" >Name</th>';
    }
            
    if ($sortType == "rowusers.club") {
        echo '<th><a href="'.$_SERVER["PHP_SELF"].'?clubSort='.!$clubSort.$filterQString.'" class="sortedCol">Club</th>';
    } else {
        echo '<th><a href="'.$_SERVER["PHP_SELF"].'?clubSort='.!$clubSort.$filterQString.'">Club</th>';
    }

    echo '              <th>Gender</th>
                        <th>Weight</th>
                        <th>Age Cat</th>
                    </tr>
                </thead>
                <tbody>';


///////////////    OUTPUT DATABASE ROWS   /////////////////////////////////////////
    
    if ($noOfLines) {
        // data loop
        while($row = mysqli_fetch_assoc($result)) {

        // get score and calc split
        if ($row["eventType"] == "DIST") { // event is in meters
            $time = $row["scoreTime"];
            // get distance from event1 description. 
            $dist = $row["event1"];
            settype($dist, "integer"); // turn type into float which ignores the letters if first digit is a number
            $score = $row["scoreTime"];
            $score = floatToDateFormat($score);
        } else {
            // get time from event1 description. 
            $time = $row["event1"] * 60;
            settype($time, "float"); // turn type into float which ignores the letters if first digit is a number
            $dist = $row["scoreDistance"];
            $score = $row["scoreDistance"]."m";
        }
        $split = $time / ($dist / 500);
        
        // show dynamic or standard & Light or Heavy & gender
        $row["dynamic1"] == 1 ? $dynamic = "Dynamic" : $dynamic = "Standard";
        $row["weight1"] == 1 ? $weight1 = "Light" : $weight1 = "Heavy";
        $row["male"] == 1 ? $male = "Male" : $male = "Female";
        $event1String = $row["event2"]; //temporary
        //$event1String = substr($row["event1"], 0, -6); //temporary
        echo '              
                    <tr>
                        <td>';
        if ($row["idUsers"] == $_SESSION["userId"]) { // delete id and send the idResult in the href (along with all the data) ready for editing >>>>>>>>
            echo '<a id="'.$row["idResults"].'" href="#" class="tooltipped" data-position="top" data-tooltip="Edit/Delete"><i class="tiny material-icons">edit</i></a>';
        }                
        echo '          </td>
                        <td>'.$row["date1"].'</td>
                        <td>'.$event1String.'</td>
                        <td>'.$score.'</td>
                        <td>'.floatToDateFormat($split).'</td>
                        <td>'.$dynamic.'</td>
                        <td class="tdWidth">'.$row["uidUsers"].'</td>
                        <td class="tdWidth">'.$row["club"].'</td>
                        <td>'.$male.'</td>
                        <td>'.$weight1.'</td>
                        <td>'.$row["ageCat"].'</td>
                    </tr>';
        }

    } else {
        echo "0 results";
    }

    echo '      </tbody>
            </table>
            <hr>';

    echo '
            <ul class="pagination">';
    echo  $pageControls.'
                        </ul>
    ';

    } else {
        header("Location: index.php?error=notloggedin");
        exit(); 
    }
?>

<?php
    require "footer.php";
?>