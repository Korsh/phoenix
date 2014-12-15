<?php

foreach ($options['keychar'] as $key) {
    $variables .= "var " . end($key['condition']) . " = false;\n";
    $onkeyupFuncString .= " if(e.which == " . $key['button'] . ")\n{\n  " . end($key['condition']) . "=false;\n}\n";
    $onkeydownFuncString .= " if(e.which == " . $key['button'] . ")\n{\n  " . end($key['condition']) . "=true;\n}\n";
    $conditionsString .= " if(";
    for ($i = 0; $i < sizeof($key['condition']); $i++) {
        if ($i != sizeof($key['condition']) - 1)
            $conditionsString .= $key['condition'][$i] . ' && ';
        else
            $conditionsString .= $key['condition'][$i];
    }
    if ($key['function'] == 'registerUser') {
        $conditionsString .= " && flag_register)\n{\n  " . $key['function'] . "('" . $key['value'] . "');\n}\n";
    } elseif ($key['function'] == 'setPaymentFields') {
        $conditionsString .= " && flag_pay)\n{\n  " . $key['function'] . "('" . $key['value'] . "');\n}\n";
    } elseif ($key['function'] == 'generateScreenname') {
        $conditionsString .= " && flag_funnel)\n{\n  " . $key['function'] . "('" . $key['value'] . "');\n}\n";
    }
}

foreach ($sites as $key) {
    if ($key['domain'] != '') {
        $sitesString .= "// @match     *://*." . $key['domain'] . "/*\n";
    }
}

$cities = json_encode($cities);
$alphabet = json_encode($alphabet);
$host = $_SERVER["HTTP_HOST"];
$optionsMailAccount = $options['mail']['account'];
$optionsMailDomain = $options['mail']['domain'];

$scriptSrc = <<<END
// ==UserScript==
// @name        PhoenixAuto

// @match *://*.trunk-front.pmmedia.com.ua/*
// @match *://*.ph-live.hwtool.net/*
// @match *://*.ph-rel.hwtool.net/*
// @match *://*.rel.platformphoenix.com/*

$sitesString
// @exclude     *://redmine.hwtool.net/*
// @exclude     *://mail.google.com/*
// @exclude     *://docs.google.com/*
// @exclude     *://*.google.com/*
// @grant       GM_xmlhttpRequest
// @grant       GM_info
// @downloadURL   https://$host/$scriptId.user.js
// @updateURL   https://$host/meta.js
// @version     $scriptVersion
// ==/UserScript==

GM_info.scriptWillUpdate = true;

var answer;
var country;
var city;
var region;
getCountry();

var date = new Date();
var screenname = '';
var cities = {};
var alphabet = {};
var isShift=false;
var isAlt=false;
var isCtrl=false;
var flag_register = true;
var flag_pay = true;
var flag_funnel = true;

$variables


cities = $cities;
alphabet = $alphabet;

var uniqueAdding = date.getTime();
var screenname_adding = date.getTime().toString().slice(-5);

for(i=0; i<getRandomArbitary(3, 7);i++){
  screenname = screenname+alphabet[getRandomArbitary(0,22)];
}
screenname = screenname+screenname_adding;

window.onkeyup=function(e)
{
  if(e.which == 16){
    isShift=false;
  }
  if(e.which == 17){
    isCtrl=false;
  }
  if(e.which == 18){
    isAlt=false;
  }
$onkeyupFuncString
}

window.onkeydown=function(e)
{
    if(e.which == 16){
      isShift = true;
    }
    if(e.which == 17){
      isCtrl = true;
    }
    if(e.which == 18){
      isAlt = true;
    }
    $onkeydownFuncString
    $conditionsString


}

function getRandomArbitary(min, max)
{
  return parseInt(Math.random() * (max - min) + min);
}

function generateScreenname()
{
  if(document.getElementById('UserForm_login')){
    setInputValue(document.getElementById('UserForm_login'), screenname);
  }

  if(document.getElementById('funnelScreenname')){
    setInputValue(document.getElementById('funnelScreenname'), screenname);
  }


}

