<?php

require(dirname(dirname(__FILE__)) . '/libs/nokogiri/nokogiri.php');

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
    var $config = array("dc" => "pc", "site" => "my.ufins", "login_url" => ".com/admin/base/login", "find_url" => ".com/admin/user/find", "login" => "arzhanov", "pass" => "CiWacMadJej9", "type" => "phoenix");

    function UserInfo($DBH)
    {
        $this->db        = $DBH;
        $this->admin_url = 'my.ufins.com/user/find';
        $this->dc        = 'pc';
        $this->dc_conf   = array(
            "pc",
            "lg"
        );
    }

    function syncUserInfo($createria, $config)
    {
        $this->setDc($this->config);
        $this->adminLogin();
        curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->main_site . $this->find_url . '/?FindUserForm[user]=' . urlencode($createria));
        $find_arr = array(
            "YII_CSRF_TOKEN" => "",
            "FindUserForm" => array(
                "user" => $createria
            )
        );
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $out = curl_exec($this->ch);
        
        $html     = new nokogiri($out);
        $elements = $html->get(".grid-view")->toArray();

        $count  = 0;
        $id_arr = array();
        for ($i = 0; $i < sizeof($elements); $i++) {
            if (isset($elements[$i]['table'][0]['tbody'][0]['tr']['td'])) {
                if (isset($elements[$i]['table'][0]['tbody'][0]['tr']['td'][3])) {
                    $autologin_link = $elements[$i]['table'][0]['tbody'][0]['tr']['td'][3]['a']['href'];
                    preg_match_all("/[\S]+userId=([0-9a-z]+)/i", $autologin_link, $matches);
                    if ($matches[1][0] != '') {
                        $id_arr[] = trim($matches[1][0]);
                    }
                }
            } else {
                for ($y = 0; $y < sizeof($elements[$i]['table'][0]['tbody'][0]['tr']); $y++) {
                    if (isset($elements[$i]['table'][0]['tbody'][0]['tr'][$y]['td'][3])) {
                        $autologin_link = $elements[$i]['table'][0]['tbody'][0]['tr'][$y]['td'][3]['a']['href'];
                        preg_match_all("/[\S]+userId=([0-9a-z]+)/i", $autologin_link, $matches);
                        if (!empty($matches[1][0]) && $matches[1][0] != '') {
                            $id_arr[] = trim($matches[1][0]);
                        }
                    }
                }
            }
        }

        for ($i = 0; $i < sizeof($id_arr); $i++) {
            curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->main_site . '.com/user/find?user_id=' . $id_arr[$i]);
            $find_arr = array(
                "YII_CSRF_TOKEN" => "",
                "FindUserForm" => array(
                    "user" => $id_arr[$i]
                )
            );

            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
            $out      = curl_exec($this->ch);
            $html     = new nokogiri($out);
            $elements = $html->get("#yw1")->toArray();

            $user_info['id']          = isset($elements[0]['tr'][0]['td'][0]['#text']) ? strtolower($elements[0]['tr'][0]['td'][0]['#text']) : null;
            $user_info['mail']        = isset($elements[0]['tr'][2]['td'][0]['#text']) ? strtolower($elements[0]['tr'][2]['td'][0]['#text']) : null;
            $user_info['login']       = isset($elements[0]['tr'][4]['td'][0]['#text']) ? strtolower($elements[0]['tr'][4]['td'][0]['#text']) : null;
            $user_info['password']    = isset($elements[0]['tr'][5]['td'][0]['#text']) ? $elements[0]['tr'][5]['td'][0]['#text'] : null;
            $user_info['key']         = isset($elements[0]['tr'][6]['td'][0]['#text']) ? strtolower($elements[0]['tr'][6]['td'][0]['#text']) : null;
            $user_info['site_id']     = isset($elements[0]['tr'][7]['td'][0]['#text']) ? strtolower($elements[0]['tr'][7]['td'][0]['#text']) : null;
            $user_info['gender']      = isset($elements[0]['tr'][9]['td'][0]['#text']) ? strtolower($elements[0]['tr'][9]['td'][0]['#text']) : null;
            $user_info['orientation'] = isset($elements[0]['tr'][10]['td'][0]['#text']) ? strtolower($elements[0]['tr'][10]['td'][0]['#text']) : null;
            $user_info['fname']       = isset($elements[0]['tr'][11]['td'][0]['#text']) ? strtolower($elements[0]['tr'][11]['td'][0]['#text']) : null;
            $user_info['lname']       = isset($elements[0]['tr'][12]['td'][0]['#text']) ? strtolower($elements[0]['tr'][12]['td'][0]['#text']) : null;
            $user_info['country']     = isset($elements[0]['tr'][13]['td'][0]['#text']) ? strtolower($elements[0]['tr'][13]['td'][0]['#text']) : null;
            $user_info['birthday']    = isset($elements[0]['tr'][14]['td'][0]['#text']) ? strtolower($elements[0]['tr'][14]['td'][0]['#text']) : null;
            $user_info['reg_time']    = isset($elements[0]['tr'][15]['td'][0]['#text']) ? $elements[0]['tr'][15]['td'][0]['#text'] : null;
            $user_info['active']      = isset($elements[0]['tr'][21]['td'][0]['#text']) ? strtolower($elements[0]['tr'][21]['td'][0]['#text']) : null;
            $user_info['traffic']     = isset($elements[0]['tr'][29]['td'][0]['#text']) || strtolower($elements[0]['tr'][29]['td'][0]['#text']) != 'undefined' ? strtolower($elements[0]['tr'][26]['td'][0]['#text']) : strtolower($elements[0]['tr'][27]['td'][0]['#text']);
            $user_info['platform']    = isset($elements[0]['tr'][31]['td'][0]['#text']) ? strtolower($elements[0]['tr'][31]['td'][0]['#text']) : null;
            $user_info['ll']          = isset($elements[0]['tr'][16]['td'][0]['#text']) && isset($elements[0]['tr'][17]['td'][0]['#text']) ? strtolower($elements[0]['tr'][16]['td'][0]['#text']) . "," . strtolower($elements[0]['tr'][17]['td'][0]['#text']) : null;
            $user_info['searchable']  = isset($elements[0]['tr'][36]['td'][0]['#text']) && strtolower($elements[0]['tr'][36]['td'][0]['#text']) == "yes" ? 1 : 0;
            $elements                 = $html->get(".user-block")->toArray();
            $user_info['confirmed']   = !empty($elements[3]['h5'][0]['span'][0]['#text']) && strtolower($elements[3]['h5'][0]['span'][0]['#text']) == "confirmed" ? 1 : 0;

            curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->main_site . '.com/user/edit?user_id=' . $user_info['id']);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
            $out      = curl_exec($this->ch);
            $html     = new nokogiri($out);
            $elements = $html->get("#edit-user-form")->toArray();
            preg_match('([a-z]{5}[0-9]{5})', $user_info['login'], $matches);
            if (sizeof($elements) > 0) {
                if ($user_info['confirmed'] == 0 && empty($matches)) {
                    $inputs = !empty($elements[0]['input']) ? $elements[0]['input'] : null;
                    $spans  = !empty($elements[0]['span']) ? $elements[0]['span'] : null;

                    $characters = 'abcdefghijklmnoprstuvwxyz';
                    $randstring = '';
                    for ($i = 0; $i < 5; $i++) {
                        $randstring .= $characters[rand(0, strlen($characters))];
                    }
                    $screenname = $randstring . substr(time(), -5);

                    if (isset($elements[0])) {
                        $inputs = !empty($elements[0]['input']) ? $elements[0]['input'] : null;
                        for ($i = 0; $i < sizeof($inputs); $i++) {
                            if ($inputs[$i]['name'] == 'UserAdminForm[login]') {
                                $inputs[$i]['value'] = $screenname;
                                $user_info['login']  = $screenname;
                            }
                            $arr[$inputs[$i]['name']] = $inputs[$i]['value'];
                        }
                    }
                    if (isset($elements[0])) {
                        $spans = !empty($elements[0]['span']) ? $elements[0]['span'] : null;
                        for ($i = 0; $i < sizeof($spans); $i++) {
                            $curr_select = $spans[$i]['select'][0];
                            for ($y = 0; $y < sizeof($curr_select['option']); $y++) {
                                if (!empty($curr_select['option'][$y]['selected'])) {
                                    $arr[$curr_select['name']] = $curr_select['option'][$y]['value'];
                                }
                            }
                        }
                    }

                    $arr['UserAdminForm[location]'] = '';
                    $arr['UserAdminForm[country]']  = '';
                    curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->main_site . '.com/user/edit?user_id=' . $user_info['id']);
                    curl_setopt($this->ch, CURLOPT_POST, true);
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($this->ch, REFERER, "https://my.ufins.com/user/edit?user_id=3dc38936fd1b11e3a082d4bed9a94a8f");

                    curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($arr));
                    $out = curl_exec($this->ch);
                }
            }
            //curl_setopt($this->ch, CURLOPT_URL, "https://my.ufins.com/user/markTester?userId=".$user_info['id']);
            //curl_exec($this->ch);

            var_dump($user_info);
            $this->saveSyncUser($user_info);
        }
        return sizeof($id_arr);
    }

    function setDc($config)
    {
        $this->dc        = $config['dc'];
        $this->main_site = $config['site'];
        $this->login_url = $config['login_url'];
        $this->find_url  = $config['find_url'];
        $this->type      = $config['type'];
        $this->login     = $config['login'];
        $this->pass      = $config['pass'];
    }

    function adminLogin()
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

        curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->main_site . $this->login_url);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_VERBOSE, 0);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($post_arr));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $out = curl_exec($this->ch);
    }

    function syncSitesConfig($conf)
    {
        
        $this->setDc($conf);
        $this->adminLogin();
        curl_setopt($this->ch, CURLOPT_URL, "https://my.ufins.com/user/sites");
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_VERBOSE, 0);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $out = curl_exec($this->ch);

        $html     = new nokogiri($out);
        $elements = $html->get(".grid-view")->toArray();

        for ($i = 0; $i < 1; $i++) {
            for ($y = 0; $y < sizeof($elements[$i]['table'][0]['tbody'][0]['tr']); $y++) {
                $site_conf['site_id'] = $elements[$i]['table'][0]['tbody'][0]['tr'][$y]['td'][2]['#text'];

                curl_setopt($this->ch, CURLOPT_URL, 'https://my.ufins.com/admin/user/sites/view/' . $site_conf['site_id']);
                curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
                curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
                curl_setopt($this->ch, CURLOPT_VERBOSE, 0);
                curl_setopt($this->ch, CURLOPT_POST, true);
                curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
                    'X-Requested-With: XMLHttpRequest'
                ));

                $json_answer = json_decode(curl_exec($this->ch));

                $site_conf['site_name'] = strtolower($json_answer->{$site_conf['site_id']}->{'siteName'});
                if (!is_object($json_answer->{$site_conf['site_id']}->{'skin'})) {
                    $site_conf['skin'] = $json_answer->{$site_conf['site_id']}->{'skin'};
                } elseif (!is_object($json_answer->{$site_conf['site_id']}->{'skin'}->{'default'})) {
                    $site_conf['skin'] = $json_answer->{$site_conf['site_id']}->{'skin'}->{'default'};
                } else {
                    $site_conf['skin'] = '';
                }
                $site_conf['company_name'] = $json_answer->{$site_conf['site_id']}->{'companyName'};
                $site_conf['site_url']     = strtolower($json_answer->{$site_conf['site_id']}->{'siteUrl'});
                $site_conf['site_domain']  = strtolower($json_answer->{$site_conf['site_id']}->{'siteDomain'});

                echo '<pre>' . print_r($site_conf, true) . '</pre>';
                if ($site_conf['skin'] != 'lgw.vanilla' && $site_conf['skin'] != 'lgw.vermillion' && $site_conf['skin'] != 'lgw.turquoise') {
                    try {
                        $update_site_config_query = $this->db->prepare("
                            INSERT INTO 
                                `sites_config` (
                                    `site_name`,
                                    `site_id`,
                                    `company_name`,
                                    `site_url`,
                                    `site_domain`,
                                    `skin`
                                )
                                VALUES (
                                    :site_name,
                                    :site_id,
                                    :company_name,
                                    :site_url,
                                    :site_domain,
                                    :skin
                                )
                            ON DUPLICATE KEY UPDATE            
                                `site_name` = :site_name2,
                                `company_name` = :company_name2,
                                `site_url` = :site_url2,
                                `site_domain` = :site_domain2,
                                `skin` = :skin2
                        ;");
                        
                        foreach ($site_conf as $key => $item) {
                            if ($key != 'site_id') {
                                $this->bindMultiple($update_site_config_query, array(
                                    $key,
                                    $key . '2'
                                ), $item);
                            } else {
                                $update_site_config_query->bindValue(':site_id', $item);
                            }
                        }
                        
                        
                        $update_site_config_query->execute();
                    }
                    catch (PDOException $e) {
                        echo $e->getMessage();
                        file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
                    }
                }
            }
            
        }
        
    }
    
    function saveTmpUser($user_info)
    {
        try {
            $insert_tmp_user_info_query = $this->db->prepare("   
                INSERT INTO 
                    `temp_profiles`(
                        email) 
                VALUES (
                    :email            
                )
            ;");
            $insert_tmp_user_info_query->bindValue(':email', $user_info);
            
            $insert_tmp_user_info_query->execute();
            return true;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
            return false;
        }
    }
    
    function saveSyncUser($user_info)
    {
        if (isset($user_info)) {
            if ($user_info['mail'] != 'adghcvnhtg@outlook.com') {
                try {
                        $insert_user_info_query = $this->db->prepare("
                            INSERT INTO 
                                `profile` (
                                    `id`,
                                    `mail`,
                                    `login`,
                                    `password`,
                                    `key`,
                                    `site_id`,
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
                                    `ll`,
                                    `searchable`,
                                    `confirmed`
                                )
                                VALUES (
                                    :id,
                                    :mail,
                                    :login,
                                    :password,
                                    :key,
                                    :site_id,
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
                                    :ll,
                                    :searchable,
                                    :confirmed
                                )
                            ON DUPLICATE KEY UPDATE            
                                `mail` = :mail2,
                                `login` = :login2,
                                `password` = :password2,
                                `key` = :key2,
                                `site_id` = :site_id2,
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
                                `ll` = :ll2,
                                `searchable` = :searchable2,
                                `confirmed` = :confirmed2
                          ;");

                    foreach ($user_info as $key => $item) {
                        if ($key != 'id') {
                            $this->bindMultiple($insert_user_info_query, array(
                                $key,
                                $key . '2'
                            ), $item);
                        } else {
                            $insert_user_info_query->bindValue(':id', $item);
                        }
                    }

                    $insert_user_info_query->execute();
                    $this->syncDc($user_info['mail']);
                    return true;
                }
                catch (PDOException $e) {
                    echo $e->getMessage();
                    file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
                    return false;
                }
            } else {
                mail('arzhanov@ufins.com', 'Debug : ALERT!!!', print_r($_SERVER, true));
            }
        }
    }

    function bindMultiple($stmt, $params, $variable)
    {
        foreach ($params as $param) {
            $stmt->bindValue(':' . $param, $variable);
        }
    }

    function getUsersForSync($dc)
    {
        try {
            $used_email_query = $this->db->query("
                SELECT 
                    `mail`
                FROM
                    `profile`
                WHERE
                    `platform` = '0'
                LIMIT 25
            ;");
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($used_email_query->rowCount() > 0) {
            
            while ($row = $used_email_query->fetch()) {
                $users[] = $row['mail'];
            }
            return $users;
        } else {
            return false;
        }
    }

    function getSitesConfig()
    {
        try {
            $get_sites_config_query = $this->db->query("
                SELECT
                    `site_name`,
                    `site_id`,
                    `site_url`,
                    `site_domain`,
                    `company_name`
                FROM
                    `sites_config`
            ;");
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($get_sites_config_query->rowCount() > 0) {
            while ($row = $get_sites_config_query->fetch()) {
                $sites_config[$row['site_id']]['live']         = $row['site_url'];
                $sites_config[$row['site_id']]['site_name']    = $row['site_name'];
                $sites_config[$row['site_id']]['domain']       = $row['site_domain'];
                $sites_config[$row['site_id']]['company_name'] = $row['company_name'];
            }
            
            return $sites_config;
        } else {
            return false;
        }
    }

    function getUsersForUpdate($dc)
    {
        $date = date('Y-m-d H:i:s', strtotime('-12 hours'));
        try {
            $used_email_for_upd_query = $this->db->prepare("
                SELECT
                    DISTINCT `mail`
                FROM
                    `profile`
                WHERE
                    `site_id` is NULL
                LIMIT 500
            ;");
            $used_email_for_upd_query->bindValue(':dc', $dc);
            $used_email_for_upd_query->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($used_email_for_upd_query->rowCount() > 0) {
            while ($row = $used_email_for_upd_query->fetch()) {
                $users[] = $row['mail'];
            }
            return $users;
        } else {
            return false;
        }
    }

    function getUsersForSyncDate($dc)
    {
        try {
            $used_email_query = $this->db->prepare("
                SELECT
                    `id`
                FROM
                    `profile`
                WHERE
                    `dc` = :dc
                AND
                    `reg_time` = '0000-00-00 00:00:00'
            ;");
            $used_email_query->bindValue(':dc', $dc);
            $used_email_query->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($used_email_query->rowCount() > 0) {
            while ($row = $used_email_query->fetch()) {
                $users[] = $row['id'];
            }
            return $users;
        } else {
            return false;
        }
    }

    function getSiteList()
    {
        try {
            $list_query = $this->db->prepare("
                SELECT 
                    `sites_config`.`site_name` as site 
                FROM 
                    `sites_config`
                JOIN
                    `profile`
                ON
                    `sites_config`.`site_id` = `profile`.`site_id`
                AND
                    `sites_config`.`enabled` = 1
                GROUP BY
                    `sites_config`.`site_name` 
                ORDER BY
                    site ASC;
            ;");
            $list_query->execute();
            $list = array();
            while ($row = $list_query->fetch()) {
                $list[] = $row['site'];
            }
            return $list;
        }
        catch (PDOException $e) {
            echo $e->getMessage() . '\r\n';
            file_put_contents('../PDOErrors.txt', $e->getMessage() . '\r\n', FILE_APPEND);
            return false;
        }
    }
    
    function getCreateriaList($createria)
    {
        try {
            $list_query = $this->db->prepare("
                SELECT 
                    DISTINCT $createria
                FROM
                    `profile`
                ORDER BY $createria ASC
            ;");
            $list_query->execute();
            $list = array();
            while ($row = $list_query->fetch()) {
                $list[] = $row[$createria];
            }
            return $list;
        }
        catch (PDOException $e) {
            echo $e->getMessage() . '\r\n';
            file_put_contents('../PDOErrors.txt', $e->getMessage() . '\r\n', FILE_APPEND);
            return false;
        }
    }

    function syncDates($user_id, $site, $config)
    {
        $this->setDc($config);
        $this->adminLogin();
        curl_setopt($this->ch, CURLOPT_URL, "https://www." . $this->main_site . ".com/profiles/search.php?pid=" . $user_id . "&site" . $this->site_conf[$site]['id']);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, "pid=" . $user_id . "&chk=&action=ajax_profile_details");
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'X-Requested-With: XMLHttpRequest'
        ));
        $out = curl_exec($this->ch);
        curl_close($this->ch);
        $html     = new nokogiri($out);
        $elements = $html->get("tr")->toArray();
        $reg_str = implode('|', $elements[2]['td'][2]['table'][0]['tr'][4]['td'][3]);
        preg_match("/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/i", $reg_str, $matches);
        $reg = $matches[0];
        $conf_str = implode('|', $elements[2]['td'][2]['table'][0]['tr'][5]['td'][3]);
        preg_match("/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/i", $conf_str, $matches);
        $conf = $matches[0];
        $traff_str = implode('|', $elements[2]['td'][2]['table'][0]['tr'][6]['td'][3]);
        preg_match("/([\-a-zA-Z]*)/i", $traff_str, $matches);
        $traff = $matches[0];
        try {
            $dc_synced_update_query = $this->db->prepare("
                UPDATE 
                    `profile` 
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
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
    }

    function findByCreaterias($createrias, $sort_by, $sort, $page)
    {
        $createrias_text = $createrias;
        $createrias_text .= " ORDER BY `" . $sort_by . "` " . $sort;
        try {
            $count = 20;
            $limit_to   = $page * $count;
            $limit_from = $limit_to - $count;
            $find_by_createria_count = $this->db->prepare("
                SELECT
                    count(*)
                FROM
                    `profile`
                JOIN
                    `sites_config`
                ON
                    `profile`.`site_id` = `sites_config`.`site_id`
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
                    `sites_config`.`site_name` as `site`,
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
                    `ll`,
                    `profile`.`site_id`
                FROM
                    `profile`
                JOIN
                    `sites_config`
                ON
                    `profile`.`site_id` = `sites_config`.`site_id`
                $createrias_text
                LIMIT $limit_from, $limit_to
            ;");
            $find_by_createria_query->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage() . '\r\n', FILE_APPEND);
            return false;
        }
        if ($find_by_createria_query->columnCount() > 0) {
            $i = 0;
            while ($row = $find_by_createria_query->fetch()) {
                $answer['data'][$i]['site']        = $row['site'];
                $answer['data'][$i]['gender']      = $row['gender'];
                $answer['data'][$i]['country']     = $row['country'];
                $answer['data'][$i]['key']         = $row['key'];
                $answer['data'][$i]['reg_time']    = $row['reg_time'];
                $answer['data'][$i]['id']          = $row['id'];
                $answer['data'][$i]['mail']        = $row['mail'];
                $answer['data'][$i]['password']    = $row['password'];
                $answer['data'][$i]['traffic']     = $row['traffic'];
                $answer['data'][$i]['login']       = $row['login'];
                $answer['data'][$i]['orientation'] = $row['orientation'];
                $answer['data'][$i]['fname']       = $row['fname'];
                $answer['data'][$i]['lname']       = $row['lname'];
                $answer['data'][$i]['birthday']    = $row['birthday'];
                $answer['data'][$i]['active']      = $row['active'];
                $answer['data'][$i]['platform']    = $row['platform'];
                $answer['data'][$i]['ll']          = $row['ll'];
                $answer['data'][$i]['site_id']     = $row['site_id'];
                $i++;
            }
            $answer['count']        = $count_result[0];
            $answer['sites']        = $sites;
            $answer['sort_element'] = $sort_by;
            $answer['sort']         = $sort;
            return $answer;
        } else {
            unset($STH);
            return false;
        }
    }

    function syncDc($param)
    {
        try {
            $dc_synced_delete_query_ph = $this->db->prepare("
                DELETE FROM 
                    `temp_profiles` 
                WHERE 
                    `email` = :curr_mail
            ;");
            $dc_synced_delete_query_ph->bindParam(':curr_mail', $param);
            $dc_synced_delete_query_ph->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
            return false;
        }
    }
}
