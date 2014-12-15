<?php
    $localeConf = array(
        'en' => array(
            0 => array(
                'proxy' => 'GBR',
                'enable' => true,
            ),
            1 => array(
                'proxy' => 'USA',
                'enable' => true,
            ),
            2 => array(
                'proxy' => 'CAN',
                'enable' => true,
            ),
            3 => array(
                'proxy' => 'USA',
                'enable' => true,
            ),
            4 => array(
                'proxy' => 'AUS',
                'enable' => true,
            ),
            5 => array(
                'proxy' => 'NZL',
                'enable' => true,
            ),
            6 => array(
                'proxy' => 'ZAF',
                'enable' => false,
            ),
            7 => array(
                'proxy' => 'IND',
                'enable' => false,
            ),
            8 => array(
                'proxy' => 'NZL',
                'enable' => true,
            ),
            9 => array(
                'proxy' => 'GBR2',
                'enable' => true,
            ),
            10 => array(
                'proxy' => 'CAN2',
                'enable' => true,
            ),
            11 => array(
                'proxy' => 'IRL',
                'enable' => true,
            ),
        ),
        'es' => array(
            0 => array(
                'proxy' => 'ESP',
                'enable' => true,
            ),
            1 => array(
                'proxy' => 'ARG',
                'enable' => false,
            ),
        ),
        'fr' => array(
            0 => array(
                'proxy' => 'FRA',
                'enable' => true,
            ),
        ),
        'it' => array(
            0 => array(
                'proxy' => 'ITA',
                'enable' => true,
            ),
        ),
        'de' => array(
            0 => array(
                'proxy' => 'DEU',
                'enable' => true,
            ),
        ),
        'no' => array(
            0 => array(
                'proxy' => 'NOR',
                'enable' => true,
            ),
        ),
        'dk' => array(
            0 => array(
                'proxy' => 'DNK',
                'enable' => true,
            ),
        ),
        'se' => array(
            0 => array(
                'proxy' => 'SWE',
                'enable' => true,
            ),
        ),
        'ot' => array(
            0 => array(
                'proxy' => 'TUR',
                'enable' => false,
            ),
            1 => array(
                'proxy' => 'AUT',
                'enable' => false,
            ),
            2 => array(
                'proxy' => 'BEL',
                'enable' => false,
            ),
            3 => array(
                'proxy' => 'CZE',
                'enable' => false,
            ),
            4 => array(
                'proxy' => 'NLD',
                'enable' => false,
            ),
            5 => array(
                'proxy' => 'PRT',
                'enable' => false,
            ),
            6 => array(
                'proxy' => 'CHE',
                'enable' => false,
            ),
            7 => array(
                'proxy' => 'CHN',
                'enable' => false,
            ),
            8 => array(
                'proxy' => 'IDN',
                'enable' => false,
            ),
            9 => array(
                'proxy' => 'JPN',
                'enable' => false,
            ),
            10 => array(
                'proxy' => 'MYS',
                'enable' => false,
            ),
            11 => array(
                'proxy' => 'PHL',
                'enable' => false,
            ),
            12 => array(
                'proxy' => 'MEX',
                'enable' => false,
            ),
            13 => array(
                'proxy' => 'BRA',
                'enable' => false,
            ),

        ),

    );
    $proxy = $ui->getProxyConfig();

    /*$proxy = array(
        "GBR" => array(
            "country" => "GBR",
            "cityName" => "London",
            "ipAddress" => "46.17.57.142",
            "domain" => "p-uk1.biscience.com",
            "port" => 3128,
            "countryCode2" => "GB",
            "enable" => true,
            "timeShift" => "-2",
        ),
        "ESP" => array(
            "country" => "ESP",
            "cityName" => "Madrid",
            "ipAddress" => "91.142.213.109",
            "domain" => "p-es1.biscience.com",
            "port" => 3128,
            "countryCode2" => "ES",
            "enable" => true,
            "timeShift" => "-1",
        ),
        "FRA" => array(
            "country" => "FRA",
            "cityName" => "Paris",
            "ipAddress" => "91.121.80.205",
            "domain" => "p-fr1.biscience.com",
            "port" => 3128,
            "countryCode2" => "FR",
            "enable" => true,
            "timeShift" => "-1",
        ),
        "TUR" => array(
            "country" => "TUR",
            "cityName" => "Istanbul",
            "ipAddress" => "213.128.83.50",
            "domain" => "p-tr1.biscience.com",
            "port" => 3128,
            "countryCode2" => "TR",
            "enable" => false,
        ),
        "AUT" => array(
            "country" => "AUT",
            "cityName" => "Graz",
            "ipAddress" => "37.235.57.23",
            "domain" => "p-at1.biscience.com",
            "port" => 3128,
            "countryCode2" => "AT",
            "enable" => false,
        ),
        "BEL" => array(
            "country" => "BEL",
            "cityName" => "Braine-l'Alleud",
            "ipAddress" => "81.95.121.251",
            "domain" => "p-be1.biscience.com",
            "port" => 3128,
            "countryCode2" => "BE",
            "enable" => false,
            "timeShift" => "-1",
        ),
        "CZE" => array(
            "country" => "CZE",
            "cityName" => "Praha",
            "ipAddress" => "81.2.197.93",
            "domain" => "p-cz1.biscience.com",
            "port" => 3128,
            "countryCode2" => "CZ",
            "enable" => false,
        ),
        "DNK" => array(
            "country" => "DNK",
            "cityName" => "Copenhagen",
            "ipAddress" => "94.231.110.81",
            "domain" => "p-dk1.biscience.com",
            "port" => 3128,
            "countryCode2" => "DK",
            "enable" => true,
            "timeShift" => "-1",
        ),
        "DEU" => array(
            "country" => "DEU",
            "cityName" => "Hosten",
            "ipAddress" => "80.237.249.248",
            "domain" => "p-de1.biscience.com",
            "port" => 3128,
            "countryCode2" => "DE",
            "enable" => true,
            "timeShift" => "-1",
        ),
        "IRL" => array(
            "country" => "IRL",
            "cityName" => "Dublin",
            "ipAddress" => "78.137.160.60",
            "domain" => "p-ie1.biscience.com",
            "port" => 3128,
            "countryCode2" => "IE",
            "enable" => true,
            "timeShift" => "-2",
        ),
        "ITA" => array(
            "country" => "ITA",
            "cityName" => "Milano",
            "ipAddress" => "195.88.7.112",
            "domain" => "p-it1.biscience.com",
            "port" => 3128,
            "countryCode2" => "IT",
            "enable" => true,
            "timeShift" => "-1",
        ),
        "NLD" => array(
            "country" => "NLD",
            "cityName" => "Amsterdam",
            "ipAddress" => "178.237.42.37",
            "domain" => "p-nl1.biscience.com",
            "port" => 3128,
            "countryCode2" => "NL",
            "enable" => false,
            "timeShift" => "-1",
        ),
        "NOR" => array(
            "country" => "NOR",
            "cityName" => "Oslo",
            "ipAddress" => "81.27.33.8",
            "domain" => "p-no1.biscience.com",
            "port" => 3128,
            "countryCode2" => "NO",
            "enable" => true,
            "timeShift" => "-1",
        ),
        "PRT" => array(
            "country" => "PRT",
            "cityName" => "Lisbon",
            "ipAddress" => "188.93.226.136",
            "domain" => "p-pt1.biscience.com",
            "port" => 3128,
            "countryCode2" => "PT",
            "enable" => false,
        ),
        "SWE" => array(
            "country" => "SWE",
            "cityName" => "Stockholm",
            "ipAddress" => "91.189.44.162",
            "domain" => "p-se1.biscience.com",
            "port" => 3128,
            "countryCode2" => "SE",
            "enable" => true,
            "timeShift" => "-1",
        ),
        "CHE" => array(
            "country" => "CHE",
            "cityName" => "Berne",
            "ipAddress" => "92.42.186.167",
            "domain" => "p-ch1.biscience.com",
            "port" => 3128,
            "countryCode2" => "CH",
            "enable" => false,
        ),
        //Africa
        "ZAF" => array(
            "country" => "ZAF",
            "cityName" => "Capetown",
            "ipAddress" => "41.222.38.155",
            "domain" => "p-za1.biscience.com",
            "port" => 3128,
            "countryCode2" => "ZA",
            "enable" => false,
        ),
        //Asia
        "CHN" => array(
            "country" => "CHN",
            "cityName" => "Beijing",
            "ipAddress" => "202.142.24.244",
            "domain" => "p-cn1.biscience.com",
            "port" => 3128,
            "countryCode2" => "CN",
            "enable" => false,
        ),
        "IND" => array(
            "country" => "IND",
            "cityName" => "Dadri",
            "ipAddress" => "111.118.186.245",
            "domain" => "p-in1.biscience.com",
            "port" => 3128,
            "countryCode2" => "IN",
            "enable" => false,
        ),
        "IDN" => array(
            "country" => "IDN",
            "cityName" => "Jakarta",
            "ipAddress" => "111.221.43.103",
            "domain" => "p-id1.biscience.com",
            "port" => 3128,
            "countryCode2" => "ID",
            "enable" => false,
        ),
        "JPN" => array(
            "country" => "JPN",
            "cityName" => "Tokio",
            "ipAddress" => "110.50.241.69",
            "domain" => "p-jp1.biscience.com",
            "port" => 3128,
            "countryCode2" => "JP",
            "enable" => false,
        ),
        "MYS" => array(
            "country" => "MYS",
            "cityName" => "ShahAlam",
            "ipAddress" => "124.217.230.104",
            "domain" => "p-my1.biscience.com",
            "port" => 3128,
            "countryCode2" => "MY",
            "enable" => false,
        ),
        "PHL" => array(
            "country" => "PHL",
            "cityName" => "Manila",
            "ipAddress" => "121.127.11.235",
            "domain" => "p-ph1.biscience.com",
            "port" => 3128,
            "countryCode2" => "PH",
            "enable" => false,
        ),
        "AUS" => array(
        //Australia
            "country" => "AUS",
            "cityName" => "Canberra",
            "ipAddress" => "223.252.33.75",
            "domain" => "p-au1.biscience.com",
            "port" => 3128,
            "countryCode2" => "AU",
            "enable" => true,
            "timeShift" => "7",
        ),
        "NZL" => array(
            "country" => "NZL",
            "cityName" => "Wellington",
            "ipAddress" => "103.16.180.137",
            "domain" => "p-nz1.biscience.com",
            "port" => 3128,
            "countryCode2" => "NZ",
            "enable" => true,
            "timeShift" => "9",
        ),
        "CAN" => array(
        //NorthAmerica
            "country" => "CAN",
            "cityName" => "Vancouver",
            "ipAddress" => "199.167.19.29",
            "domain" => "p-ca2.biscience.com",
            "port" => 3128,
            "countryCode2" => "CA",
            "enable" => true,
            "timeShift" => "-8",
        ),
        "MEX" => array(
            "country" => "MEX",
            "cityName" => "MexicocityName",
            "ipAddress" => "201.150.38.98",
            "domain" => "p-mx1.biscience.com",
            "port" => 3128,
            "countryCode2" => "MX",
            "enable" => false,
        ),
        "USA" => array(
            "country" => "USA",
            "cityName" => "NewYork",
            "ipAddress" => "173.208.57.59",
            "domain" => "p-us1.biscience.com",
            "port" => 3128,
            "countryCode2" => "US",
            "enable" => true,
            "timeShift" => "-5",
        ),
        "USA2" => array(
            "country" => "USA",
            "cityName" => "Boston",
            "ipAddress" => "192.34.82.122",
            "domain" => "p-us22.biscience.com",
            "port" => 3128,
            "countryCode2" => "US",
            "enable" => true,
            "timeShift" => "-5",
        ),
        //SouthAmerica
        "ARG" => array(
            "country" => "ARG",
            "cityName" => "BuenosAires",
            "ipAddress" => "200.58.97.198",
            "domain" => "p-ar1.biscience.com",
            "port" => 3128,
            "countryCode2" => "AR",
            "enable" => false,
        ),
        "BRA" => array(
            "country" => "BRA",
            "cityName" => "Brazilia",
            "ipAddress" => "201.33.19.9",
            "domain" => "p-br1.biscience.com",
            "port" => 3128,
            "countryCode2" => "BR",
            "enable" => false,
        ),
        "GBR2" => array(
            "country" => "GBR",
            "cityName" => "London",
            "ipAddress" => "213.171.197.181",
            "domain" => "p-uk3.biscience.com",
            "port" => 3128,
            "countryCode2" => "GB",
            "enable" => true,
            "timeShift" => "-2",
        ),
        "CAN2" => array(
        //NorthAmerica
            "country" => "CAN",
            "cityName" => "Quebec",
            "ipAddress" => "68.168.114.114",
            "domain" => "p-ca4.biscience.com",
            "port" => 3128,
            "countryCode2" => "CA",
            "enable" => true,
            "timeShift" => "-5",
        ),
    );*/
    //var_dump($proxy);
/*
    foreach($proxy as $key)
    {    
        if(!$proxy[$key]['enable'])
        {            
            unset($proxy[$key]);
        }
    }
*/
    ksort($proxy);
