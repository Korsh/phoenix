<?

	$error_level=E_ALL ^ ~E_NOTICE ^ ~E_WARNING;
  error_reporting($error_level);
  try
  {    
    $db_host='192.168.12.16';
    $db_user='arzhanov';
    $db_password='bnuqMw5V';
    $db_name='arzhanov_phoenix';
    
    $DBH = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);  
  }    
  catch(PDOException $e) 
  {  
    echo $e->getMessage();
    file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
  }
  $DBH->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);  
  $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $script_version = "0.0.1";
  
  $dc_conf = array(
  "ph",
  "lg");
  
  $admin_conf = array(
    0 => array(
      "dc" => "ph",
      "site" => "playcougar",
      "login_url" => ".com/admin/base/login?redirect=",
      "find_url" => ".com/admin/user/find",
      "login" => "arzhanov",
      "pass" => "CiWacMadJej9",
      "type" => "phoenix"
    ),
    1 => array(
      "dc" => "lg",
      "site" => "localsgowild",
      "login_url" => ".com/admin/base/login?redirect=",
      "find_url" => ".com/admin/user/find?",
      "login" => "arzhanov",
      "pass" => "AfhOkBjW",
      "type" => "phoenix"
    )    
  )
?>