// ==UserScript==
// @name        AutoScripts
// @include     http://*.hwtool.net
// @include     http://*.shagaholic.com/*
// @include     http://*.upforit.com/*
// @include     http://*.saucysingles.com/*
// @include     http://*.iwantu.com/*
// @include     http://*.sololigar.com/*
// @include     http://*.sexlugar.com/*
// @include     http://*.quierorollo.es
// @include     http://*.ulove.com/*
// @include     http://*.dammisesso.it
// @include     http://*.piacerediscreto.com/*
// @include     http://*.treffegirls.com/*
// @include     http://*.gibmirsex.com/*
// @include     http://*.milfberry.com/*
// @include     http://*.sugarbbw.com/*
// @include     http://*.getanaffair.com/*
// @include     http://*.maritalhookup.com/*
// @include     http://*.bediscreet.com/*
// @include     http://*.maturexmatch.com/*
// @include     http://*.passionmature.com/*
// @include     http://*.amissexy.com/*
// @include     http://*.cougarpourmoi.com/*
// @include     http://*.soissecret.com/*
// @include     http://*.cambiarpareja.com/*
// @include     http://*.relacionesmaduras.com/*
// @include     http://*.relacionsecreta.com/*
// @include     http://*.madurasyjovenes.com/*
// @include     http://*.relacionesprivadas.es 
// @include     http://*.hornyplumps.com/*
// @include     http://*.mybbwmatch.com/*
// @include     http://*.hornyasia.com/*
// @include     http://*.iwantubbw.com/* 
// @include     http://*.iwantumilf.com/* 
// @include     http://*.breastyaffairs.com/*  
// @include     http://*.bbwsweety.com/*
// @grant       GM_xmlhttpRequest
// ==/UserScript==

var isShift = false;
var isAlt = false;
var isW = false;
date = new Date();
var cities = {};

//Europe
cities["GBR"] = "London";
cities["ESP"] = "Madrid";
cities["FRA"] = "Paris";
cities["AUT"] = "Graz";
cities["BEL"] = "Braine-l'Alleud";
cities["CZE"] = "Praha";
cities["DNK"] = "Copenhagen";
cities["DEU"] = "Hosten";
cities["IRL"] = "Dublin";
cities["ITA"] = "Milano";
cities["NLD"] = "Amsterdam";
cities["NOR"] = "Oslo";
cities["PRT"] = "Lisbon";
cities["SWE"] = "Stockholm";
cities["CHE"] = "Berne";

//Africa
cities["ZAF"] = "Capetown";

//Asia
cities["IND"] = "Dadri";
cities["IDN"] = "Jakarta";
cities["JPN"] = "Tokio";
cities["MYS"] = "Shah Alam";
cities["PHL"] = "Manila";

//Australia
cities["AUS"] = "Canberra";
cities["NZL"] = "Wellington";

//North America
cities["CAN"] = "Vancouver";
cities["MEX"] = "Mexico City";
cities["USA"] = "New York";

//South America
cities["ARG"] = "Buenos Aires";
cities["BRA"] = "Brazilia";

var uniqueAdding = date.getTime();

window.onkeyup=function(e)
{                                
  if(e.which == 16)
  {
    isShift=false;
  }
  if(e.which == 18)
  {
    isAlt=false;
  }
  if(e.which == 87)
  {
    isW=false;
  } 
}

window.onkeydown=function(e) {  
    if(e.which == 16) isShift = true;
    if(e.which == 87) isW=true;
    if(e.which == 18) isAlt = true;
    if(isShift === true)
    {
      if(e.which == 77 && isShift === true) {
          registerUser(1);
          return false;        
      }
      else if(e.which == 70 && isShift === true) {
          registerUser(2);
          return false;
          
      }
      else if(e.which == 67 && isShift === true) {
          registerUser(3);
          return false;        
      }
    }
    else if(isAlt === true)
    {     
      if(e.which == 77 && isAlt === true) {          
          setPaymentFields("MasterCard");
          return false;
      }
      else if(e.which == 86 && isAlt === true) {          
          setPaymentFields("Visa");
          return false;
      }
      else if(e.which == 49 && isW === true && isAlt === true) {          
          setPaymentFields("WrongCode");
          return false;
      }
      else if(e.which == 50 && isW === true && isAlt === true) {          
          setPaymentFields("WrongDate");
          return false;
      }               
    }
    
}


