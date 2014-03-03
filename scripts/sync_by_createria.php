<?php
    
  if(isset($param[2]))
  {      
    echo "Synchronize by '".$param[2]."'<br>'";   
    for($i=0; $i<sizeof($admin_conf); $i++)
    { 
      echo 'Synced on '.$admin_conf[$i]['dc'].': '.$ui->sync_user_info(trim($param[2]), $admin_conf[$i]).'<br>';    
      echo "\n";
    }
  }
  else
  {
    echo 'need parameter: `param`';
  }
  exit;
?>