<?php

define('INCLUDE_DIR', dirname(dirname(__FILE__)) . '/inc/');
define('CLASS_DIR', dirname(dirname(__FILE__)) . '/classes/');

require_once(INCLUDE_DIR . 'data.php');
//require_once(INCLUDE_DIR . 'sites_conf.php');
require_once(CLASS_DIR . 'UserInfo.class.php');

$ui = new UserInfo($DBH);

require_once(INCLUDE_DIR . 'sites_conf.php');

$users = $ui->getUsersForMarkAsTest();

for ($y = 0; $y < sizeof($users); $y++) {
    $ui->syncUserInfo($users[$y]);
    var_dump($users[$y]);
    echo "Phoenix_sync use: " . memory_get_usage(true)/1024 . "Kb<br>";
    error_log("Phoenix_sync use: " . memory_get_usage(), 0);
}
