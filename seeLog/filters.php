<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////    event2 filter (for specific events)

$event2NoRate = array("250m","500m","1000m","1500m","2000m","2500m","3000m","5000m","6000m","10000m","12000m","15000m","20000m","21097m","42195m","1min","2mins","3mins","4mins","5mins","6 mins","7mins","10mins","12mins","15mins", "20mins","25mins","30mins","40mins","45mins","50mins","60mins","90mins","120mins");
$event2WRate = array("250m","500m","1000m","1500m","2000m","2000mR24","2000mR26","2000mR28","2500m","3000m","5000m","5000mR24","5000mR26","6000m","10000m","10000mR18","10000mR20","15000m","20000m","20000mR18","21097m","42195m","1min","2mins","3mins","4mins","5mins","6 mins","7mins","10mins","12mins","15mins","20mins","20minsR20","20minsR22","30mins","30minsR18","30minsR20","45mins","45minsR18","45minsR20","60mins","60minsR18","60minsR20");

// show event2 categories only on desktop
echo '<a class="dropdown-trigger btn-small red lighten-2 hide-on-med-and-down tooltipped" data-position="top" data-tooltip="filter" href="#" data-target="event2">Event - ';
if ($event2 == 99 || $event2 == "") { echo 'All</a>'; } 
else {
    echo $event2.'</a>';
}
echo '      <ul id="event2" class="dropdown-content">';  
echo '          <li><a href="'.$_SERVER["PHP_SELF"].'?event2=99&ageCat='.$ageCat.'&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">All</a></li>';
for ($i = 0; $i < count($event2WRate); $i++) {
    echo '<li><a href="'.$_SERVER["PHP_SELF"].'?event2='.$event2WRate[$i];
    echo '&ageCat='.$ageCat.'&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.$sortQString.'">'.$event2WRate[$i].'</a></li>';
}
echo '</ul>';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Gender filter 

echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="gender">Gender - ';
if      ($male == 1) { echo 'Male</a>'; }
else if ($male == 0) { echo 'Female</a>'; }
else                 { echo 'All</a>'; }  
        
echo '      <ul id="gender" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?male=99&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?male=1&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">Male</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?male=0&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">Female</a></li>
            </ul>';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Weight filter 
            
echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="weight">Weight - ';
if      ($weight == 1) { echo 'Light</a>'; }
else if ($weight == 0) { echo 'Heavy</a>'; }
else                   { echo 'All</a>'; }

$weightQ = ".$male.'&eventType='.$eventType.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.";
echo '      <ul id="weight" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?weight=99&male='.$weightQ.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?weight=1&male='.$weightQ.'">Light</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?weight=0&male='.$weightQ.'">Heavy</a></li>
            </ul>
        </div>
        <br/><br/>
        <div class="right-align" id="reportDropdowns2">';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Event type filter (TIME/DIST)

// hide this filter on mobile - insufficent room - prefer to show more results
echo '<a class="dropdown-trigger btn-small red lighten-2 hide-on-small-only" href="#" data-target="eventType">Type - ';
if      ($eventType == 1) { echo 'Time</a>'; }
else if ($eventType == 0) { echo 'Dist</a>'; }
else                      { echo 'All</a>'; }   

echo '      <ul id="eventType" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=99&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=1&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">Time</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?eventType=0&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">Meters</a></li>
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
echo '          <li><a href="'.$_SERVER["PHP_SELF"].'?ageCat=99&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&event2='.$event2.$sortQString.'">All</a></li>';
for ($i = 0; $i < count($ageDescFull); $i++) {
    echo '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat='.$ageDescFull[$i];
    echo '&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&event2='.$event2.$sortQString.'">'.$ageDescFull[$i].'</a></li>';
}
echo '</ul>';


// only show overall ages catagories on mobile/tablet (doesn't work well with a large list)
echo '<a class="dropdown-trigger btn-small red lighten-2 hide-on-large-only tooltipped" data-position="top" data-tooltip="reduced filter (mobile)" href="#" data-target="ageCat2">Age - ';
if ($ageCat == 99 || $ageCat == "") { echo 'All</a>'; } 
else {
    echo $ageCat.'</a>';
}
echo '      <ul id="ageCat2" class="dropdown-content">';  
echo '          <li><a href="'.$_SERVER["PHP_SELF"].'?ageCat=99&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&event2='.$event2.$sortQString.'">All</a></li>';
for ($i = 0; $i < count($ageDescSmall); $i++) {
    echo '<li><a href="'.$_SERVER["PHP_SELF"].'?ageCat='.$ageDescSmall[$i];
    echo '&eventType='.$eventType.'&weight='.$weight.'&male='.$male.'&dynamic='.$dynamic.'&event2='.$event2.$sortQString.'">'.$ageDescSmall[$i].'</a></li>';
}
echo '</ul>';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////    Erg Type filter

echo '<a class="dropdown-trigger btn-small red lighten-2" href="#" data-target="ergType">Erg - ';
if      ($dynamic == 1) { echo 'Dynamic</a>'; }
else if ($dynamic == 0) { echo 'Standard</a>'; }
else                    { echo 'All</a>'; }      
        
echo '      <ul id="ergType" class="dropdown-content">
                <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=99&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">All</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=1&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">Dynamic</a></li>
                <li><a href="'.$_SERVER["PHP_SELF"].'?dynamic=0&weight='.$weight.'&male='.$male.'&eventType='.$eventType.'&ageCat='.$ageCat.'&event2='.$event2.$sortQString.'">Std</a></li>
            </ul>
        </div>   
        <div>
            <p class="tableStyle1">'.$scoresNum.' - '.$pageNum.'</p>
            <ul class="pagination">';
echo  $pageControls.'
            </ul>
            
        </div>';

?>