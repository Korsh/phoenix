<?php

  require(dirname(dirname(__FILE__)).'/libs/nokogiri/nokogiri.php');
  
class UserInfo
{
  var $db;
  var $ch;
  var $main_site;
  var $dc_conf;
  var $dc;
  var $login_url;
  var $find_url;
  var $type;
  var $login;
  var $pass;
  var $site_conf;  
      
  function UserInfo($DBH, $sites)
  {
    $this->db = $DBH;
    $this->admin_url = 'upforit.com/admin/find.php?user=';
    $this->dc = 'pc';
    $this->site_conf = $sites;
    $this->dc_conf = array("pc","lg");
  }
  
  function sync_user_info($createria, $config)
  {         
      $this->set_dc($config);
  
      $this->admin_login();

      curl_setopt($this->ch, CURLOPT_URL, "https://www.".$this->main_site.$this->find_url);
      $find_arr = array(
          "YII_CSRF_TOKEN" => "",
          "FindUserForm" => array(
              "user" => $createria
          )
      );
      curl_setopt($this->ch, CURLOPT_POST, true);  
      curl_setopt($this->ch,CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($find_arr));      
      $out = curl_exec($this->ch);
      
      $html = new nokogiri($out);
      $elements = $html->get(".grid-view")->toArray();
      $count = 0;
      for($i = 0; $i < sizeof($elements); $i++)
      {
            
          $autologin_link = $elements[$i]['table'][0]['tbody'][0]['tr']['td'][3]['a']['href'];
          preg_match_all("/[\S]+userId=([0-9a-z]+)/i",$autologin_link, $matches);
          if($matches[1][0] != '')
          {
            $id_arr[] = trim($matches[1][0]);                        
          }
          
      }

      for($i = 0; $i < sizeof($id_arr); $i++)
      {
          
          curl_setopt($this->ch, CURLOPT_URL, "https://www.".$this->main_site.$this->find_url);
          $find_arr = array(
              "YII_CSRF_TOKEN" => "",
              "FindUserForm" => array(
                  "user" => $id_arr[$i]
              )
          );
          curl_setopt($this->ch, CURLOPT_POST, true);  
          curl_setopt($this->ch,CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($find_arr));      
          $out = curl_exec($this->ch);
          $html = new nokogiri($out);
          $elements = $html->get("#yw1")->toArray();

          $user_info['id'] = $id_arr[$i];
          $user_info['mail'] = $elements[0]['tr'][2]['td'][0]['#text'];
          $user_info['login'] = $elements[0]['tr'][3]['td'][0]['#text'];
          $user_info['password'] = $elements[0]['tr'][4]['td'][0]['#text'];
          $user_info['key'] = $elements[0]['tr'][5]['td'][0]['#text'];
          $user_info['site'] = strtolower($elements[0]['tr'][7]['td'][0]['#text']);
          $user_info['gender'] = strtolower($elements[0]['tr'][8]['td'][0]['#text']);
          $user_info['orientation'] = strtolower($elements[0]['tr'][9]['td'][0]['#text']);
          $user_info['fname'] = strtolower($elements[0]['tr'][10]['td'][0]['#text']);
          $user_info['lname'] = strtolower($elements[0]['tr'][11]['td'][0]['#text']);
          $user_info['country'] = strtolower($elements[0]['tr'][12]['td'][0]['#text']);
          $user_info['birthday'] = strtolower($elements[0]['tr'][13]['td'][0]['#text']);
          $user_info['reg_time'] = strtolower($elements[0]['tr'][14]['td'][0]['#text']);
          $user_info['active'] = strtolower($elements[0]['tr'][20]['td'][0]['#text']);
          
          if(strtolower($elements[0]['tr'][25]['td'][0]['#text']) != 'undefined')
          {              
              $user_info['traffic'] = strtolower($elements[0]['tr'][25]['td'][0]['#text']);
          }
          else
          {
              $user_info['traffic'] = strtolower($elements[0]['tr'][26]['td'][0]['#text']);
          }
          $user_info['platform'] = strtolower($elements[0]['tr'][27]['td'][0]['#text']);
          $user_info['ll'] = strtolower($elements[0]['tr'][15]['td'][0]['#text']).":".strtolower($elements[0]['tr'][16]['td'][0]['#text']);      
          $this->save_sync_user($user_info);   
      }
      $this->sync_dc($createria, $this->dc);

  }
  
