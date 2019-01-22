<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Gender filter 

echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="gender">Gender - ';
if      ($male == 1) { echo 'Male</a>'; }
else if ($male == 0) { echo 'Female</a>'; }
else                 { echo 'All</a>'; }  
        
echo '      <ul id="gender" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?male=99&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?male=1&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">Male</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?male=0&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">Female</a></li>
            </ul>';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Weight filter 
            
echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="weight">Weight - ';
if      ($weight == 1) { echo 'Light</a>'; }
else if ($weight == 0) { echo 'Heavy</a>'; }
else                   { echo 'All</a>'; }    

echo '      <ul id="weight" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?weight=99&male='.$male.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?weight=1&male='.$male.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">Light</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?weight=0&male='.$male.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">Heavy</a></li>
            </ul>
        </div>
        <br/><br/>
        <div class="right-align" id="reportDropdowns2">';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Event type filter 

// hide this filter on mobile - insufficent room - prefer to show more results
echo '<a class="dropdown-trigger btn-small red lighten-2 hide-on-small-only" href="#" data-target="eventType">Event - ';
if      ($eventType == 1) { echo 'Time</a>'; }
else if ($eventType == 0) { echo 'Dist</a>'; }
else                      { echo 'All</a>'; }   

echo '      <ul id="eventType" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=99&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=1&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">Time</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=0&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&ageCat='.$ageCat.$sortQString.'">Meters</a></li>
            </ul>';

////////////////////////////////////////////////////////////////////////////////////////////////////////////    Age Category filter           

$ageDescFull = array("SEN","U23","Juniors","Masters","J18","J17","J16","J15","J14","J13","J12","J11","MastersA","MastersB","MastersC","MastersD","MastersE","MastersF","MastersG","MastersH","MastersI","MastersJ");
$ageDescSmall = array("SEN","U23","Juniors","Masters");

// show full ages categories on desktop
echo '<a class="dropdown-trigger btn-small red lighten-2 hide-on-med-and-down tooltipped" data-position="top" data-tooltip="filter" href="#" data-target="ageCat1">Age - ';
if ($ageCat == 99 || $ageCat == "") { echo 'All</a>'; } 
else {
    echo $ageCat.'</a>';
}
echo '      <ul id="ageCat1" class="dropdown-content">';  
echo '          <li><a href="'.$_SERVER["PHP_SELF"].'?ageCat=99&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">All</a></li>';
for ($i = 0; $i < count($ageDescFull); $i++) {
    echo '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat='.$ageDescFull[$i];
    echo '&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">'.$ageDescFull[$i].'</a></li>';
}
echo '</ul>';


// only show overall ages catagories on mobile/tablet (doesn't work well with a large list)
echo '<a class="dropdown-trigger btn-small red lighten-2 hide-on-large-only tooltipped" data-position="top" data-tooltip="reduced filter (mobile)" href="#" data-target="ageCat2">Age - ';
if ($ageCat == 99 || $ageCat == "") { echo 'All</a>'; } 
else {
    echo $ageCat.'</a>';
}
echo '      <ul id="ageCat2" class="dropdown-content">';  
echo '          <li><a href="'.$_SERVER["PHP_SELF"].'?ageCat=99&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">All</a></li>';
for ($i = 0; $i < count($ageDescSmall); $i++) {
    echo '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat='.$ageDescSmall[$i];
    echo '&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">'.$ageDescSmall[$i].'</a></li>';
}
echo '</ul>';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Erg Type filter

echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="ergType">Erg - ';
if      ($dynamic == 1) { echo 'Dynamic</a>'; }
else if ($dynamic == 0) { echo 'Standard</a>'; }
else                    { echo 'All</a>'; }      
        
echo '      <ul id="ergType" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=99&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.$sortQString.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=1&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.$sortQString.'">Dynamic</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=0&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.$sortQString.'">Std</a></li>
            </ul>
        </div>   
        <div>
            <p class="tableStyle1">'.$scoresNum.' - '.$pageNum.'</p>
            <ul class="pagination">';
echo  $pageControls.'
            </ul>
            
        </div>';

?>