function registerUser(gender){

  var reg_mail;
  var reg_gender;
  var reg_password;
  var reg_submit;
  var reg_year = new Date().getFullYear()-23
  var reg_day = '10';
  var reg_month = '10';
  var site_name = document.documentURI.split('.')[1];
  var mail = '$optionsMailAccount+'+uniqueAdding+'@$optionsMailDomain';
  var password = '123123';
  var reg_location = city;

  document.cookie = 'searchDebug=1;';
  if(document.getElementById('UserForm_year')){
    document.getElementById('UserForm_year').parentElement.childNodes[1].innerHTML = reg_year;
    setInputValue(document.getElementById('UserForm_year'), reg_year);
  }

  if(document.getElementById('UserForm_month')){
    document.getElementById('UserForm_month').parentElement.childNodes[1].innerHTML = reg_month;
    setInputValue(document.getElementById('UserForm_month'), reg_month);
  }

  if(document.getElementById('UserForm_day')){
    document.getElementById('UserForm_day').parentElement.childNodes[1].innerHTML = reg_day;
    setInputValue(document.getElementById('UserForm_day'), reg_day);
  }

if(document.getElementsByName('UserFormWebCam[first_name]')[0]){
  setInputValue(document.getElementsByName('UserFormWebCam[first_name]')[0], screenname);
}

if(document.getElementById('screenname')){
  setInputValue(document.getElementById('UserForm_screenname'), screenname);
}
else{
  var inp = document.createElement('input');
  inp.setAttribute('id','UserForm_screenname');
  inp.setAttribute('type','hidden');
  inp.setAttribute('name','UserForm_screenname');
  inp.setAttribute('value',screenname);
  if(document.getElementById('register-form')){
    document.getElementById('register-form').appendChild(inp);
  }
  else{
    document.forms[0].appendChild(inp);
  }
}

if(document.getElementById('UserForm_just_email'))setInputValue(document.getElementById('UserForm_just_email'), mail);
if(document.getElementById('UserForm_email'))setInputValue(document.getElementById('UserForm_email'), mail);
if(document.getElementsByName('UserFormWebCam[password]')[0])setInputValue(document.getElementsByName('UserFormWebCam[password]')[0], mail);

if(document.getElementById('UserForm_password'))setInputValue(document.getElementById('UserForm_password'), password);
if(document.getElementsByName('UserFormWebCam[password]')[0])setInputValue(document.getElementsByName('UserFormWebCam[password]')[0], password);
  if(document.getElementById('UserForm_location')){
      setInputValue(document.getElementById('UserForm_location'), reg_location);
  }

  if(document.getElementsByTagName('select').UserForm_gender || document.getElementById('UserForm_gender')){
    if(gender == '1'){
      setInputValue(document.getElementById('UserForm_gender'), 'male');
    }
    else if(gender == '2'){
      setInputValue(document.getElementById('UserForm_gender'), 'female');
    }
  }

  saveProfile(mail)

}

