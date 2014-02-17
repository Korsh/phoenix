<?

  require(dirname(dirname(__FILE__)).'/libs/nokogiri/nokogiri.php');
  
class UserInfo
{
  var $db;
  var $ch;
  var $ch_phoenix;
  var $main_site;
  var $dc_conf;
  
  function UserInfo($DBH)
  {
    $this->db = $DBH;
    $admin_url = 'upforit.com/admin/find.php?user=';
    $dc = 'am';
    $this->dc_conf = array("am","ga","ph","lg");
  }
  
  function sync_user_info($createria, $config)
  {         
    $this->set_dc($config);
  
    
    if($this->type == "multisite")
    {  
      $this->admin_login_multisite();
      curl_setopt($this->ch, CURLOPT_URL, "https://www.".$this->find_url.urlencode($createria));
                                                    
      $out = curl_exec($this->ch);
      curl_close($this->ch);  
      //$phpQuery = new phpQuery();
      $html = new nokogiri($out);
      //$html = $phpQuery->newDocumentHTML($out, $charset = 'utf-8');

      $elements = $html->get(".user_info")->toArray();

      $count = 0;
      if(sizeof($elements)>0)
      {   

        foreach($elements as $element) 
        {  
          $user_info_text = '';
          $user_info = array();  
          echo '<pre>'.print_r($element,true).'</pre>';                    
          foreach($element['div'][6]['small'] as $item)
          {
            $user_info_text .= $item['#text'].'~';
          } 
                                          
          preg_match_all("/id: ([0-9]*)~/i",$user_info_text, $matches);
          $user_info['id'] = trim($matches[1][0]);
          preg_match_all("/xid: ([0-9]*)~/i",$user_info_text, $matches);  
          $user_info['xid'] = trim($matches[1][0]);
          preg_match_all("/oid: ([0-9]*)~/i",$user_info_text, $matches);  
          $user_info['oid'] = trim($matches[1][0]);
          preg_match_all("/E-mail: ([._\+a-z0-9]*@[.a-z0-9]*[a-z0-9]*.[^~a-z0-9]*)~/i",$user_info_text, $matches);  
          $user_info['mail'] = trim($matches[1][0]);
          preg_match_all("/Password: ([^~.]*)~/i",$user_info_text, $matches);  
          $user_info['password'] = trim($matches[1][0]);
          preg_match_all("/Reg type: ([^~.]*)~/i",$user_info_text, $matches);  
          $user_info['reg_type'] = trim($matches[1][0]);
          if($user_info['reg_type'] == 'WAP site registration (JS compatible device)')
          {
            $user_info['reg_type'] = 'JS';
          }
          elseif($user_info['reg_type'] == 'WAP site registration (non JS compatible device)')
          {
            $user_info['reg_type'] = 'Non-JS';
          }
          
          preg_match_all("/Country: .*\(([^~.]*)\)~/i",$user_info_text, $matches);  
          $user_info['country'] = trim($matches[1][0]);
          preg_match_all("/~Mobile: ([0-9]*)~/i",$user_info_text, $matches);  
          $user_info['mobile'] = trim($matches[1][0]);
          if($user_info['mobile'] == '')
          {
            $user_info['mobile'] = 0;
          }
  
          $autologin_html = $html->get("[class=autologin]")->toArray(); 
          preg_match_all("/.*\/([a-z0-9]*)\/autologin.php.*/i", $autologin_html[$count]['href'], $matches);
          $user_info['key'] = trim($matches[1][0]); 
  
          preg_match_all("/([a-z]*)\.[a-z]*\/[a-z0-9]*\/autologin.php.*/i", $autologin_html[$count]['href'], $matches);
          $user_info['site'] = trim($matches[1][0]);         
          $user_info['dc'] = $this->dc;
  
          $screenname_html = $html->get("span[title=screenname]")->toArray();
          $user_info['screenname'] = $screenname_html[$count]['#text'];
  
          $expired_html = $html->get("#membership_expire_".$user_info['id'])->toArray();
          $user_info['expired'] = $expired_html[0]['#text'];
          
          $gender_html = $html->get("#user_gender_".$user_info['id'])->toArray();
          $user_info['gender'] = $gender_html[0]['#text'];
  
          //$pay_status_html = $html->get("span[title=membership status]")->toArray();
          $line1_html = $html->get(".line1")->toArray();
  
          if(sizeof($html->get("#multi_scam_".$user_info['id'])->toArray()) > 0)
          {
            $user_info['pay_status'] = $line1_html[$count]['div'][2]['span']['#text'];
          }
          else
          {
            $user_info['pay_status'] = $line1_html[$count]['div'][1]['span']['#text'];        
          }
          if($this->save_sync_user($user_info))
          {
            $this->sync_dates($user_info['id'], $dc);           
          }
          $count++;        
        }               
      }
      //$this->sync_dc($createria, $this->dc);
      return $count;
    }
    else if($this->type == "phoenix")
    {
      $this->admin_login_phoenix();
      curl_setopt($this->ch_phoenix, CURLOPT_URL, "https://www.".$this->find_url.urlencode($createria));                                                          
      $out = curl_exec($this->ch_phoenix);   
      curl_close($this->ch_phoenix);  
      //$phpQuery = new phpQuery();
      $html = new nokogiri($out);
 
    }

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
   
  function admin_login_multisite()
  {       

      $this->ch = curl_init();
      $post = array('guid'=>$this->login,'pwd'=>$this->pass,'login'=>'Login');
      curl_setopt($this->ch, CURLOPT_URL, "https://www.upforit.com/base/login.php");//.$this->main_site.$this->login_url);
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');       
      curl_setopt($this->ch, CURLOPT_POST, true);
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,0);  
      echo $out = curl_exec($this->ch);   
  }
  
