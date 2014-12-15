<?php

define('INCLUDE_DIR', 'inc/');
define('MODULE_DIR', 'modules/');
define('CLASS_DIR', 'classes/');
define('IMG_DIR', 'img/');
define('JS_DIR', 'js/');
define('SCRIPT_DIR', 'scripts/');
define('LIB_DIR', 'libs/');
define('CRON_DIR', 'crons/');

define('SMARTY_DIR', LIB_DIR . '/Smarty/');

require_once(SMARTY_DIR . 'Smarty.class.php');
define('SMARTY_TEMPLATE_DIR', 'templates/');
define('SMARTY_TEMPLATE_С_DIR', SMARTY_TEMPLATE_DIR . 'templates_c/');

require_once(INCLUDE_DIR . 'data.php');
require_once(INCLUDE_DIR . 'url.php');
require_once(INCLUDE_DIR . 'cities_conf.php');

require_once(INCLUDE_DIR . 'alphabet_conf.php');
require_once(CLASS_DIR . 'UserInfo.class.php');


$ui = new UserInfo($DBH);
require_once(INCLUDE_DIR . 'sites_conf.php');
require_once(INCLUDE_DIR . 'proxy_conf.php');
$smarty                = new Smarty;
$smarty->compile_check = true;
$smarty->debugging     = false;
$smarty->template_dir  = SMARTY_TEMPLATE_DIR;
$smarty->compile_dir   = SMARTY_TEMPLATE_С_DIR;

$display_page = 'find.tpl';
switch ($param[1]) {
    case "get_script":
        require_once(MODULE_DIR . 'get_script.php');
        if (!isset($_GET['action'])) {
            $display_page = 'get_script.tpl';
        }
        break;
    case "save_profile":
        require_once(SCRIPT_DIR . 'save_profile.php');
        break;
    case "sync_by_createria":
        require_once(SCRIPT_DIR . 'sync_by_createria.php');
        break;
    case "save_stat":
        require_once(SCRIPT_DIR . 'save_stat.php');
        $display_page = 'blank.tpl';
        break;
    case "sync_all":
        require_once(CRON_DIR . 'sync_all.php');
        $display_page = 'blank.tpl';
        break;
    case "speed":
        $display_page = 'pagespeed.tpl';
        break;
    case "update_all":
        require_once(CRON_DIR . 'update_all.php');
        break;
    case "sync_sites":
        require_once(SCRIPT_DIR . 'sync_sites_config.php');
        exit;
        break;
    case "get_country":
        require_once(SCRIPT_DIR . 'get_country.php');
        break;
    default:
        $display_page = 'find.tpl';
        require_once(MODULE_DIR . 'find.php');
        break;
}
$smarty->assign('APIKEY', $APIKEY);
$smarty->assign('sitesConf', $sites);
$smarty->display($display_page);
