<?php

$sort_by = 'reg_time';
$sort = 'DESC';
$page = 1;
    $createrias = array();
    $createrias_text = '';
    if(strlen($_REQUEST['user_info']) > 4)
    {                            
        $createrias_text = " (`mail` LIKE ('%".$_REQUEST['user_info']."%')
          OR 
            `id` LIKE ('%".$_REQUEST['user_info']."%')   
          OR 
            `login` LIKE ('%".$_REQUEST['user_info']."%')) AND"; 
    }
    
    /*
    if($_REQUEST['reg_time_l'] != '')
    {
      $createrias_text .= " `reg_time` < ".$_REQUEST['reg_time_l'];         
    }
    if($_REQUEST['conf_time_l'] != '')
    {
      $createrias_text .= " `conf_time` < ".$_REQUEST['conf_time'];         
    }
    */
    
    if($_REQUEST['reg_time_ge'] != '')
    {
      $createrias['reg_time_ge'] = $_REQUEST['reg_time_ge'];
    }  
    if($_REQUEST['reg_time_l'] != '')
    {
      $createrias['reg_time_l'] = $_REQUEST['reg_time_l'];
    }     
    if($_REQUEST['mail'] != '')
    {
      $createrias['mail'] = $_REQUEST['mail'];
    }
    if($_REQUEST['id'] != '')
    {
      $createrias['id'] = $_REQUEST['id'];
    }
    if($_REQUEST['site'] != '')
    {
      $createrias['site'] = $_REQUEST['site'];
    }
    if($_REQUEST['gender'] != '')
    {
      $createrias['gender'] = $_REQUEST['gender'];
    }
    if($_REQUEST['country'] != '')
    {
      $createrias['country'] = $_REQUEST['country'];
    }
    if($_REQUEST['traffic'] != '')
    {
      $createrias['traffic'] = $_REQUEST['traffic'];         
    }   
    if($_REQUEST['platform'] != '')
    {
      $createrias['platform'] = $_REQUEST['platform'];         
    }       
    if($_REQUEST['page'] != '')
    {
      $page = $_REQUEST['page'];         
    }
    if(isset($createrias) && is_array($createrias) && sizeof($createrias) > 0)
    {               
      $count = 0;
      foreach($createrias as $key => $item)
      {         
        
          switch($key)
          {
            case "reg_time_ge":
              $createrias_text .= " `reg_time` > '$item' AND `reg_time` > '0000-00-00' AND";
            break;
            case "reg_time_l":
              $createrias_text .= " `reg_time` <= '$item' AND `reg_time` > '0000-00-00' AND";
            break;    
            default:
              $createrias_text .= " `$key` = '$item' AND";
            break;
          }                                                           
        $count++;        
      }
              
    }
    $createrias_text = substr($createrias_text, 0, -4);
      if(!$createrias_text == '')
      {
        $createrias_text = ' WHERE'.$createrias_text;
      }
    if(isset($_REQUEST['sort_element']))
    {       
      $sort_by = $_REQUEST['sort_element'];   
    }
    if(isset($_REQUEST['sort']))
    {
      $sort = $_REQUEST['sort']; 
    }
    
if(isset($_REQUEST['ajax']))
{

 
    $answer = $ui->find_by_createrias($createrias_text, $sort_by, $sort, $page);
    $answer['sites'] = $sites;
    $answer['sort_element'] = $sort_by;
    $answer['sort'] = $sort;
    $answer['count'];
    $pages = (int)($answer['count']/20)+1;
    $answer['pages'] = $pages;
    echo json_encode($answer);
    exit;
}
else
{
  $answer = $ui->find_by_createrias($createrias_text, $sort_by, $sort, $page);  
  $smarty->assign('user_info',$answer['data']);  
  $smarty->assign('pages', (int)($answer['count']/20)+1);
    $site_select_list = $ui->get_createria_list('site');    
    $smarty->assign('site_select_list', $site_select_list);
    $gender_select_list = $ui->get_createria_list('gender');
    $smarty->assign('gender_select_list', $gender_select_list);
    $country_select_list = $ui->get_createria_list('country');
    $smarty->assign('country_select_list', $country_select_list);
    $traffic_select_list = $ui->get_createria_list('traffic');
    $smarty->assign('traffic_select_list', $traffic_select_list);        
    $platform_select_list = $ui->get_createria_list('platform');
    $smarty->assign('platform_select_list', $platform_select_list); 
}
?>