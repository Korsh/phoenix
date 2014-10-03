<?php

define('INCLUDE_DIR', dirname(dirname(__FILE__)) . '/inc/');
define('CLASS_DIR', dirname(dirname(__FILE__)) . '/classes/');

require_once(INCLUDE_DIR . 'data.php');
require_once(CLASS_DIR . 'UserInfo.class.php');

$ui = new UserInfo($DBH, $sites);

require_once(INCLUDE_DIR . 'sites_conf.php');

$config = $admin_conf[0];
var_dump($config);

$users = $ui->getUsersForSync($config['dc']);
echo '<pre>' . print_r($users, true) . '</pre>';

for ($y = 0; $y < sizeof($users); $y++) {
    echo $ui->syncUserInfo($users[$y]);
    error_log("Phoenix_sync use: " . memory_get_usage(), 0);
}
