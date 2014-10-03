<?


if ((isset($param[2]) && $param[2] != "") || (isset($_REQUEST['mail']) && $_REQUEST['mail'] != "")) {
    echo $_REQUEST['mail'];
    
    if (isset($_REQUEST['mail'])) {
        $email = $_REQUEST['mail'];
    } else {
        $email = $param[2];
    }
    
    if ($ui->saveTmpUser($email)) {
        echo true;
        exit;
    } else {
        echo false;
        exit;
    }
}

