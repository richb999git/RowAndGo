<?php
    // no direct access allowed
if (isset($sortType)) {

    echo   '         <tr>
                        <th id="editDel"></th>';

    $filterQString = '&male='.$male.'&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&whichErgs='.$whichErgs.'&ageCat='.$ageCat.'&reportType='.$reportType.'&event2='.$event2.'&linesPerPage='.$linesPerPage;              
    
    if ($sortType == $DATE_COL) {
        echo           '<th class="dateCol"><a href="'.$_SERVER["PHP_SELF"].'?dateSort='.!$dateSort.$filterQString.'" class="sortedCol">Date</th>';
    } else {
        echo           '<th class="dateCol"><a href="'.$_SERVER["PHP_SELF"].'?dateSort='.!$dateSort.$filterQString.'" >Date</th>';
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

    if ($sortType == $ROWER_CLUB_COL) {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?clubSort='.!$clubSort.$filterQString.'" class="sortedCol">Club</th>';
    } else {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?clubSort='.!$clubSort.$filterQString.'">Club</th>';
    }
     
    if ($sortType == $ROWER_NAME_COL) {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?nameSort='.!$nameSort.$filterQString.'" class="sortedCol">Name</th>';
    } else {
        echo           '<th><a href="'.$_SERVER["PHP_SELF"].'?nameSort='.!$nameSort.$filterQString.'" >Name</th>';
    }
            
    echo '              <th>Gender</th>
                        <th class="ageCol">Age Cat</th>
                        <th>Weight</th>
                        <th>Std/Dyn</th>
                    </tr>';

} else {
    header("Location: ../index.php?error=nodirectaccess");
    exit(); 
}  