  function admin_login_phoenix()
  {
      $this->ch_phoenix = curl_init();
          //echo "https://www.".$this->main_site.$this->login_url;
      curl_setopt($this->ch_phoenix, CURLOPT_URL, "https://www.".$this->main_site.$this->login_url);
      curl_setopt($this->ch_phoenix, CURLOPT_COOKIEJAR, 'cookie.txt');
      curl_setopt($this->ch_phoenix, CURLOPT_COOKIEFILE, 'cookie.txt');
      curl_setopt($this->ch_phoenix, CURLOPT_POST, true);      
      curl_setopt($this->ch_phoenix, CURLOPT_POSTFIELDS, "AdminLoginForm[login]=".$this->login."&AdminLoginForm[password]=".$this->pass."&YII_CSRF_TOKEN&yt0");
      curl_setopt($this->ch_phoenix,CURLOPT_RETURNTRANSFER,0);    
      echo $out = curl_exec($this->ch_phoenix);                                      
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
              `xid`,
              `oid`,
              `mail`,
              `mobile`,
              `screenname`,
              `password`,
              `reg_type`,
              `country`,
              `gender`,
              `key`,
              `pay_status`,
              `expired`,
              `site`,
              `dc`
            )
          VALUES (
            :id,
            :xid,
            :oid,
            :mail,
            :mobile,
            :screenname,
            :password,
            :reg_type,
            :country,
            :gender,
            :key,
            :pay_status,
            :expired,
            :site,
            :dc                           
          )
          ON DUPLICATE KEY UPDATE            
            `xid` = :xid2,
            `oid` = :oid2,
            `mail` = :mail2,
            `mobile` = :mobile2,
            `screenname` = :screenname2,
            `password` = :password2,
            `reg_type` = :reg_type2,
            `country` = :country2,
            `gender` = :gender2,
            `key` = :key2,
            `pay_status` = :pay_status2,
            `expired` = :expired2,
            `site` = :site2,
            `dc` = :dc2                      
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
      $used_email_query = $this->db->prepare("
        SELECT 
          `email`
        FROM
          `temp_profiles`
        WHERE
          `".$dc."_sync` != 1
        LIMIT 300
        ;");                    
      $used_email_query->execute();    
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage();
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
    }      
 
