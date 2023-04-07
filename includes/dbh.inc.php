<?php

//Get Railway.app connection information // Heroku ClearDB connection information
if (!empty(getenv("MYSQL_URL"))) { //CLEARDB_DATABASE_URL"))) { // or "" or NULL
    //$cleardb_url  = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $servername   = getenv("MYSQL_URL"); // MYSQLHOST // $cleardb_url["host"];
    $dBUsername   = getenv("MYSQLUSER"); // $cleardb_url["user"];
    $dBPassword   = getenv("MYSQLPASSWORD"); // $cleardb_url["pass"];
    $dBName       = getenv("MYSQLDATABASE"); // substr($cleardb_url["path"],1);
    $port         = getenv("MYSQLPORT"); // 3306; // might not need this
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
