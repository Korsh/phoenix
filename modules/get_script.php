<?php
require_once(INCLUDE_DIR . "script_generate.inc.php");
require_once(LIB_DIR . "rfc822/rfc822.php");

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'new') {
        $scriptId = time();
        if (isset($_POST) && (isset($_POST['mail']) && (bool) is_valid_email_address($_POST['mail']))) {
            $keychar = array();
            list($account, $domain) = split('@', $_POST['mail']);
            $options['version']         = $scriptVersion;
            $options['mail']['account'] = $account;
            $options['mail']['domain']  = $domain;
            foreach ($scriptGenerateActions as $key => $option) {
                if (isset($_POST['ctrl' . $key])) {
                    $options['keychar'][$key]['condition'][] = "isCtrl";
                }
                if (isset($_POST['alt' . $key])) {
                    $options['keychar'][$key]['condition'][] = "isAlt";
                }
                if (isset($_POST['shift' . $key])) {
                    $options['keychar'][$key]['condition'][] = "isShift";
                }
                $options['keychar'][$key]['condition'][] = "is" . $_POST['text' . $key];
                $options['keychar'][$key]['button']      = $_POST['button' . $key];
                $options['keychar'][$key]['function']    = $option[0];
                $options['keychar'][$key]['value']       = $option[1];
            }
            $fileConfig = fopen("user_scripts/configs/" . $scriptId . ".txt", "w+");
            chmod($fileConfig, 0777);
            fwrite($fileConfig, serialize($options));
            
            require_once('user_scripts/userscript.src.php');
            
            $filename    = "user_scripts/scripts/" . $scriptId . ".user.js";
            $fileScript = fopen($filename, "w+");
            chmod($fileScript, 0777);
            fwrite($fileScript, $scriptSrc);
            header('Location: ' . ($filename));
            
        } else {
            echo 'Не верно указан e-mail!';
            exit;
        }
    } elseif ($_GET['action'] == 'update' && isset($_GET['id'])) {
        
        if (preg_match("/([0-9]+)/", $_GET['id'], $match)) {
            $scriptId   = $match[1];
            $filename    = "user_scripts/configs/" . $scriptId . ".txt";
            $fileConfig = fopen($filename, "r");
            if ($fileConfig) {
                $options = unserialize(fread($fileConfig, filesize($filename)));
            }

            require_once('user_scripts/userscript.src.php');
            
            $filename    = "user_scripts/scripts/" . $scriptId . ".user.js";
            $fileScript = fopen($filename, "w+");
            chmod($fileScript, 0777);
            fwrite($fileScript, $scriptSrc);
            
            header('Location: ' . ($filename));
        }
    } elseif ($_GET['action'] == 'meta') {
        unlink("user_scripts/meta.js");
        require_once('user_scripts/meta.js.src.php');
        $filename    = "user_scripts/meta.js";
        $fileScript = fopen($filename, "w+");
        chmod($filename, 0777);
        fwrite($fileScript, $scriptSrc);
        header('Location: ' . ($filename));
    }
}
