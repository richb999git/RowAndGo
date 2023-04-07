<?php
if(!isset($_SESSION))
{
    session_start();
}
if (isset($_SESSION["userId"])) {

    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="ergScores.csv"');

    require "includes/dbh.inc.php";

    $output = fopen("php://output", "w");
    fputcsv($output, array("Date", "Event", "Score-Distance (m)", "Score-Time (seconds)", "Split /500m (seconds)", "Erg Type", "Weight", "Age Category"));
    $query = "SELECT date1, left(event1, length(event1)-6 ) as event2, scoreDistance, scoreTime, ";
    $query .= " IFNULL( NULLIF(scoreTime/(event1/500),0), NULLIF(event1*60/(scoreDistance/500),0) ) as split, ";
    $query .= "IF(dynamic1 = 1, 'Dynamic', 'Standard') as dynamic1, ";
    $query .= "IF(weight1 = 1, 'Lightweight', 'Heavyweight') as weight1, ageCat FROM results WHERE idPerson=".$_SESSION["userId"];
    
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);

    echo 'Excel: Divide the number of seconds by 86400 (the number of seconds in a day) and then format the result as a time';

} else {
    header("Location: index.php?error=notloggedin");
    exit(); 
}
