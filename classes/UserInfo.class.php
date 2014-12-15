<?php

require(dirname(dirname(__FILE__)) . '/libs/nokogiri/nokogiri.php');

class UserInfo
{
    var $db;
    var $ch;
    var $mainSite;
    var $dcConf;
    var $dc;
    var $loginUrl;
    var $findUrl;
    var $type;
    var $login;
    var $pass;
    var $siteConf;

    function UserInfo($DBH)
    {
        $this->db        = $DBH;
        $this->adminUrl = 'my.ufins.com/user/find';
        $this->dc        = 'pc';
        $this->dcConf   = array(
            "pc",
            "lg"
        );
    }

    function syncUserInfo($createria, $dc)
    {
        $this->setDc($dc);
        $this->adminLogin();
        curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->mainSite . $this->findUrl . '/?FindUserForm[user]=' . urlencode($createria));
        $findArr = array(
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
        $idArr = array();
        for ($i = 0; $i < sizeof($elements); $i++) {
            if (isset($elements[$i]['table'][0]['tbody'][0]['tr']['td'])) {
                if (isset($elements[$i]['table'][0]['tbody'][0]['tr']['td'][3])) {
                    $autologinLink = $elements[$i]['table'][0]['tbody'][0]['tr']['td'][3]['a']['href'];
                    preg_match_all("/[\S]+userId=([0-9a-z]+)/i", $autologinLink, $matches);
                    if ($matches[1][0] != '') {
                        $idArr[] = trim($matches[1][0]);
                    }
                }
            } else {
                for ($y = 0; $y < sizeof($elements[$i]['table'][0]['tbody'][0]['tr']); $y++) {
                    if (isset($elements[$i]['table'][0]['tbody'][0]['tr'][$y]['td'][3])) {
                        $autologinLink = $elements[$i]['table'][0]['tbody'][0]['tr'][$y]['td'][3]['a']['href'];
                        preg_match_all("/[\S]+userId=([0-9a-z]+)/i", $autologinLink, $matches);
                        if (!empty($matches[1][0]) && $matches[1][0] != '') {
                            $idArr[] = trim($matches[1][0]);
                        }
                    }
                }
            }
        }

        if(!empty($idArr)) {
            for ($i = 0; $i < sizeof($idArr); $i++) {
                curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->mainSite . '.com/user/find?user_id=' . $idArr[$i]);
                $findArr = array(
                    "YII_CSRF_TOKEN" => "",
                    "FindUserForm" => array(
                        "user" => $idArr[$i]
                    )
                );

                curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
                $out      = curl_exec($this->ch);
                $html     = new nokogiri($out);
                $elements = $html->get("#yw1")->toArray();

                $userInfo['id']          = isset($elements[0]['tr'][0]['td'][0]['#text']) ? strtolower($elements[0]['tr'][0]['td'][0]['#text']) : null;
                $userInfo['mail']        = isset($elements[0]['tr'][2]['td'][0]['#text']) ? strtolower($elements[0]['tr'][2]['td'][0]['#text']) : null;
                $userInfo['login']       = isset($elements[0]['tr'][4]['td'][0]['#text']) ? strtolower($elements[0]['tr'][4]['td'][0]['#text']) : null;
                $userInfo['password']    = isset($elements[0]['tr'][5]['td'][0]['#text']) ? $elements[0]['tr'][5]['td'][0]['#text'] : null;
                $userInfo['key']         = isset($elements[0]['tr'][6]['td'][0]['#text']) ? strtolower($elements[0]['tr'][6]['td'][0]['#text']) : null;
                $userInfo['siteId']     = isset($elements[0]['tr'][7]['td'][0]['#text']) ? strtolower($elements[0]['tr'][7]['td'][0]['#text']) : null;
                $userInfo['gender']      = isset($elements[0]['tr'][9]['td'][0]['#text']) ? strtolower($elements[0]['tr'][9]['td'][0]['#text']) : null;
                $userInfo['orientation'] = isset($elements[0]['tr'][10]['td'][0]['#text']) ? strtolower($elements[0]['tr'][10]['td'][0]['#text']) : null;
                $userInfo['fname']       = isset($elements[0]['tr'][11]['td'][0]['#text']) ? strtolower($elements[0]['tr'][11]['td'][0]['#text']) : null;
                $userInfo['lname']       = isset($elements[0]['tr'][12]['td'][0]['#text']) ? strtolower($elements[0]['tr'][12]['td'][0]['#text']) : null;
                $userInfo['country']     = isset($elements[0]['tr'][13]['td'][0]['#text']) ? strtolower($elements[0]['tr'][13]['td'][0]['#text']) : null;
                $userInfo['birthday']    = isset($elements[0]['tr'][14]['td'][0]['#text']) ? strtolower($elements[0]['tr'][14]['td'][0]['#text']) : null;
                $userInfo['regTime']    = isset($elements[0]['tr'][20]['td'][0]['#text']) ? $elements[0]['tr'][20]['td'][0]['#text'] : null;
                $userInfo['active']      = isset($elements[0]['tr'][26]['td'][0]['#text']) ? strtolower($elements[0]['tr'][26]['td'][0]['#text']) : null;
                $userInfo['traffic']     = isset($elements[0]['tr'][34]['td'][0]['#text']) || strtolower($elements[0]['tr'][34]['td'][0]['#text']) != 'undefined' ? strtolower($elements[0]['tr'][34]['td'][0]['#text']) : strtolower($elements[0]['tr'][35]['td'][0]['#text']);
                $userInfo['platform']    = isset($elements[0]['tr'][36]['td'][0]['#text']) ? strtolower($elements[0]['tr'][36]['td'][0]['#text']) : null;
                $userInfo['ll']          = isset($elements[0]['tr'][21]['td'][0]['#text']) && isset($elements[0]['tr'][22]['td'][0]['#text']) ? strtolower($elements[0]['tr'][21]['td'][0]['#text']) . "," . strtolower($elements[0]['tr'][22]['td'][0]['#text']) : null;
            
            /*$userInfo['chats_count'] = isset($elements[0]['tr'][28]['td'][0]['a'][0]['#text']) ? $elements[0]['tr'][28]['td'][0]['a'][0]['#text'] : null;
            preg_match_all("/([0-9]+)/", $user_info['chats_count'], $matches);
            $userInfo['chats_count'] = trim($matches[1][0]);*/
            $userInfo['searchable']  = isset($elements[0]['tr'][36]['td'][0]['#text']) && strtolower($elements[0]['tr'][36]['td'][0]['#text']) == "yes" ? 1 : 0;
                $elements                 = $html->get(".user-block")->toArray();
                $userInfo['confirmed']   = !empty($elements[3]['h5'][0]['span'][0]['#text']) && strtolower($elements[3]['h5'][0]['span'][0]['#text']) == "confirmed" ? 1 : 0;

                curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->mainSite . '.com/user/edit?user_id=' . $userInfo['id']);
                curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
                $out      = curl_exec($this->ch);
                $html     = new nokogiri($out);
                $elements = $html->get("#edit-user-form")->toArray();
                preg_match('([a-z]{5}[0-9]{5})', $userInfo['login'], $matches);
                if (sizeof($elements) > 0) {
                    if ($userInfo['confirmed'] == 0 && empty($matches)) {
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
                                    $userInfo['login']  = $screenname;
                                }
                                $arr[$inputs[$i]['name']] = $inputs[$i]['value'];
                            }
                        }
                        if (isset($elements[0])) {
                            $spans = !empty($elements[0]['span']) ? $elements[0]['span'] : null;
                            for ($i = 0; $i < sizeof($spans); $i++) {
                                $currSelect = $spans[$i]['select'][0];
                                for ($y = 0; $y < sizeof($currSelect['option']); $y++) {
                                    if (!empty($currSelect['option'][$y]['selected'])) {
                                        $arr[$currSelect['name']] = $currSelect['option'][$y]['value'];
                                    }
                                }
                            }
                        }

