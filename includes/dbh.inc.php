<?php

echo "in dbh require";
//Get Heroku ClearDB connection information
if (!empty(getenv("CLEARDB_DATABASE_URL"))) { // or "" or NULL
    $cleardb_url  = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $servername   = $cleardb_url["host"];
    $dBUsername   = $cleardb_url["user"];
    $dBPassword   = $cleardb_url["pass"];
    $dBName       = substr($cleardb_url["path"],1);
    echo "in if. in heroku db settings";
}
else {  
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "loginsystem";
    echo "in if. in localhost db settings";
}

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
echo "after db connection";
if (!$conn) {
    echo "CONNECTION FAILED";
    die("Connection failed: ".mysqli_connect_error());
    echo "CONNECTION FAILED - AFTER DIE";
}

echo "CONNECTION FAILED - AFTER DIE";

?>