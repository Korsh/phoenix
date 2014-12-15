<?php

$general_sitename = "phoenix";

$errorLevel = E_ALL;
error_reporting($errorLevel);
try {
    $dbHost     = '192.168.12.16';
    $dbUser     = 'arzhanov';
    $dbPassword = 'UksZcnt772a';
    $dbName     = 'arzhanov_phoenix';
    
    $DBH = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
}
catch (PDOException $e) {
    echo $e->getMessage();
    file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}
$DBH->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$APIKEY         = "AIzaSyDN0vK0jFsMgpai2YO1rqqKB7rV1lGPi98";
$scriptVersion = "1.4";

$dcConf = array(
    "pc",
    "lg"
);

$adminConf = array(
    0 => array(
        "dc" => "pc",
        "site" => "my.ufins",
        "loginUrl" => ".com/admin/base/login",
        "findUrl" => ".com/admin/user/find",
        "login" => "arzhanov",
        "pass" => "CiWacMadJej9",
        "type" => "phoenix"
    ),
    1 => array(
        "dc" => "lg",
        "site" => "my.platformphoenix",
        "loginUrl" => ".com/admin/base/login",
        "findUrl" => ".com/admin/user/find",
        "login" => "arzhanov",
        "pass" => "96xaHjhu",
        "type" => "phoenix"
    )
);