function setPaymentFields(input){

  var card_number;
  var card_month;
  var card_year;
  var card_name;
  var card_cv2;
  var card_address;
  var card_zip;


  switch(input) {
    case 'Visa':
      card_number = ['4012','8888','8888','1881'];
      card_month = '10';
      card_year = '2016';
      card_name_first = 'Mark';
      card_name_last = 'Shelton';
      card_cv2 = '521';
      card_address = 'Beverly Hills,123';
      card_zip = '90210';
      break;

    case 'MasterCard':
      card_number = ['5555','5555','5555','4444'];
      card_month = '10';
      card_year = '2016';
      card_name_first = 'Mark';
      card_name_last = 'Shelton';
      card_cv2 = '521';
      card_address = 'Beverly Hills,123';
      card_zip = '90210';
      break;

    case 'WrongDate':
      card_number = ['5555','5555','5555','4444'];
      card_month = '10';
      card_year = '2020';
      card_name_first = 'Mark';
      card_name_last = 'Shelton';
      card_cv2 = '521';
      card_address = 'Beverly Hills,123';
      card_zip = '90210';
      break;

    case 'WrongCode':
      card_number = ['5555','5555','5555','4444'];
      card_month = '10';
      card_year = '2016';
      card_name_first = 'Mark';
      card_name_last = 'Shelton';
      card_cv2 = '520';
      card_address = 'Beverly Hills,123';
      card_zip = '90210';
      break;

    default:
      card_number = ['4012','8888','8888','1881'];
      card_month = '10';
      card_year = '2016';
      card_name_first = 'Mark';
      card_name_last = 'Shelton';
      card_cv2 = '521';
      card_address = 'Beverly Hills,123';
      card_zip = '90210';
      break;
  }
    card_full = card_number[0]+card_number[1]+card_number[2]+card_number[3];
    if(document.getElementById('CreditCardPaymentForm_card_number')){
        document.getElementById('CreditCardPaymentForm_card_number').value =  card_full;
    }
    for(i=0;i<4;i++) {
        setInputValue(document.getElementById('CreditCardPaymentForm_card_number').parentElement.children[i], card_number[i]);
    }
    if(document.getElementById('CreditCardPaymentForm_expiration_date_m')){
        setInputValue(document.getElementById('CreditCardPaymentForm_expiration_date_m'), card_month);
        document.getElementById('CreditCardPaymentForm_expiration_date_m').parentNode.getElementsByTagName('span')[0].innerHTML = card_month;
    }

  if(document.getElementById('CreditCardPaymentForm_expiration_date_y')){
    setInputValue(document.getElementById('CreditCardPaymentForm_expiration_date_y'), card_year);
    document.getElementById('CreditCardPaymentForm_expiration_date_y').parentNode.getElementsByTagName('span')[0].innerHTML = card_year;
  }

  if(document.getElementById('CreditCardPaymentForm_card_holder'))setInputValue(document.getElementById('CreditCardPaymentForm_card_holder'), card_name_first+' '+card_name_last);

  if(document.getElementById('CreditCardPaymentForm_security_number'))setInputValue(document.getElementById('CreditCardPaymentForm_security_number'), card_cv2);

  if(document.getElementById('CreditCardPaymentForm_name_first'))setInputValue(document.getElementById('CreditCardPaymentForm_name_first'), card_name_first);

  if(document.getElementById('CreditCardPaymentForm_name_last'))setInputValue(document.getElementById('CreditCardPaymentForm_name_last'), card_name_last);
  if(document.getElementById('CreditCardPaymentForm_address'))setInputValue(document.getElementById('CreditCardPaymentForm_address'), card_name_last);

  if(document.getElementById('CreditCardPaymentForm_city'))setInputValue(document.getElementById('CreditCardPaymentForm_city'), card_address);

  if(document.getElementById('CreditCardPaymentForm_postal_code'))setInputValue(document.getElementById('CreditCardPaymentForm_postal_code'), card_zip);


    document.getElementById('CreditCardPaymentForm_card_holder').click();
}

function setInputValue(element, value){
  if(element.type == 'select-one'){
    var options = element.options;
     for (var i = 0; i < options.length; i++) {
       if(value == false){
         if(i == options.length-1){
           options[i].selected = true;
         }
         else{
           options[i].selected = false;
         }
       }
       else{
         if(options[i].getAttribute('value') == value){
           options[i].selected = true;
           break;
         }
         else if(options[i].getAttribute('value') >= value){
           options[i].selected = true;
         }
         else{
           options[i].selected = false;
         }
       }

     }
  }
  else if(element.type == 'text' || element.type == 'password' || element.type == 'tel'){
    element.value = value;
  }
}

function saveProfile(mail){
  GM_xmlhttpRequest({
    url: 'https://$host/save_profile/',
    method: 'POST',
    data: 'mail='+encodeURIComponent(mail),
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    onload: function(response) {

        if(document.getElementById('btn_register_submit'))document.getElementById('btn_register_submit').click()
    if(document.getElementsByClassName('btn-submit')[0])document.getElementsByClassName('btn-submit')[0].click()
        if(document.getElementById('submit_button'))document.getElementById('submit_button').click()
        if(document.getElementById('submit-button')){
          document.getElementById('submit-button').click();
          document.getElementById('submit-button').click();
          document.getElementById('submit-button').click();
        }

    }
  });
}

function getCountry(){
  GM_xmlhttpRequest({
    url: 'http://api.ipinfodb.com/v3/ip-city/?key=8cef7e56baa8c0bcfe5591b6624fe611bb4e58c5c8b481619dcb6a485f48aa44&format=json',
    method: 'GET',
    onload: function(response) {
      if(!response.responseText){
    getCountryMy(null);
        return false;
      }
      else{
        k = JSON.parse(response.responseText);
        country_code = k['countryCode'];
        country = k['countryName'];
    region = k['regionName'];
        city = k['cityName'];
    if(k['zipCode'] != '-')
    {
            zipcode = k['zipCode'];
    }
    else
    {
        zipcode = '';
    }
    city = city+', '+zipcode;
        return true;
      }
    }

  });

}
END;
