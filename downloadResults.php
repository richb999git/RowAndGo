
<?php
session_start();
if (isset($_SESSION["userId"])) {

    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="ergScores.csv"');
    header("Pragma: no-cache");
    header("Expires: 0");

    require "includes/dbh.inc.php";

    $output = fopen("php://output", "w");
    fputcsv($output, array("Event","Date", "Score-Distance (m)", "Score-Time (seconds)", "Dynamic(1)/Std(0)", "Lightweight(1)/Heavyweight(0)"));
    $query = "SELECT left(event1, length(event1)-6 ) as event2, date1, scoreDistance, scoreTime, dynamic1, weight1 FROM results WHERE idPerson=".$_SESSION["userId"];
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);


} else {
    header("Location: index.php?error=notloggedin");
    exit(); 
}


?>