function registerUser(gender){

var reg_mail;
var reg_gender;
var reg_password;
var reg_location;
var reg_submit;

document.baseURI.split('.')[document.baseURI.split('.').length - 2]
var site_name = document.documentURI.split('.')[1];
var mail = 'ide777spainbn+'+uniqueAdding+'@gmail.com';
var password = '123123';
 
if(!document.getElementsByTagName('select').frmYear)
{
  if(document.getElementsByName('frmDay')[0])document.getElementsByName('frmDay')[0].value = '10';
  if(document.getElementsByName('frmMonth')[0])document.getElementsByName('frmMonth')[0].value = '10';
  if(document.getElementsByName('frmYear')[0])document.getElementsByName('frmYear')[0].value = '1980';  
}

if(document.getElementById('email'))
{   
  document.getElementById('email').value = mail;
  //document.getElementById('email').setAttribute('disabled', 'true');
}
if(document.getElementsByName('mobile_number_or_email')[0])
{
  document.getElementsByName('mobile_number_or_email')[0].value = mail;
  //document.getElementsByName('mobile_number_or_email')[0].setAttribute('disabled', 'true');
}

if(document.getElementById('password'))document.getElementById('password').value = password;
if(document.getElementsByName('password')[0])document.getElementsByName('password')[0].value = password;

if(document.getElementById('country'))country = document.getElementById('country').value;
  
if(document.getElementById('location'))document.getElementById('location').value = cities[country];
if(document.getElementsByName('location')[0])document.getElementsByName('location')[0].value = cities[country];
    
  if(document.getElementsByTagName('select').frmGender)
  {
    var options = document.getElementById('frmGender').options;
    for (var i = 0; i < options.length; i++) 
    {
      if(options[i].getAttribute('value') == gender)
      {
        options[i].selected = true;
      }
      else
      {
        options[i].selected = false;
      }
    }
  }
  else
  {  
    if(gender == 1)
    {
      if(document.getElementById('frmGender_m'))document.getElementById('frmGender_m').click();
      if(document.getElementById('sexuality_by_gender_2'))document.getElementById('sexuality_by_gender_2').click();
    }
    else if(gender == 2)
    {
      if(document.getElementById('frmGender_w'))document.getElementById('frmGender_w').click();
      if(document.getElementById('sexuality_by_gender_1'))document.getElementById('sexuality_by_gender_1').click();    
    }  
  }

  
  if(document.scripts.length == 0)
  {
    device_type = "non-js";
  }
  else
  {
    for(i=0; i<document.scripts.length; i++)
    {
      if(document.scripts[i].src.contains('mobile'))
      {
        device_type = "js";
        break;  
      }
      else
      {
        device_type = "web";
      }
    }
  }

  saveProfile(site_name, country, mail, gender, device_type)
   
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
    card_number = "4012888888881881";
    card_month = "10";
    card_year = "2016";
    card_name_first = "Mark";
    card_name_last = "Shelton";
    card_cv2 = "521";
    card_address = "Beverly Hills,123";
    card_zip = "90210";
    break;

  case 'MasterCard':
    card_number = "5555555555554444";
    card_month = "10";
    card_year = "2016";
    card_name_first = "Mark";
    card_name_last = "Shelton";
    card_cv2 = "521";
    card_address = "Beverly Hills,123";
    card_zip = "90210";
    break;

  case 'WrongDate':
    card_number = "5555555555554444";
    card_month = "10";
    card_year = "2020";
    card_name_first = "Mark";
    card_name_last = "Shelton";
    card_cv2 = "521";
    card_address = "Beverly Hills,123";
    card_zip = "90210";
    break;
    
  case 'WrongCode':
    card_number = "5555555555554444";
    card_month = "10";
    card_year = "2016";
    card_name_first = "Mark";
    card_name_last = "Shelton";
    card_cv2 = "520";
    card_address = "Beverly Hills,123";
    card_zip = "90210";
    break;
        
  default:
    card_number = "4012888888881881";
    card_month = "10";
    card_year = "2016";
    card_name_first = "Mark";
    card_name_last = "Shelton";
    card_cv2 = "521";
    card_address = "Beverly Hills,123";
    card_zip = "90210";
    break;
}


