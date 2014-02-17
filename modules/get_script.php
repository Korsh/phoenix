<?

  require_once(INCLUDE_DIR."script_generate.inc.php");
  require_once(LIB_DIR."rfc822/rfc822.php");
  
  if(isset($_GET['action']))
  {
  
    if($_GET['action'] == 'new')
    {
      $script_id = time();
      if(isset($_POST) && (isset($_POST['mail']) && (bool) is_valid_email_address($_POST['mail'])))
      { 
        $keychar = array();
        list($account, $domain) = split('@', $_POST['mail']);
         $options['version'] = $script_id;
         $options['mail']['account'] = $account;
         $options['mail']['domain'] = $domain;
        foreach($script_generate_actions as $key => $option)
        {         
          if(isset($_POST['ctrl_'.$key]))
          {
            $options['keychar'][$key]['condition'][] = "isCtrl";  
          }
          if(isset($_POST['alt_'.$key]))
          {
            $options['keychar'][$key]['condition'][] = "isAlt";
          }
          if(isset($_POST['shift_'.$key]))
          {
            $options['keychar'][$key]['condition'][] = "isShift";
          }
          $options['keychar'][$key]['condition'][] = "is".$_POST['text_'.$key];      
          $options['keychar'][$key]['button'] = $_POST['button_'.$key];
          $options['keychar'][$key]['function'] = $option[0];
          $options['keychar'][$key]['value'] = $option[1];
        }
  
        $file_config = fopen("user_scripts/configs/".$script_id.".txt","w+");
        chmod($file_config, 0777);
        fwrite($file_config, serialize($options));
        
        require_once('user_scripts/userscript.src.php');
    
        $filename = "user_scripts/scripts/".$script_id.".user.js";    
        $file_script = fopen($filename,"w+");
        chmod($file_script, 0777);
        fwrite($file_script, $script_src);                                                                 
        header('Location: '.($filename));
  
      }
      else
      {
        echo 'Не верно указан e-mail!';
        exit;
      }
    }
    elseif($_GET['action'] == 'update' && isset($_GET['id']))
    {   
      
      if(preg_match("/([0-9]+)/",$_GET['id'], $match))
      {
        $script_id = $match[1]; 
        $filename = "user_scripts/configs/".$script_id.".txt";
        $file_config = fopen($filename, "r");
        if ($file_config) 
        {
          $options = unserialize(fread($file_config, filesize($filename)));
        }
        //echo '<pre>'.print_r($options,true).'</pre>';
        require_once('user_scripts/userscript.src.php');
        //echo $script_src;
        
        $filename = "user_scripts/scripts/".$script_id.".user.js";    
        $file_script = fopen($filename,"w+");
        chmod($file_script, 0777);
        fwrite($file_script, $script_src); 
                                                                         
        header('Location: '.($filename));
      } 
    }
    elseif($_GET['action'] == 'meta')
    {
      require_once('user_scripts/meta.js.src.php');
      $filename = "user_scripts/meta.js";    
      $file_script = fopen($filename,"w+");
      chmod($filename, 0777);
      fwrite($file_script, $script_src);
      header('Location: '.($filename));
    }              
  }  

?>