  function set_dc($config)
  {
      $this->dc = $config['dc'];
      $this->main_site = $config['site'];
      $this->login_url = $config['login_url'];
      $this->find_url = $config['find_url'];
      $this->type = $config['type'];
      $this->login = $config['login'];
      $this->pass = $config['pass'];         
  }
   
  function admin_login()
  {
      $this->ch = curl_init();
      $post_arr = array(
         "AdminLoginForm" => array(
             "login" => $this->login,
             "password" => $this->pass
         ),
         "YII_CSRF_TOKEN" => "",
         "yt0" => ""          
      );

      curl_setopt($this->ch, CURLOPT_URL, "https://www.".$this->main_site.$this->login_url);
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
      curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
      curl_setopt($this->ch, CURLOPT_POST, true);      
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($post_arr));
      curl_setopt($this->ch,CURLOPT_RETURNTRANSFER, 1);    
      $out = curl_exec($this->ch);                                      
  }
  
  function save_tmp_user($user_info)
  {       
    try
    {
      $insert_tmp_user_info_query = $this->db->prepare("   
        INSERT INTO 
          `temp_profiles`(
            email) 
        VALUES (
            :email            
        )
      ;");
      $insert_tmp_user_info_query->bindValue(':email',$user_info);

      $insert_tmp_user_info_query->execute();
      return true;
    }
    catch(PDOException $e) 
    { 
      echo $e->getMessage();          
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
      return false;  
    } 
  }
  
  function save_sync_user($user_info)
  {
    if(isset($user_info))
    {        
      try
      {  
        $insert_user_info_query = $this->db->prepare("
          INSERT INTO 
            `profiles` (
                `id`,
                `mail`,
                `login`,
                `password`,
                `key`,
                `site`,
                `gender`,
                `orientation`,
                `fname`,
                `lname`,
                `country`,
                `birthday`,
                `reg_time`,
                `active`,
                `traffic`,
                `platform`,
                `ll`
            )
          VALUES (
                :id,
                :mail,
                :login,
                :password,
                :key,
                :site,
                :gender,
                :orientation,
                :fname,
                :lname,
                :country,
                :birthday,
                :reg_time,
                :active,
                :traffic,
                :platform,
                :ll
          )
          ON DUPLICATE KEY UPDATE            
                `mail` = :mail2,
                `login` = :login2,
                `password` = :password2,
                `key` = :key2,
                `site` = :site2,
                `gender` = :gender2,
                `orientation` = :orientation2,
                `fname` = :fname2,
                `lname` = :lname2,
                `country` = :country2,
                `birthday` = :birthday2,
                `reg_time` = :reg_time2,
                `active` = :active2,
                `traffic` = :traffic2,
                `platform` = :platform2,
                `ll` = :ll2
          ;"); 
     
        foreach($user_info as $key => $item)
        {  
          if($key != 'id')
          {            
            $this->bindMultiple($insert_user_info_query, array($key, $key.'2'), $item);
          }
          else
          {
            $insert_user_info_query->bindValue(':id', $item);
          }                                      
        }        
        

        $insert_user_info_query->execute();

        return true;
      }
      catch(PDOException $e) 
      { 
        echo $e->getMessage();          
        file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        return false;  
      }                  
    }  
  }
  
  function bindMultiple($stmt, $params, $variable) 
  {   
    foreach ($params as $param)
    {       
        $stmt->bindValue(':'.$param, $variable);                                              
    }   
  }

  function get_users_for_sync($dc)
  {
    try
    {
      $used_email_query = $this->db->query("
        SELECT 
          `email`
        FROM
          `temp_profiles`
        WHERE
          `".$dc."_sync` != 1
        LIMIT 25
        ;");    
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage();
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
    }      
    
      if($used_email_query->rowCount() > 0)
      {
            
        while($row = $used_email_query->fetch()) 
        {            
          $users[] = $row['email'];
        }
        return $users;
      }
      else
      {
          return false;
      }

  }
  
  function get_users_for_update($dc)
  {
    $date = date('Y-m-d H:i:s', strtotime('-12 hours'));
    try
    {                                                       
      $used_email_for_upd_query = $this->db->prepare("
        SELECT 
          DISTINCT `mail`
        FROM
          `profiles`
        WHERE
          `dc` = :dc
        AND 
          `last_sync` < '".$date."'
        ORDER BY `last_sync` DESC
        LIMIT 25         
        ;");    
                                  
      $used_email_for_upd_query->bindValue(':dc', $dc); 
      $used_email_for_upd_query->execute();    
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage();
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
    }      
 
    if($used_email_for_upd_query->rowCount() > 0)
    {
      while($row = $used_email_for_upd_query->fetch()) 
      {            
        $users[] = $row['mail'];
      }
      return $users;
    }
    else
    {
        return false;
    }
  }
    
  function get_users_for_sync_date($dc)
  {
    try
    {
      $used_email_query = $this->db->prepare("
        SELECT 
          `id`
        FROM
          `profiles`
        WHERE
          `dc` = :dc
          AND
          `reg_time` = '0000-00-00 00:00:00'

        ;");                                     
      $used_email_query->bindValue(':dc', $dc); 
      $used_email_query->execute();    
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage();
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
    }      
    if($used_email_query->rowCount() > 0)
    {
      while($row = $used_email_query->fetch()) 
      {            
        $users[] = $row['id'];
      }
      return $users;
    }
    else
    {
        return false;
    }
  }
  
  function get_createria_list($createria)
  {        
    try
    {
      $list_query = $this->db->prepare("
      SELECT 
        DISTINCT $createria
      FROM
        `profiles`
      ORDER BY $createria ASC
      ;");      
      //$list_query->bindValue(':createria', $createria);
      //$list_query->bindValue(':createria2', $createria);
      
      $list_query->execute();
      $list = array();
      while($row = $list_query->fetch()) 
      {                  
        $list[] = $row[$createria];
      }      
      return $list;
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage().'\r\n';
      file_put_contents('../PDOErrors.txt', $e->getMessage().'\r\n', FILE_APPEND);
      return false;  
    }
  }
  
  function sync_dates($user_id, $site, $config)
  {

    $this->set_dc($config);
    $this->admin_login();  

      curl_setopt($this->ch, CURLOPT_URL, "https://www.".$this->main_site.".com/profiles/search.php?pid=".$user_id."&site".$this->site_conf[$site]['id']);
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
      curl_setopt($this->ch, CURLOPT_POST, true);
      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, "pid=".$user_id."&chk=&action=ajax_profile_details");
      curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
        'X-Requested-With: XMLHttpRequest',
      ));
                                                      
      $out = curl_exec($this->ch);
      curl_close($this->ch);
      $html = new nokogiri($out);
      $elements = $html->get("tr")->toArray();
      
      $reg_str = implode('|',$elements[2]['td'][2]['table'][0]['tr'][4]['td'][3]);
      preg_match("/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/i", $reg_str, $matches);
      $reg = $matches[0];
      
      $conf_str = implode('|',$elements[2]['td'][2]['table'][0]['tr'][5]['td'][3]);
      preg_match("/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/i", $conf_str, $matches);
      $conf = $matches[0];
      
      $traff_str = implode('|',$elements[2]['td'][2]['table'][0]['tr'][6]['td'][3]);
      preg_match("/([\-a-zA-Z]*)/i", $traff_str, $matches);
      $traff = $matches[0];
      try
      {
        $dc_synced_update_query = $this->db->prepare("
          UPDATE 
            `profiles` 
          SET 
            `reg_time` = :reg_time,
            `conf_time` = :conf_time, 
            `traffic` = :traffic,
            `last_sync` = NOW()
          WHERE 
            `id` = :id
        ;");
  
        $dc_synced_update_query->bindParam(':id', $user_id);
        $dc_synced_update_query->bindParam(':reg_time', $reg);
        $dc_synced_update_query->bindParam(':conf_time', $conf);
        $dc_synced_update_query->bindParam(':traffic', $traff);
  
        $dc_synced_update_query->execute();          
      } 
      catch(PDOException $e) 
      {  
        echo $e->getMessage();
        file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
      }
       
  }
  
  function find_by_createrias($createrias, $sort_by, $sort, $page)
  {           
    $createrias_text = $createrias;
    $createrias_text .= " ORDER BY `".$sort_by."` ".$sort;
    try
    { 
      $count = 20;   
      
      $limit_to = $page * $count;
      $limit_from = $limit_to - $count;
 
      $find_by_createria_count = $this->db->prepare("
        SELECT
          count(*)
        FROM
          `profiles`
        $createrias_text
      ;");
      $find_by_createria_count->execute();
      $count_result = $find_by_createria_count->fetch();
         
      $find_by_createria_query = $this->db->prepare("
        SELECT           
                `id`,
                `mail`,
                `login`,
                `password`,
                `key`,
                `site`,
                `gender`,
                `orientation`,
                `fname`,
                `lname`,
                `country`,
                `birthday`,
                `reg_time`,
                `active`,
                `traffic`,
                `platform`,
                `ll`
        FROM
          `profiles`
        $createrias_text
        LIMIT $limit_from, $limit_to
        ;");

      $find_by_createria_query->execute();
    }
    catch(PDOException $e) 
    {      
      echo $e->getMessage(); 
      file_put_contents('../PDOErrors.txt', $e->getMessage().'\r\n', FILE_APPEND);
      return false;  
    }
                 
    if($find_by_createria_query->columnCount() > 0) 
    {
      $i = 0;
      while($row = $find_by_createria_query->fetch()) 
      {
          /*
            
                `login`, `,
                `orientation`,
                `fname`,
                `lname`,         
                `birthday`,          
                `active`,
                `platform`,
                `ll`
           */
        $answer['data'][$i]['site'] = $row['site'];
       // $answer['count'] = $row['count'];         
        $answer['data'][$i]['gender'] = $row['gender'];
        $answer['data'][$i]['country'] = $row['country'];
        $answer['data'][$i]['key'] = $row['key'];
        $answer['data'][$i]['reg_time'] = $row['reg_time'];
        $answer['data'][$i]['id'] = $row['id'];
        $answer['data'][$i]['mail'] = $row['mail'];
        $answer['data'][$i]['password'] = $row['password'];
        $answer['data'][$i]['traffic'] = $row['traffic'];
        $answer['data'][$i]['login'] = $row['login'];
        $answer['data'][$i]['orientation'] = $row['orientation'];
        $answer['data'][$i]['fname'] = $row['fname'];
        $answer['data'][$i]['lname'] = $row['lname'];
        $answer['data'][$i]['birthday'] = $row['birthday'];
        $answer['data'][$i]['active'] = $row['active'];
        $answer['data'][$i]['platform'] = $row['platform'];
        $answer['data'][$i]['ll'] = $row['ll'];        
        $i++;  
      }
      $answer['count'] = $count_result[0];
      $answer['sites'] = $sites;
      $answer['sort_element'] = $sort_by;
      $answer['sort'] = $sort;
      return $answer;
    }
    else
    {
      unset($STH);
      return false;
    }
  }      

  function sync_dc($param, $dc)
  {
    for($i = 0; $i<sizeof($this->dc_conf);$i++)
    {
      $dc_list .= "`".$this->dc_conf[$i]."_sync`,";
    }                     
    $dc_list = trim($dc_list, ",");
    try
    {
      $used_email_query = $this->db->prepare("
        SELECT 
          `email`,
          ".$dc_list."
        FROM
          `temp_profiles`
        WHERE 
          `email` = :param
        ;");                                     
      $used_email_query->bindParam(':param', $param);  
      $used_email_query->execute();     
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage();
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
    }  
    
    if($used_email_query->rowCount() > 0)
    {
        while($row = $used_email_query->fetch()) 
        {       
          if(!$row[$dc.'_sync'] || $row[$dc.'_sync'] == '')
          {                 
            try
            {
              $dc_synced_update_query = $this->db->prepare("
                UPDATE 
                  `temp_profiles` 
                SET 
                  `".$dc."_sync` = 1 
                WHERE 
                  `email` = :curr_mail
                ;");
              $dc_synced_update_query->bindParam(':curr_mail', $param);
              $dc_synced_update_query->execute();          
            } 
            catch(PDOException $e) 
            {  
              echo $e->getMessage();
              file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
            }        
          }

          $flag = false;

          for($i = 0; $i<sizeof($this->dc_conf);$i++)
          {       
            if($row[$this->dc_conf[$i].'_sync'] == 1 && $this->dc_conf[$i] != $dc)
            {
              $flag = true;
            }
          }
          if($flag)
          {
            try
            {
              $dc_synced_delete_query_ph = $this->db->prepare("
                DELETE FROM 
                  `temp_profiles` 
                WHERE 
                  `email` = :curr_mail
                ;");
              $dc_synced_delete_query_ph->bindParam(':curr_mail', $param);
              $dc_synced_delete_query_ph->execute();              
            }
            catch(PDOException $e) 
            {  
              echo $e->getMessage();
              file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
            }      
          }    
        } 
    }
    else
    {
        return false;
    }
  }  

}
?>    