<?php


//Get Heroku ClearDB connection information
if (!empty(getenv("CLEARDB_DATABASE_URL"))) { // or "" or NULL
    $cleardb_url  = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $servername   = $cleardb_url["host"];
    $dBUsername   = $cleardb_url["user"];
    $dBPassword   = $cleardb_url["pass"];
    $dBName       = substr($cleardb_url["path"],1);
}
else {  
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "loginsystem";
}

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}