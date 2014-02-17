// ==UserScript==
// @name        PhoenixAuto
// @match     *://*.hwtool.net/*
// @match     *://*.alcuda.priv/*
// @match     *://*.pmmedia.priv/*

// @match     *://*.playcougar.com/*
// @match     *://*.localsgowild.com/*
// @match     *://*.freesexmatch.com/*
// @match     *://*.clickandflirt.com/*

// @exclude     *://redmine.hwtool.net/*
// @exclude     *://mail.google.com/*
// @exclude     *://docs.google.com/*
// @exclude     *://*.google.com/*
// @grant       GM_xmlhttpRequest
// @grant       GM_info 
// @downloadURL   https://phoenix.arzhanov.trunk-web1.pmmedia.com.ua/1392189744.user.js
// @updateURL   https://phoenix.arzhanov.trunk-web1.pmmedia.com.ua/meta.js
// @version     0.0.1
// ==/UserScript==

GM_info.scriptWillUpdate = true;

var answer;
var country;
var city;
getCountryInfo();

var date = new Date();
var screenname = "";
var cities = {};
var alphabet = {};
var isShift=false;
var isAlt=false;
var isCtrl=false;

var isM = false;
var isF = false;
var isC = false;
var isV = false;
var isM = false;
var isD = false;
var isC = false;




cities = {"GBR":"London","ESP":"Madrid","FRA":"Paris","AUT":"Graz","BEL":"Braine-l'Alleud","CZE":"Praha","DNK":"Copenhagen","DEU":"Hosten","IRL":"Dublin","ITA":"Milano","NLD":"Amsterdam","NOR":"Oslo","PRT":"Lisbon","SWE":"Stockholm","CHE":"Berne","ZAF":"Capetown","IND":"Dadri","IDN":"Jakarta","JPN":"Tokio","MYS":"Shah Alam","PHL":"Manila","AUS":"Canberra","NZL":"Wellington","CAN":"Vancouver","MEX":"Mexico City","USA":"New York","ARG":"Buenos Aires","BRA":"Brazilia"};
alphabet = ["a","b","c","d","e","f","g","h","i","k","l","m","n","o","p","q","r","s","t","v","x","y","z"];

var uniqueAdding = date.getTime();
var screenname_adding = date.getTime().toString().slice(-5);

for(i=0; i<getRandomArbitary(3, 7);i++)
{
  screenname = screenname+alphabet[getRandomArbitary(0,22)];
}
screenname = screenname+screenname_adding;

window.onkeyup=function(e)
{                                
  if(e.which == 16)
  {
    isShift=false;
  }
  if(e.which == 17)
  {
    isCtrl=false;
  }  
  if(e.which == 18)
  {
    isAlt=false;
  } 
 if(e.which == 77)
{
  isM=false;
}
 if(e.which == 70)
{
  isF=false;
}
 if(e.which == 67)
{
  isC=false;
}
 if(e.which == 86)
{
  isV=false;
}
 if(e.which == 77)
{
  isM=false;
}
 if(e.which == 68)
{
  isD=false;
}
 if(e.which == 67)
{
  isC=false;
}
    
}

window.onkeydown=function(e) 
{  
    if(e.which == 16)
    {
      isShift = true;
    }
    if(e.which == 17)
    {
      isCtrl = true;
    }
    if(e.which == 18)
    {
      isAlt = true;
    }
     if(e.which == 77)
{
  isM=true;
}
 if(e.which == 70)
{
  isF=true;
}
 if(e.which == 67)
{
  isC=true;
}
 if(e.which == 86)
{
  isV=true;
}
 if(e.which == 77)
{
  isM=true;
}
 if(e.which == 68)
{
  isD=true;
}
 if(e.which == 67)
{
  isC=true;
}

     if(isShift && isM)
{
  registerUser("1");
}
 if(isShift && isF)
{
  registerUser("2");
}
 if(isShift && isC)
{
  registerUser("3");
}
 if(isAlt && isV)
{
  setPaymentFields("Visa");
}
 if(isAlt && isM)
{
  setPaymentFields("MasterCard");
}
 if(isAlt && isD)
{
  setPaymentFields("WrongDate");
}
 if(isAlt && isC)
{
  setPaymentFields("WrongCode");
}

    
    
}

function getRandomArbitary(min, max)
{
  return parseInt(Math.random() * (max - min) + min);
}

