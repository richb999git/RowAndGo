<?php
require "header.php";

echo '<img width=100% src="pics/header2.jpg" alt="rowing 8 header">';

if (isset($_SESSION["userId"])) {

    require "includes/dbh.inc.php"; // don't include a / before folder name (works on localhost but not heroku)
    
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

    $whichErgs = "All"; // default value to stop error if seeLog accessed directly
    $reportType = "Calendar"; // default value to stop error if seeLog accessed directly
    if(isset($_GET["whichErgs"])) {        // from report choice page and now from this page as well
        $whichErgs = $_GET["whichErgs"];   // Mine, Club, All
        $reportType = $_GET["reportType"]; // Calendar, BestAll, BestSeason
    }

    // sort directions 0 or 1
    $dateSort = 0; 
    $eventSort = 0;
    $nameSort = 0;
    $clubSort = 0;
    $splitSort = 0;
    $timeDistSort = 0;
    $sortDir = 0; // overall sort direction

    $cast = ""; // for event sort
    $DATE_COL = "date1";
    $EVENT_SORT_COL = "event1"; // "cast(event1 as unsigned)" or "cast(ts.event1 as unsigned)"
    $ROWER_NAME_COL = "uidUsers"; // "rowusers.uidUsers"; or "ts.uidUsers"
    $ROWER_CLUB_COL = "club"; // "rowusers.club"; or "ts.club"
    $TIME_DIST_COL = "scoreDistance";
    $SPLIT_COL = "split";

    $sortType = $DATE_COL; // default
    if(isset($_GET["sortType"])) {      // returned when pagination used
        $sortType = $_GET["sortType"];
        if ($sortType == "event1") { $sortType = $EVENT_SORT_COL; }
        $sortDir = $_GET["sortDir"];  
    }

    ///////////////    SORT TYPES    //////////////////////////////////////////////

    if(isset($_GET["dateSort"])) {      // returned when sort used
        $sortDir = $_GET["dateSort"]; 
        $sortType = $DATE_COL;
    }
    if(isset($_GET["eventSort"])) {      // returned when sort used
        $sortDir = $_GET["eventSort"];
        $sortType = $EVENT_SORT_COL;
    }
    if(isset($_GET["nameSort"])) {      // returned when sort used
        $sortDir = $_GET["nameSort"];  
        $sortType = $ROWER_NAME_COL;
    }
    if(isset($_GET["clubSort"])) {      // returned when sort used
        $sortDir = $_GET["clubSort"]; 
        $sortType = $ROWER_CLUB_COL;
    }
    if(isset($_GET["timeDistSort"])) {      // returned when sort used
        $sortDir = $_GET["timeDistSort"]; 
        $sortType = $TIME_DIST_COL;
    }
    if(isset($_GET["splitSort"])) {      // returned when sort used
        $sortDir = $_GET["splitSort"]; 
        $sortType = $SPLIT_COL;
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

    $ageCat = 99; // default 99 = no filter
    $ageCatString = "ageCat!=99";
    if(isset($_GET["ageCat"])) {      // returned when filter used
        $ageCat = $_GET["ageCat"];
        if ($ageCat != 99) {
            $ageCatString = "ageCat='".$ageCat."'";

            if ($ageCat == "Masters") {
                $ageCatString = "LEFT(ageCat, 1)='V'";
            } else if ($ageCat == "Juniors") {
                $ageCatString = "LEFT(ageCat, 1)='J'";
            } else if ($ageCat[0] == "M") {
                $ageCatString = "ageCat='VT".substr($ageCat, -1)."'";
            }

        } else {
            $ageCatString = "ageCat!=99"; 
        }
    }
    
    $event2 = 99; // default 99 = no filter
    $event2String = "";
    if(isset($_GET["event2"])) {      // returned when filter used
        $event2 = $_GET["event2"];
        if ($event2 != 99) {
            $event2String = "HAVING event2='".$event2."'";
        } else {
            $event2String = ""; 
        }
    }

    ////////////////////////////////////////////////////////////////////// get required sql query
    require "seeLog/sqlQuery.php";

    $splitSort = $sortDir; // reverses sort direction
    $timeDistSort = $sortDir; // reverses sort direction
    $eventSort = $sortDir; // reverses sort direction
    $nameSort = $sortDir; // reverses sort direction
    $clubSort = $sortDir; // reverses sort direction
    $dateSort = $sortDir; // reverses sort direction


    ////////////////////////////////////////////////////////////////////// get pagination string ready to display
    require "seeLog/paginationString.php";

    ///////////////    TITLE and DROPDOWN FILTERS  ///////////////////////   
    $sortQString = '&sortType='.$sortType.'&sortDir='.$sortDir.'&whichErgs='.$whichErgs.'&reportType='.$reportType;
    echo '
        <main>';
    if ($reportType == "Calendar") {
        echo '<a href="'.$_SERVER["PHP_SELF"].'?reportType='.$reportType.'&whichErgs='.$whichErgs.'" class="btn-small tooltipped" data-position="top" data-tooltip="reset view">Calendar - '.$whichErgs.'</a>';
    } else {
        echo '<a href="'.$_SERVER["PHP_SELF"].'?reportType='.$reportType.'&whichErgs='.$whichErgs.'" class="btn-small tooltipped" data-position="top" data-tooltip="reset view"">Bests - '.$whichErgs.'</a>';
    }   
    echo '<div class="right-align" id="reportDropdowns">';

    ////////////////////////////////////////////////////////////////////// get filters
    require "seeLog/filters.php";


            
    ////////////////////////////////////////////////////////////////////// TABLE HEADERS WITH SORTABLE HEADINGS SHOWN IN BLUE 

    echo '  
            <hr/>
            <table class="striped tableStyle1 centered" >
                <thead>
                    <tr>
                        <th id="editDel"></th>';

    $filterQString = '&male='.$male.'&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&whichErgs='.$whichErgs.'&ageCat='.$ageCat.'&reportType='.$reportType.'&event2='.$event2;              
    
    if ($sortType == $DATE_COL) {
        echo           '<th id="dateCol"><a href="'.$_SERVER["PHP_SELF"].'?dateSort='.!$dateSort.$filterQString.'" class="sortedCol">Date</th>';
    } else {
        echo           '<th id="dateCol"><a href="'.$_SERVER["PHP_SELF"].'?dateSort='.!$dateSort.$filterQString.'" >Date</th>';
    } 
    
    if ($sortType == $EVENT_SORT_COL) {
        echo           '<th id="eventCol"><a href="'.$_SERVER["PHP_SELF"].'?eventSort='.!$eventSort.$filterQString.'" class="sortedCol">Event</th>';
    } else {
        echo           '<th id="eventCol"><a href="'.$_SERVER["PHP_SELF"].'?eventSort='.!$eventSort.$filterQString.'" >Event</th>';
    }

    if ($sortType == $TIME_DIST_COL) {
        echo           '<th><a id="timeDistCol" href="'.$_SERVER["PHP_SELF"].'?timeDistSort='.!$timeDistSort.$filterQString.'" class="sortedCol">Time/Dist</th>';
    } else {
        echo           '<th><a id="timeDistCol" href="'.$_SERVER["PHP_SELF"].'?timeDistSort='.!$timeDistSort.$filterQString.'" >Time/Dist</th>';
    }

    if ($sortType == $SPLIT_COL) {
        echo           '<th><a id="splitCol" href="'.$_SERVER["PHP_SELF"].'?splitSort='.!$splitSort.$filterQString.'" class="sortedCol">/500m</th>';
    } else {
        echo           '<th><a id="splitCol" href="'.$_SERVER["PHP_SELF"].'?splitSort='.!$splitSort.$filterQString.'" >/500m</th>';
    }

    echo '              <th id="dynStdCol">Std/Dyn</th>';
     
    if ($sortType == $ROWER_NAME_COL) {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?nameSort='.!$nameSort.$filterQString.'" class="sortedCol">Name</th>';
    } else {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?nameSort='.!$nameSort.$filterQString.'" >Name</th>';
    }
            
    if ($sortType == $ROWER_CLUB_COL) {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?clubSort='.!$clubSort.$filterQString.'" class="sortedCol">Club</th>';
    } else {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?clubSort='.!$clubSort.$filterQString.'">Club</th>';
    }

    echo '              <th>Gender</th>
                        <th>Weight</th>
                        <th>Age Cat</th>
                    </tr>
                </thead>';


    ///////////////    OUTPUT DATABASE ROWS   /////////////////////////////////////////

    echo '      <tbody>';
    
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
        
        // get dynamic or standard & Light or Heavy & gender
        $row["dynamic1"] == 1 ? $dynamic = "Dynamic" : $dynamic = "Standard";
        $row["weight1"] == 1 ? $weight1 = "Light" : $weight1 = "Heavy";
        $row["male"] == 1 ? $male = "Male" : $male = "Female";
        $event1String = $row["event2"];
        $ageCat = $row["ageCat"];
        if (substr($ageCat, 0, 1) == "V") {
            $ageCat = "Masters ".substr($ageCat,-1);
        }

        // start of part of scores table with values
        echo '              
                    <tr>
                        <td class="reduceColHeight">';
        if ($row["idUsers"] == $_SESSION["userId"]) {
            $editDetails = "addScoreMain.php?edit=y"; 
            $editDetails .= "&date=".$row["date1"];
            $editDetails .= "&rate=".$row["rate"];
            $row["dynamic1"] == 1 ? $editDetails .= "&dynamic=Dynamic" : $editDetails .= "&dynamic=Standard";
            $row["weight1"] == 1 ? $editDetails .= "&weight=Light" : $editDetails .= "&weight=Heavy";
            $row["rate"] != 0 ? $editDetails .= "&event1=".substr($event1String, 0, -3) : $editDetails .= "&event1=".$event1String;
            if ($row["eventType"] == "TIME") {
                $editDetails .= "&distOrTime=time";
                $editDetails .= "&scoreDistance=".$row["scoreDistance"];
            } else {
                $editDetails .= "&distOrTime=distance";
                $m = floor(($row["scoreTime"])/60);
                $s = round(($row["scoreTime"] - round($m * 60))*10)/10;
                $editDetails .= '&scoreMinutes='.$m.'&scoreSeconds='.$s;
            }
            $editDetails .= '&ageCat='.$row["ageCat"];
            $editDetails .= '&scoreID='.$row["idResults"];
            echo '<a href="'.$editDetails.'" class="btn reduceColHeight tooltipped" data-position="top" data-tooltip="Edit/Delete"><i class="tiny material-icons">edit</i></a>';
        }                
        echo '          </td>
        
                        <td>'.date('d-M-Y', strtotime($row["date1"])).'</td>
                        <td>'.$event1String.'</td>
                        <td>'.$score.'</td>
                        <td>'.floatToDateFormat($split).'</td>
                        <td>'.$dynamic.'</td>
                        <td class="tdWidth">'.$row["uidUsers"].'</td>
                        <td class="tdWidth">'.$row["club"].'</td>
                        <td>'.$male.'</td>
                        <td>'.$weight1.'</td>
                        <td>'.$ageCat.'</td>
                    </tr>';
        }

    } else {
        echo "<p class='tableStyle1'>0 results</p>";
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