if(document.getElementById('card_number'))document.getElementById('card_number').value = card_number

if(document.getElementById('card-number'))document.getElementById('card-number').value = card_number

if(document.getElementById('card_expiration_month') || document.getElementById('card-expiration-month'))
{
  if(document.getElementById('card_expiration_month'))
  {
    var options = document.getElementById('card_expiration_month').options;
  } 
  else
  {
    var options = document.getElementById('card-expiration-month').options;  
  }
    
  for (var i = 0; i < options.length; i++) 
  {
    if(options[i].getAttribute('value') == card_month)
    {
      options[i].selected = true;
    }
    else
    {
      options[i].selected = false;
    }
  }
}

if(document.getElementById('card_expiration_year') || document.getElementById('card-expiration-year'))
{
  if(document.getElementById('card_expiration_year'))
  {
    var options = document.getElementById('card_expiration_year').options;
  } 
  else
  {
    var options = document.getElementById('card-expiration-year').options;  
  }
    
  for (var i = 0; i < options.length; i++) 
  {
    if(options[i].getAttribute('value') == card_year)
    {
      options[i].selected = true;
    }
    else
    {
      options[i].selected = false;
    }
  }
}

if(document.getElementById('card_cardholder_name'))document.getElementById('card_cardholder_name').value = card_name_first+" "+card_name_last

if(document.getElementById('card-cardholder-name'))document.getElementById('card-cardholder-name').value = card_name_first+" "+card_name_last


if(document.getElementById('card_cv2'))document.getElementById('card_cv2').value = card_cv2

if(document.getElementById('card-security'))document.getElementById('card-security').value = card_cv2

if(document.getElementById('card-cardholder-first-name'))document.getElementById('card-cardholder-first-name').value = card_name_first

if(document.getElementById('card-cardholder-first-name-optional'))document.getElementById('card-cardholder-first-name-optional').value = card_name_first

if(document.getElementById('card-cardholder-last-name'))document.getElementById('card-cardholder-last-name').value = card_name_last

if(document.getElementById('card-cardholder-last-name-optional'))document.getElementById('card-cardholder-last-name-optional').value = card_name_last

if(document.getElementById('card-cardholder-address'))document.getElementById('card-cardholder-address').value = card_address

if(document.getElementById('card-cardholder-address-optional'))document.getElementById('card-cardholder-address-optional').value = card_address

if(document.getElementById('card_address'))document.getElementById('card_address').value = card_address

if(document.getElementById('card-cardholder-city'))document.getElementById('card-cardholder-city').value = card_address

if(document.getElementById('card-cardholder-city-optional'))document.getElementById('card-cardholder-city-optional').value = card_address

if(document.getElementById('card-cardholder-zip'))document.getElementById('card-cardholder-zip').value = card_zip  


if(document.getElementById('card-cardholder-zip-optional'))document.getElementById('card-cardholder-zip-optional').value = card_zip  

if(document.getElementById('card_zip'))document.getElementById('card_zip').value = '1234'

}

function saveProfile(site_name, country, mail, gender, device_type){
  GM_xmlhttpRequest({    
    url: "http://qa.arzhanov.trunk-web1.pmmedia.com.ua/save_profile/",
    method: "POST",
    data: "mail="+encodeURIComponent(mail),
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    onload: function(response) {
      //alert(response.responseText)
      if(!response.responseText)
      {
        alert("Error while saving user...");
      }
      else
      {
        if(document.getElementById('sign_up_form'))document.getElementById('sign_up_form').submit()
        if(document.getElementsByClassName('join')[0])document.getElementsByClassName('join')[0].click()
        if(document.getElementsByClassName('button_like')[0])document.getElementsByClassName('button_like')[0].click()
      } 
    }
  });  
}