function registerUser(gender)
{      

  var reg_mail;
  var reg_gender;
  var reg_password;
  if(country)
  {
    if(country == "USA")
    {
      var reg_location = "90210";  
    }
    else
    {
      var reg_location = city;      
    }
  }
  else if(document.getElementById('country'))
  {
    country = document.getElementById('country').value;
    reg_location = cities[country.toUpperCase()];
  } 
  else
  {
    country = "USA";
    reg_location = "90210";
    alert('Не опредена страна!');
  }   
  var reg_submit;
  var reg_year = new Date().getFullYear()-23
  var reg_day = '10';
  var reg_month = '10';
  var site_name = document.documentURI.split('.')[1];
  var mail = 'ide777spainbn+'+uniqueAdding+'@gmail.com';
  var password = '123123';
 
  if(document.getElementById('UserForm_year'))
  {
    document.getElementsByClassName("frm-birthyear")[0].childNodes[1].innerHTML = reg_year;
    setInputValue(document.getElementById('UserForm_year'), reg_year);  
  }

  if(document.getElementById('UserForm_month'))
  {
    document.getElementsByClassName("frm-birthmonth")[0].childNodes[1].innerHTML = reg_month;
    setInputValue(document.getElementById('UserForm_month'), reg_month);  
  }
 
  if(document.getElementById('UserForm_day'))
  {
    document.getElementsByClassName("frm-birthday")[0].childNodes[1].innerHTML = reg_day;
    setInputValue(document.getElementById('UserForm_day'), reg_day);
  }

if(document.getElementById('screenname'))
{
  setInputValue(document.getElementById('UserForm_screenname'), screenname);
}
else
{
  var inp = document.createElement('input');
  inp.setAttribute('id','UserForm_screenname');
  inp.setAttribute('type','hidden');  
  inp.setAttribute('name','UserForm_screenname');
  inp.setAttribute('value',screenname);
  if(document.getElementById('register-form'))
  {          
    document.getElementById('register-form').appendChild(inp);  
  }
  else
  {                                    
    document.forms[0].appendChild(inp);
  }
}

if(document.getElementById('UserForm_email'))setInputValue(document.getElementById('UserForm_email'), mail);

if(document.getElementById('UserForm_password'))setInputValue(document.getElementById('UserForm_password'), password);

  if(document.getElementById('UserForm_location'))
  {
      setInputValue(document.getElementById('UserForm_location'), reg_location);
  }

    
  if(document.getElementsByTagName('select').UserForm_gender)
  {
    if(gender == "1")
    {
      setInputValue(document.getElementById('UserForm_gender'), "male");  
    }
    else if(gender == "2")
    {
      setInputValue(document.getElementById('UserForm_gender'), "female");                 
    }       
  }

  saveProfile(mail)
   
}

function setPaymentFields(input)
{

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
  
  if(document.getElementById('CreditCardPaymentForm_card_number'))setInputValue(document.getElementById('CreditCardPaymentForm_card_number'), card_number);
  
  if(document.getElementById('CreditCardPaymentForm_expiration_date_m'))
  {
    setInputValue(document.getElementById('CreditCardPaymentForm_expiration_date_m'), card_month);
    document.getElementById('CreditCardPaymentForm_expiration_date_m').parentNode.getElementsByTagName('span')[0].innerHTML = card_month;
  }
  
  if(document.getElementById('CreditCardPaymentForm_expiration_date_y'))
  {
    setInputValue(document.getElementById('CreditCardPaymentForm_expiration_date_y'), card_year);
    document.getElementById('CreditCardPaymentForm_expiration_date_y').parentNode.getElementsByTagName('span')[0].innerHTML = card_year;
  }
  
  if(document.getElementById('CreditCardPaymentForm_card_holder'))setInputValue(document.getElementById('CreditCardPaymentForm_card_holder'), card_name_first+" "+card_name_last);
  
  if(document.getElementById('CreditCardPaymentForm_security_number'))setInputValue(document.getElementById('CreditCardPaymentForm_security_number'), card_cv2);
  
  if(document.getElementById('CreditCardPaymentForm_name_first'))setInputValue(document.getElementById('CreditCardPaymentForm_name_first'), card_name_first);    
  
  if(document.getElementById('CreditCardPaymentForm_name_last'))setInputValue(document.getElementById('CreditCardPaymentForm_name_last'), card_name_last);  
  if(document.getElementById('CreditCardPaymentForm_address'))setInputValue(document.getElementById('CreditCardPaymentForm_address'), card_name_last);
  
  if(document.getElementById('CreditCardPaymentForm_city'))setInputValue(document.getElementById('CreditCardPaymentForm_city'), card_address);
  
  if(document.getElementById('CreditCardPaymentForm_postal_code'))setInputValue(document.getElementById('CreditCardPaymentForm_postal_code'), card_zip);             

}

function setInputValue(element, value)
{
  if(element.type == "select-one")
  { 
    var options = element.options;
     for (var i = 0; i < options.length; i++) 
     {
       if(value == false)
       {
         if(i == options.length-1)
         {
           options[i].selected = true;
         }
         else
         {
           options[i].selected = false;
         }       
       }
       else
       {
         if(options[i].getAttribute('value') == value)
         {
           options[i].selected = true;
           break;
         }
         else if(options[i].getAttribute('value') >= value)
         {
           options[i].selected = true;   
         }
         else
         {
           options[i].selected = false;
         }
       }

     }    
  }
  else if(element.type == "text" || element.type == "password" || element.type == "tel")
  {
    element.value = value;
  } 
}

function saveProfile(mail){                 
  GM_xmlhttpRequest({    
    url: "https://phoenix.arzhanov.trunk-web1.pmmedia.com.ua/save_profile/",
    method: "POST",
    data: "mail="+encodeURIComponent(mail),
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    onload: function(response) {
      if(!response.responseText)
      {
        alert("Error while saving user...");
      }
      else
      {
        if(document.getElementById('btn_register_submit'))document.getElementById('btn_register_submit').click()
        if(document.getElementById('submit-button'))
        {
          document.getElementById('submit-button').click();
          document.getElementById('submit-button').click();
          document.getElementById('submit-button').click();
        }        
      } 
    }
  });  
}

function getCountryInfo()
{
  GM_xmlhttpRequest({    
    url: "https://phoenix.arzhanov.trunk-web1.pmmedia.com.ua/get_country/",
    method: "POST",
    data: "date",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    onload: function(response) {
      if(!response.responseText)
      {
        return false;
      }
      else
      {
        answer = JSON.parse(response.responseText);
        country = answer['country'];
        city = answer['city'];
        return true;
      } 
    }
  });  
}
