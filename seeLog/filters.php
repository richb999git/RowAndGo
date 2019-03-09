<?php
    // no direct access allowed
if (isset($event2)) {

    echo   '<div class="right-align" id="reportDropdowns">';
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////    event2 filter (for specific events)

    $event2Q = '&ageCat='.$ageCat.'&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&linesPerPage='.$linesPerPage.$sortQString;

    // show event2 categories only on desktop
    echo       '<a class="dropdown-trigger-filters btn-small red lighten-2 hide-on-med-and-down" href="#" data-target="event2">Event - ';
    if ($event2 == 99 || $event2 == "") { echo 'All</a>'; } 
    else {
        echo $event2.'</a>';
    }
    echo       '<ul id="event2" class="dropdown-content">';  
    echo           '<li><a href="'.$_SERVER["PHP_SELF"].'?event2=99'.$event2Q.'">All</a></li>';
    for ($i = 0; $i < count($event2WRate); $i++) {
        echo       '<li><a href="'.$_SERVER["PHP_SELF"].'?event2='.$event2WRate[$i].$event2Q.'">'.$event2WRate[$i].'</a></li>';
    }
    echo       '</ul>';

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////    Gender filter 

    echo       '<a class="dropdown-trigger-filters btn-small red lighten-2 tooltipped" data-position="top" data-tooltip="filters" href="#" data-target="gender">Gender - ';
    if      ($male == 1) { echo 'Male</a>'; }
    else if ($male == 0) { echo 'Female</a>'; }
    else                 { echo 'All</a>'; }  

    $genderQ = '&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.'&linesPerPage='.$linesPerPage.$sortQString;
    echo       '<ul id="gender" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?male=99'.$genderQ.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?male=1'.$genderQ.'">Male</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?male=0'.$genderQ.'">Female</a></li>
                </ul>';

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////    Weight filter 
                
    echo       '<a class="dropdown-trigger-filters btn-small red lighten-2 tooltipped" data-position="top" data-tooltip="excludes juniors"  href="#" data-target="weight">Weight - ';
    if      ($weight == 1) { echo 'Light</a>'; }
    else if ($weight == 0) { echo 'Heavy</a>'; }
    else                   { echo 'All</a>'; }

    $weightQ = '&male='.$male.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.'&linesPerPage='.$linesPerPage.$sortQString;
    echo       '<ul id="weight" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?weight=99'.$weightQ.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?weight=1'.$weightQ.'">Light</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?weight=0'.$weightQ.'">Heavy</a></li>
                </ul>
            </div>
            <br/><br/>
            <div class="right-align" id="reportDropdowns2">';

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////    Event type filter (TIME/DIST)

    // hide this filter on mobile - insufficent room - prefer to show more results
    echo       '<a class="dropdown-trigger-filters btn-small red lighten-2 hide-on-small-only" href="#" data-target="eventType">Type - ';
    if      ($eventType == 1) { echo 'Time</a>'; }
    else if ($eventType == 0) { echo 'Dist</a>'; }
    else                      { echo 'All</a>'; }   

    $timeDistQ = '&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.'&linesPerPage='.$linesPerPage.$sortQString;
    echo       '<ul id="eventType" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=99'.$timeDistQ.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=1'.$timeDistQ.'">Time</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=0'.$timeDistQ.'">Meters</a></li>
                </ul>';

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////    Age Category filter           

    $ageQ = '&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&event2='.$event2.'&linesPerPage='.$linesPerPage.$sortQString;

    // show full ages categories on desktop
    echo       '<a class="dropdown-trigger-filters btn-small red lighten-2 hide-on-med-and-down" href="#" data-target="ageCat1">Age - ';
    if ($ageCat == 99 || $ageCat == "") { echo 'All</a>'; } 
    else {
        echo $ageCat.'</a>';
    }
    echo       '<ul id="ageCat1" class="dropdown-content">';  
    echo           '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat=99'.$ageQ.'">All</a></li>';
    for ($i = 0; $i < count($ageDescFull); $i++) {
        echo       '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat='.$ageDescFull[$i].$ageQ.'">'.$ageDescFull[$i].'</a></li>';
    }
    echo       '</ul>';


    // only show overall ages catagories on mobile/tablet (doesn't work well with a large list)
    echo       '<a class="dropdown-trigger-filters btn-small red lighten-2 hide-on-large-only tooltipped" data-position="top" data-tooltip="reduced filter (mobile)" href="#" data-target="ageCat2">Age - ';
    if ($ageCat == 99 || $ageCat == "") { echo 'All</a>'; } 
    else {
        echo $ageCat.'</a>';
    }
    echo       '<ul id="ageCat2" class="dropdown-content">';  
    echo           '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat=99'.$ageQ.'">All</a></li>';
    for ($i = 0; $i < count($ageDescSmall); $i++) {
        echo       '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat='.$ageDescSmall[$i].$ageQ.'">'.$ageDescSmall[$i].'</a></li>';
    }
    echo       '</ul>';


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////    Erg Type filter

    echo       '<a class="dropdown-trigger-filters btn-small red lighten-2" href="#" data-target="ergType">Erg - ';
    if      ($dynamic == 1) { echo 'Dynamic</a>'; }
    else if ($dynamic == 0) { echo 'Standard</a>'; }
    else                    { echo 'All</a>'; }      
    
    $ergTypeQ = '&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.'&event2='.$event2.'&linesPerPage='.$linesPerPage.$sortQString;
    echo       '<ul id="ergType" class="dropdown-content">
                    <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=99'.$ergTypeQ.'">All</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=1'.$ergTypeQ.'">Dynamic</a></li>
                    <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=0'.$ergTypeQ.'">Std</a></li>
                </ul>
            </div> 

            <div>
                <p class="scoreCount">'.$scoresNum.' - '.$pageNum.'</p>';

    $overallQ = '&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.'&event2='.$event2.'&dynamic='.$dynamic.$sortQString;
    echo       '<a class="dropdown-trigger-filters red lighten-2 linesButton" href="#" data-target="lines">ROWS</a>
                <ul id="lines" class="dropdown-content rowDropdownH">
                    <li class="rowDropdown"><a href="'.$_SERVER["PHP_SELF"].'?linesPerPage=5'.$overallQ.'">5</a></li>
                    <li class="rowDropdown"><a href="'.$_SERVER["PHP_SELF"].'?linesPerPage=10'.$overallQ.'">10</a></li>
                    <li class="rowDropdown"><a href="'.$_SERVER["PHP_SELF"].'?linesPerPage=15'.$overallQ.'">15</a></li>
                    <li class="rowDropdown"><a href="'.$_SERVER["PHP_SELF"].'?linesPerPage=25'.$overallQ.'">25</a></li>
                    <li class="rowDropdown"><a href="'.$_SERVER["PHP_SELF"].'?linesPerPage=50'.$overallQ.'">50</a></li>
                    <li class="rowDropdown"><a href="'.$_SERVER["PHP_SELF"].'?linesPerPage=100'.$overallQ.'">100</a></li>
                </ul>';

    echo       '<ul class="pagination ">'
                .$pageControls.'
                </ul>
                
            </div>';

} else {
    header("Location: ../index.php?error=nodirectaccess");
    exit(); 
}

