<?php

//Get Heroku ClearDB connection information
if (!empty(getenv("CLEARDB_DATABASE_URL"))) { // or "" or NULL
    $cleardb_url  = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $servername   = $cleardb_url["host"];
    $dBUsername   = $cleardb_url["user"];
    $dBPassword   = $cleardb_url["pass"];
    $dBName       = substr($cleardb_url["path"],1);
    $port         = 3306; // might not need this
}
else {
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "loginsystem";
    $port = 3310; // for my local mysql because mariadb is on 3306
}

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName, $port);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}
