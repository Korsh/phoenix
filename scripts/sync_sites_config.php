<?
/*define('INCLUDE_DIR', dirname(dirname(__FILE__)) . '/inc/');
define('CLASS_DIR', dirname(dirname(__FILE__)) . '/classes/');

require_once(INCLUDE_DIR . 'data.php');
require_once(CLASS_DIR . 'UserInfo.class.php');*/

$ui = new UserInfo($DBH);

$ui->syncSitesConfig($adminConf[0]);