      while($row = $used_email_query->fetch()) 
      {            
        $users[] = $row['email'];
      }
      return $users;

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
        LIMIT 300         
        ;");    
                                  
      $used_email_for_upd_query->bindValue(':dc', $dc); 
      $used_email_for_upd_query->execute();    
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage();
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
    }      
 
      while($row = $used_email_for_upd_query->fetch()) 
      {            
        $users[] = $row['mail'];
      }
      return $users;
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
 
      while($row = $used_email_query->fetch()) 
      {            
        $users[] = $row['id'];
      }
      return $users;

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
  
  function sync_dates($user_id, $config)
  {

    $this->set_dc($config);
    $this->admin_login();  
    
    if($this->type == "multisite")
    {    
      curl_setopt($this->ch, CURLOPT_URL, "https://www.".$this->main_site.$this->find_url.$user_id);
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
      curl_setopt($this->ch, CURLOPT_POST, true);
      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, "pid=$user_id&chk=&action=ajax_profile_details");
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
          `xid`, 
          `oid`,        
          `mail`,
          `mobile`,
          `screenname`,
          `password`,
          `reg_type`,
          `reg_time`,
          `conf_time`,
          `country`,
          `gender`, 
          `key`,
          `pay_status`,
          `expired`,
          `site`,
          `dc`,
          `traffic`
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
        $answer['data'][$i]['site'] = $row['site'];
       // $answer['count'] = $row['count'];         
        $answer['data'][$i]['gender'] = $row['gender'];
        $answer['data'][$i]['country'] = $row['country'];
        $answer['data'][$i]['key'] = $row['key'];
        $answer['data'][$i]['reg_time'] = $row['reg_time'];
        $answer['data'][$i]['conf_time'] = $row['conf_time'];
        $answer['data'][$i]['id'] = $row['id'];
        $answer['data'][$i]['xid'] = $row['xid'];
        $answer['data'][$i]['oid'] = $row['oid'];
        $answer['data'][$i]['mail'] = $row['mail'];
        $answer['data'][$i]['mobile'] = $row['mobile'];
        $answer['data'][$i]['screenname'] = $row['screenname'];
        $answer['data'][$i]['password'] = $row['password'];
        $answer['data'][$i]['reg_type'] = $row['reg_type'];
        $answer['data'][$i]['pay_status'] = $row['pay_status'];
        $answer['data'][$i]['expired'] = $row['expired'];
        $answer['data'][$i]['dc'] = $row['dc'];
        $answer['data'][$i]['traffic'] = $row['traffic'];
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
      $used_email_query_ph = $this->db->prepare("
        SELECT 
          `email`,
          ".$dc_list."
        FROM
          `temp_profiles`
        WHERE 
          `email` = :param
        ;");                                     
      $used_email_query_ph->bindParam(':param', $param);  
      $used_email_query_ph->execute();     
    }
    catch(PDOException $e) 
    {  
      echo $e->getMessage();
      file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
    }  
    
    while($row = $used_email_query_ph->fetch()) 
    {       
      if(!$row[$dc.'_sync'])
      {                 
        try
        {
          
          $dc_synced_update_query_ph = $this->db->prepare("
            UPDATE 
              `temp_profiles` 
            SET 
              `".$dc."_sync` = 1 
            WHERE 
              `email` = :curr_mail
            ;");
          $dc_synced_update_query_ph->bindParam(':curr_mail', $param);
          $dc_synced_update_query_ph->execute();          
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
        if(!$row[$dc_conf[$i].'_sync'])
        {
          $flag = true;
        }
      }
      if(!$flag)
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
          //$dc_synced_delete_query_ph->execute();              
        }
        catch(PDOException $e) 
        {  
          echo $e->getMessage();
          file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
        }      
      }    
    }   
  }  

}
?>    