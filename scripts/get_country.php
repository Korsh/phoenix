<?php
/* getip.php */
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');
 
if (!empty($_SERVER['HTTP_CLIENT_IP']))
{
  $ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
  $ip=$_SERVER['REMOTE_ADDR'];
}
for($i = 0; $i < sizeof($proxy); $i++)
{
  if($ip == $proxy[$i]['ip'])
  {
    $response = $proxy[$i];    
  }
  else
  {
    $response = $ip;
  }
  
}
print json_encode($response);
exit;
?>