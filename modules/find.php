<?php

$sortBy         = 'reg_time';
$sort            = 'DESC';
$page            = 1;
$createrias      = array();
$createriasText = '';
    if(!empty($_REQUEST['userInfo']) && strlen($_REQUEST['userInfo']) > 4) {
        $createriasText = " (`mail` LIKE ('%" . $_REQUEST['userInfo'] . "%')
              OR 
                `id` LIKE ('%" . $_REQUEST['userInfo'] . "%')   
              OR 
                `login` LIKE ('%" . $_REQUEST['userInfo'] . "%')) AND";
    }


    if(!empty($_REQUEST['regTimege']) && $_REQUEST['regTimege'] != '') {
        $createrias['regTimege'] = $_REQUEST['regTimege'];
    }
    if(!empty($_REQUEST['regTimel']) && $_REQUEST['regTimel'] != '') {
        $createrias['regTimel'] = $_REQUEST['regTimel'];
    }
    if(!empty($_REQUEST['mail']) && $_REQUEST['mail'] != '') {
        $createrias['mail'] = $_REQUEST['mail'];
    }
    if(!empty($_REQUEST['id']) && $_REQUEST['id'] != '') {
        $createrias['id'] = $_REQUEST['id'];
    }
    if(!empty($_REQUEST['site']) && $_REQUEST['site'] != '') {
        $createrias['site'] = $_REQUEST['site'];
    }
    if(!empty($_REQUEST['gender']) && $_REQUEST['gender'] != '') {
        $createrias['gender'] = $_REQUEST['gender'];
    }
    if(!empty($_REQUEST['country']) && $_REQUEST['country'] != '') {
        $createrias['country'] = $_REQUEST['country'];
    }
    if(!empty($_REQUEST['traffic']) && $_REQUEST['traffic'] != '') {
        $createrias['traffic'] = $_REQUEST['traffic'];
    }
    if(!empty($_REQUEST['platform']) && $_REQUEST['platform'] != '') {
        $createrias['platform'] = $_REQUEST['platform'];
    }
    if(!empty($_REQUEST['page']) && $_REQUEST['page'] != '') {
        $page = $_REQUEST['page'];
    }

    if(isset($createrias) && is_array($createrias) && sizeof($createrias) > 0) {
        $count = 0;
        foreach ($createrias as $key => $item) {
            
            switch ($key) {
                case "regTimege":
                    $createriasText .= " `reg_time` > '$item' AND `reg_time` > '0000-00-00' AND";
                    break;
                case "regTimel":
                    $createriasText .= " `reg_time` <= '$item' AND `reg_time` > '0000-00-00' AND";
                    break;
                case "site":
                    $createriasText .= " `sites_config`.`site_name` = '$item' AND";
                    break;
                default:
                    $createriasText .= " `$key` = '$item' AND";
                    break;
            }
            $count++;
        }
        
    }
    $createriasText = substr($createriasText, 0, -4);
    if(!$createriasText == '') {
        $createriasText = ' AND' . $createriasText;
    }
    if(isset($_REQUEST['sortElement'])) {
        $sortBy = $_REQUEST['sortElement'];
    }
    if(isset($_REQUEST['sort'])) {
        $sort = $_REQUEST['sort'];
    }
    if(isset($_REQUEST['ajax'])) {
        $answer                 = $ui->findByCreaterias($createriasText, $sortBy, $sort, $page);
        $answer['sites']        = $sites;
        $answer['sortElement'] = $sortBy;
        $answer['sort']         = $sort;
        $answer['count'];
        $pages           = (int) ($answer['count'] / 20) + 1;
        $answer['pages'] = $pages;
        echo json_encode($answer);
        exit;
    } else {
        $answer = $ui->findByCreaterias($createriasText, $sortBy, $sort, $page);
        $smarty->assign('userInfo', $answer['data']);
        $smarty->assign('pages', (int) ($answer['count'] / 20) + 1);
        $siteSelectList = $ui->getSiteList();
        $smarty->assign('siteSelectList', $siteSelectList);
        $genderSelectList = $ui->getCreateriaList('gender');
        $smarty->assign('genderSelectList', $genderSelectList);
        $countrySelectList = $ui->getCreateriaList('country');
        $smarty->assign('countrySelectList', $countrySelectList);
        $trafficSelectList = $ui->getCreateriaList('traffic');
        $smarty->assign('trafficSelectList', $trafficSelectList);
        $platformSelectList = $ui->getCreateriaList('platform');
        $smarty->assign('platformSelectList', $platformSelectList);
    }