                        $arr['UserAdminForm[location]'] = '';
                        $arr['UserAdminForm[country]']  = '';
                        curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->mainSite . '.com/user/edit?user_id=' . $userInfo['id']);
                        curl_setopt($this->ch, CURLOPT_POST, true);
                        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

                        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($arr));
                        $out = curl_exec($this->ch);
                    }
                }
                curl_setopt($this->ch, CURLOPT_URL, "https://my.ufins.com/user/markTester?userId=".$userInfo['id']);
                curl_exec($this->ch);
                var_dump($userInfo);
                if(!empty($userInfo)) {
                    $this->saveSyncUser($userInfo);
                } else {
                    $this->syncDc($createria);
                }
                
            }
        } else {
            $this->syncDc($createria);
        }

        return sizeof($idArr);
    }

    function setDc($config)
    {
        $this->dc        = $config['dc'];
        $this->mainSite = $config['site'];
        $this->loginUrl = $config['loginUrl'];
        $this->findUrl  = $config['findUrl'];
        $this->type      = $config['type'];
        $this->login     = $config['login'];
        $this->pass      = $config['pass'];
    }

    function adminLogin()
    {
        $this->ch = curl_init();
        $postArr = array(
            "AdminLoginForm" => array(
                "login" => $this->login,
                "password" => $this->pass
            ),
            "YII_CSRF_TOKEN" => "",
            "yt0" => ""
        );

        curl_setopt($this->ch, CURLOPT_URL, "https://" . $this->mainSite . $this->loginUrl);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_VERBOSE, 0);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($postArr));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $out = curl_exec($this->ch);
    }

    function updateProxy($proxyConf)
    {
        try {
        $updateProxyConfigQuery = $this->db->prepare("
            INSERT INTO 
                `proxy` (
                `id`,
                `domain`,
                `port`,
                `ip_address`,
                `country_code`,
                `country_name`,
                `region_name`,
                `city_name`,
                `zip_code`,
                `latitude`,
                `longitude`,
                `time_zone`,
                `enable`,
                `country`
            )
            VALUES (
                default,
                :domain,
                :port,
                :ipAddress,
                :countryCode,
                :countryName,
                :regionName,
                :cityName,
                :zipCode,
                :latitude,
                :longitude,
                :timeZone,
                :enable,
                :country
            )
            ON DUPLICATE KEY UPDATE
                `domain` = :domain2,
                `port`= :port2,
                `ip_address` = :ipAddress2,
                `country_code` = :countryCode2,
                `country_name` = :countryName2,
                `region_name` = :regionName2,
                `city_name` = :cityName2,
                `zip_code` = :zipCode2,
                `latitude` = :latitude2,
                `longitude` = :longitude2,
                `time_zone` = :timeZone2,
                `enable` = :enable2,
                `country` = :country2
        ;");
        foreach ($proxyConf as $key => $item) {
            if ($key != 'id') {
                $this->bindMultiple($updateProxyConfigQuery, array(
                    $key,
                    $key . '2'
                ), $item);
            } else {
                $updateProxyConfigQuery->bindValue(':id', $item);
            }
        }
        $updateProxyConfigQuery->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            //file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
    }
    
    function getProxyConfig()
    {
        try {
            $usedEmailQuery = $this->db->query("
            SELECT 
                `id`,
                `ip_address`,
                `country_code`,
                `country_name`,
                `region_name`,
                `city_name`,
                `zip_code`,
                `latitude`,
                `longitude`,
                `time_zone`,
                `domain`,
                `port`,
                `country`,
                `enable`
        
        FROM
          `proxy`
        ;");
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($usedEmailQuery->rowCount() > 0) {
            while ($row = $usedEmailQuery->fetch()) {
                $proxy[$row['country']]['id'] = $row['id'];
                $proxy[$row['country']]['ipAddress'] = $row['ip_address'];
                $proxy[$row['country']]['countryCode'] = $row['country_code'];
                $proxy[$row['country']]['countryName'] = $row['country_name'];
                $proxy[$row['country']]['regionName'] = $row['region_name'];
                $proxy[$row['country']]['cityName'] = $row['city_name'];
                $proxy[$row['country']]['zipCode'] = $row['zip_code'];
                $proxy[$row['country']]['latitude'] = $row['latitude'];
                $proxy[$row['country']]['longitude'] = $row['longitude'];
                $proxy[$row['country']]['timeShift'] = $row['time_zone'];
                $proxy[$row['country']]['domain'] = $row['domain'];
                $proxy[$row['country']]['port'] = $row['port'];
                $proxy[$row['country']]['enable'] = $row['enable'];
            }
            return $proxy;
        } else {
            return false;
        }
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
        for ($i = 0; $i < 3; $i++) {
            $id = $elements[$i]['id'];
            switch ($id) {
                case "yw0":
                    $siteConf['company'] = "PMMedia";
                    break;
                case "yw1":
                    $siteConf['company'] = "Together Network";
                    break;
                case "yw2":
                    $siteConf['company'] = "PMMedia MS";
                    break;
            }

            for ($y = 0; $y < sizeof($elements[$i]['table'][0]['tbody'][0]['tr']); $y++) {
                $siteConf['siteId'] = $elements[$i]['table'][0]['tbody'][0]['tr'][$y]['td'][2]['#text'];

                curl_setopt($this->ch, CURLOPT_URL, 'https://my.ufins.com/admin/user/sites/view/' . $siteConf['siteId']);
                curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
                curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
                curl_setopt($this->ch, CURLOPT_VERBOSE, 0);
                curl_setopt($this->ch, CURLOPT_POST, true);
                curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
                    'X-Requested-With: XMLHttpRequest'
                ));

                $jsonAnswer = json_decode(curl_exec($this->ch));

                $siteConf['siteName'] = strtolower($jsonAnswer->{$siteConf['siteId']}->{'siteName'});
                if (!is_object($jsonAnswer->{$siteConf['siteId']}->{'skin'})) {
                    $siteConf['skin'] = $jsonAnswer->{$siteConf['siteId']}->{'skin'};
                } elseif (!is_object($jsonAnswer->{$siteConf['siteId']}->{'skin'}->{'default'})) {
                    $siteConf['skin'] = $jsonAnswer->{$siteConf['siteId']}->{'skin'}->{'default'};
                } else {
                    $siteConf['skin'] = '';
                }
                $siteConf['companyName'] = $jsonAnswer->{$siteConf['siteId']}->{'companyName'};
                $siteConf['siteUrl']     = strtolower($jsonAnswer->{$siteConf['siteId']}->{'siteUrl'});
                $siteConf['siteDomain']  = strtolower($jsonAnswer->{$siteConf['siteId']}->{'siteDomain'});

                var_dump($siteConf);
                $newSites = array();
                
                if (($siteConf['skin'] != 'lgw.vanilla' && $siteConf['skin'] != 'lgw.vermillion' && $siteConf['skin'] != 'lgw.turquoise')
                /*&& (($siteConf['companyName'] == "Alcuda Limited" || $siteConf['companyName'] == "Cisca Services Ltd" || $siteConf['companyName'] == "Enedina Limited") || ($siteConf['companyName'] == "pmMedia"  && in_array($siteConf['siteDomain'],$newSites)))*/) {
                    try {
                        $updateSiteConfigQuery = $this->db->prepare("
                            INSERT INTO 
                                `sites_config` (
                                    `site_name`,
                                    `site_id`,
                                    `company_name`,
                                    `company`,
                                    `site_url`,
                                    `site_domain`,
                                    `skin`
                                )
                                VALUES (
                                    :siteName,
                                    :siteId,
                                    :companyName,
                                    :company,
                                    :siteUrl,
                                    :siteDomain,
                                    :skin
                                )
                            ON DUPLICATE KEY UPDATE            
                                `site_name` = :siteName2,
                                `company_name` = :companyName2,
                                `company` = :company2,
                                `site_url` = :siteUrl2,
                                `site_domain` = :siteDomain2,
                                `skin` = :skin2
                        ;");
                        
                        foreach ($siteConf as $key => $item) {
                            if ($key != 'siteId') {
                                $this->bindMultiple($updateSiteConfigQuery, array(
                                    $key,
                                    $key . '2'
                                ), $item);
                            } else {
                                $updateSiteConfigQuery->bindValue(':siteId', $item);
                            }
                        }
                        
                        
                        $updateSiteConfigQuery->execute();
                    }
                    catch (PDOException $e) {
                        echo $e->getMessage();
                        file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
                    }
                }
            }
            
        }
        
    }
    
    function saveTmpUser($userInfo)
    {
        try {
            $insertTmpUserInfoQuery = $this->db->prepare("   
                INSERT INTO 
                    `temp_profiles`(
                        email) 
                VALUES (
                    :email            
                )
            ;");
            var_dump($userInfo);
            $insertTmpUserInfoQuery->bindValue(':email', $userInfo);
            
            $insertTmpUserInfoQuery->execute();
            return true;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
            return false;
        }
    }
    
    function saveSyncUser($userInfo)
    {
        if (isset($userInfo)) {
            if ($userInfo['mail'] != 'adghcvnhtg@outlook.com') {
                try {
                        $insertUserInfoQuery = $this->db->prepare("
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
                                    `confirmed`,
                                    `test`
                                )
                                VALUES (
                                    :id,
                                    :mail,
                                    :login,
                                    :password,
                                    :key,
                                    :siteId,
                                    :gender,
                                    :orientation,
                                    :fname,
                                    :lname,
                                    :country,
                                    :birthday,
                                    :regTime,
                                    :active,
                                    :traffic,
                                    :platform,
                                    :ll,
                                    :searchable,
                                    :confirmed,
                                    1
                                )
                            ON DUPLICATE KEY UPDATE            
                                `mail` = :mail2,
                                `login` = :login2,
                                `password` = :password2,
                                `key` = :key2,
                                `site_id` = :siteId2,
                                `gender` = :gender2,
                                `orientation` = :orientation2,
                                `fname` = :fname2,
                                `lname` = :lname2,
                                `country` = :country2,
                                `birthday` = :birthday2,
                                `reg_time` = :regTime2,
                                `active` = :active2,
                                `traffic` = :traffic2,
                                `platform` = :platform2,
                                `ll` = :ll2,
                                `searchable` = :searchable2,
                                `confirmed` = :confirmed2,
                                `test` = 1
                          ;");

                    foreach ($userInfo as $key => $item) {
                        if ($key != 'id') {
                            $this->bindMultiple($insertUserInfoQuery, array(
                                $key,
                                $key . '2'
                            ), $item);
                        } else {
                            $insertUserInfoQuery->bindValue(':id', $item);
                        }
                    }

                    $insertUserInfoQuery->execute();
                    $this->syncDc($userInfo['mail']);
                    return true;
                }
                catch (PDOException $e) {
                    echo $e->getMessage();
                    file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
                    $this->syncDc($userInfo['mail']);
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

    function getUsersForMarkAsTest()
    {
        try {
            $testEmailQuery = $this->db->query("
                SELECT 
                    `mail`
                FROM
                    `profile`
                WHERE
                    `test` IS NULL
                AND
                    `reg_time` < (NOW() - INTERVAL 2 WEEK)
                LIMIT 50
            ;");
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($testEmailQuery->rowCount() > 0) {
            
            while ($row = $testEmailQuery->fetch()) {
                $users[] = $row['mail'];
            }
            return $users;
        } else {
            return false;
        }
    }
    
    function getUsersForSync()
    {
        try {
            $usedEmailQuery = $this->db->query("
                SELECT 
                    `email`
                FROM
                    `temp_profiles`
                LIMIT 500
            ;");
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($usedEmailQuery->rowCount() > 0) {
            
            while ($row = $usedEmailQuery->fetch()) {
                $users[] = $row['email'];
            }
            return $users;
        } else {
            return false;
        }
    }

    function getSitesConfig()
    {
        try {
            $getSitesConfigQuery = $this->db->query("
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
        if ($getSitesConfigQuery->rowCount() > 0) {
            while ($row = $getSitesConfigQuery->fetch()) {
                $sitesConfig[$row['site_id']]['live']         = $row['site_url'];
                $sitesConfig[$row['site_id']]['siteName']    = $row['site_name'];
                $sitesConfig[$row['site_id']]['domain']       = $row['site_domain'];
                $sitesConfig[$row['site_id']]['companyName']  = $row['company_name'];
            }
            return $sitesConfig;
        } else {
            return false;
        }
    }

    function getUsersForUpdate($dc)
    {
        $date = date('Y-m-d H:i:s', strtotime('-12 hours'));
        try {
            $usedEmailForUpdQuery = $this->db->prepare("
                SELECT
                    DISTINCT `mail`
                FROM
                    `profile`
                WHERE
                    `site_id` is NULL
                LIMIT 500
            ;");
            $usedEmailForUpdQuery->bindValue(':dc', $dc);
            $usedEmailForUpdQuery->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($usedEmailForUpdQuery->rowCount() > 0) {
            while ($row = $usedEmailForUpdQuery->fetch()) {
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
            $usedEmailQuery = $this->db->prepare("
                SELECT
                    `id`
                FROM
                    `profile`
                WHERE
                    `dc` = :dc
                AND
                    `reg_time` = '0000-00-00 00:00:00'
            ;");
            $usedEmailQuery->bindValue(':dc', $dc);
            $usedEmailQuery->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
        if ($usedEmailQuery->rowCount() > 0) {
            while ($row = $usedEmailQuery->fetch()) {
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
            $listQuery = $this->db->prepare("
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
            $listQuery->execute();
            $list = array();
            while ($row = $listQuery->fetch()) {
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
            $listQuery = $this->db->prepare("
                SELECT 
                    DISTINCT $createria
                FROM
                    `profile`
                ORDER BY $createria ASC
            ;");
            $listQuery->execute();
            $list = array();
            while ($row = $listQuery->fetch()) {
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

    function syncDates($userId, $site, $config)
    {
        $this->setDc($config);
        $this->adminLogin();
        curl_setopt($this->ch, CURLOPT_URL, "https://www." . $this->mainSite . ".com/profiles/search.php?pid=" . $userId . "&site" . $this->site_conf[$site]['id']);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, "pid=" . $userId . "&chk=&action=ajax_profile_details");
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'X-Requested-With: XMLHttpRequest'
        ));
        $out = curl_exec($this->ch);
        curl_close($this->ch);
        $html     = new nokogiri($out);
        $elements = $html->get("tr")->toArray();
        $regStr = implode('|', $elements[2]['td'][2]['table'][0]['tr'][4]['td'][3]);
        preg_match("/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/i", $regStr, $matches);
        $reg = $matches[0];
        $confStr = implode('|', $elements[2]['td'][2]['table'][0]['tr'][5]['td'][3]);
        preg_match("/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/i", $confStr, $matches);
        $conf = $matches[0];
        $traffStr = implode('|', $elements[2]['td'][2]['table'][0]['tr'][6]['td'][3]);
        preg_match("/([\-a-zA-Z]*)/i", $traffStr, $matches);
        $traff = $matches[0];
        try {
            $dcSyncedUpdateQuery = $this->db->prepare("
                UPDATE 
                    `profile` 
                SET 
                    `reg_time` = :regTime,
                    `conf_time` = :confTime, 
                    `traffic` = :traffic,
                    `last_sync` = NOW()
                WHERE 
                    `id` = :id
            ;");
            $dcSyncedUpdateQuery->bindParam(':id', $userId);
            $dcSyncedUpdateQuery->bindParam(':regTime', $reg);
            $dcSyncedUpdateQuery->bindParam(':confTime', $conf);
            $dcSyncedUpdateQuery->bindParam(':traffic', $traff);
            
            $dcSyncedUpdateQuery->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
        }
    }

    function findByCreaterias($createrias, $sortBy, $sort, $page)
    {
        $createriasText = $createrias;
        $createriasText .= "AND test IS NOT NULL ORDER BY `" . $sortBy . "` " . $sort;
        try {
            $count = 20;
            $limitTo   = $page * $count;
            $limitFrom = $limitTo - $count;
            $findByCreateriaCount = $this->db->prepare("
                SELECT
                    count(*)
                FROM
                    `profile`
                JOIN
                    `sites_config`
                ON
                    `profile`.`site_id` = `sites_config`.`site_id`
                $createriasText
            ;");
            $findByCreateriaCount->execute();
            $countResult = $findByCreateriaCount->fetch();
            $findByCreateriaQuery = $this->db->prepare("
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
                $createriasText
                LIMIT $limitFrom, $limitTo
            ;");
            $findByCreateriaQuery->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage() . '\r\n', FILE_APPEND);
            return false;
        }
        if ($findByCreateriaQuery->columnCount() > 0) {
            $i = 0;
            while ($row = $findByCreateriaQuery->fetch()) {
                $answer['data'][$i]['site']        = $row['site'];
                $answer['data'][$i]['gender']      = $row['gender'];
                $answer['data'][$i]['country']     = $row['country'];
                $answer['data'][$i]['key']         = $row['key'];
                $answer['data'][$i]['regTime']     = $row['reg_time'];
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
                $answer['data'][$i]['siteId']     = $row['site_id'];
                $i++;
            }
            $answer['count']        = $countResult[0];
            $answer['sites']        = $sites;
            $answer['sortElement'] = $sortBy;
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
            $dcSyncedDeleteQueryPh = $this->db->prepare("
                DELETE FROM 
                    `temp_profiles` 
                WHERE 
                    `email` = :currMail
            ;");
            $dcSyncedDeleteQueryPh->bindParam(':currMail', $param);
            $dcSyncedDeleteQueryPh->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
            return false;
        }
    }
}
