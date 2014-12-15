$(function() {
$(".mainTable tr").mouseover(function() {

        var tds = $( this ).parent().find("tr"),
            index = $.inArray( this, tds );

        $(".mainTable tr:nth-child("+( index + 1 )+")").css("background-color", "#bbccff");
    }).mouseout(function() {
        var tds = $( this ).parent().find("tr"),
            index = $.inArray( this, tds );
        
        $(".mainTable tr:nth-child("+( index + 1 )+")").css("background-color", "#ffffff");
        $(".mainTable TR:nth-child(odd)").css("background-color", "#eeeeee");
    });  
$("#syncAll").click(function(){
   $.post(
  "/syncAll/",               
   { 
     ajax : true        
   },
   function(response){
     changeCreateria();   
   }
   )
});    
    $( "span#regTimeDiap" ).click(function() {
      $( "div#regTimeDiap" ).toggleClass( "hide", 0 );
      return false;
    });
    
    var date = new Date();
    var currDate = date.getDate();
    var currMonth = date.getMonth() + 1; //Months are zero based
    var currYear = date.getFullYear();
    date = currYear+"-"+currMonth+"-"+currDate;
    
    $("#regTimege").datepicker({
      dateFormat: "yy-mm-dd",
      maxDate: date,
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        if(!selectedDate == "")
        {
          $("#regTimel").datepicker( "option", "minDate", selectedDate );
          $("#regTimel").datepicker( "option", "maxDate", date );
        }
      }
    });  
    $("#regTimel").datepicker({
      dateFormat: "yy-mm-dd",          
      maxDate: date,
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        if(!selectedDate == "")
        {
          $("#regTimege").datepicker( "option", "minDate", "" );
          $("#regTimege").datepicker( "option", "maxDate", selectedDate );
        }
      }
    });
  });

function userInfoSearch()
{
  var searchVal = $('#userInfoSearch').val();
  if($.trim(searchVal.length) > 7 || searchVal.length == 0)
  {
    changeCreateria();
  }    
}

function sync(mail)
{
  $('#loading').show();
  $.get(
  "/sync_by_createria/"+mail+"/",               
   { 
     ajax : true,                     
   },
   function(response){
    $('#loading').hide();
    $('#informer').append(response);
    $('#informer').show();
    setTimeout(
      '$("#informer").hide();'+
      '$("#informer").html("");'+
      'changeCreateria()', 1500);
    
    //alert(response);
    //setTimeout(changeCreateria(), 1000);
    
   }
  );  
}

function changePage(page)
{  
  location.search="?site="+$('#site').val()+"&gender="+$('#gender').val()+"&country="+$('#country').val()+"&regType="+$('#regType').val()+"&sortElement="+$('.sort').toArray()[0].classList[0]+"&sort="+$('.sort').toArray()[0].classList[2]+"&traffic="+$('#traffic').val()+"&payStatus="+$('#payStatus').val()+"&userInfo="+encodeURIComponent($.trim($('#userInfoSearch').val()))+"&page="+page+"&regTimege="+$('#regTimege').val()+"&regTimel="+$('#regTimel').val()+"&confTimege="+$('#confTimege').val()+"&confTimel="+$('#confTimel').val();
}

function sortRequest(element, sort)
{
  /*if($('.sort').empty){$('.date').addClass('sort asc')}
  $.post(
  "/find/",               
   { 
     ajax : true,         
     site : $('#site').val(),
     userInfo : $.trim($('#userInfoSearch').val()),
     gender : $('#gender').val(),
     country : $('#country').val(),     
     regType : $('#regType').val(),
     traffic : $('#traffic').val(),
     payStatus : $('#payStatus').val(),
     sortElement : element,
     sort : sort              
   },
   function(response){    
     answer = eval('('+response+')');
     $('.mainTable tr:not(:first)').remove();
     formAnswer(answer);*/
     location.search="?site="+$('#site').val()+"&gender="+$('#gender').val()+"&country="+$('#country').val()+"&platform="+$('#platform').val()+"&sortElement="+element+"&sort="+sort+"&traffic="+$('#traffic').val()+"&userInfo="+encodeURIComponent($.trim($('#userInfoSearch').val()))+"&regTimege="+$('#regTimege').val()+"&regTimel="+$('#regTimel').val();
  //  }
 // );      
}

function changeCreateria()
{                                                              
  /*if($('.sort').length == 0){$('.date').addClass('sort asc');}

  $.post(
  "/find/",               
   { 
     ajax : true,         
     site : $('#site').val(),
     userInfo : $.trim($('#userInfoSearch').val()),
     gender : $('#gender').val(),
     country : $('#country').val(),
     regType : $('#regType').val(),
     traffic : $('#traffic').val(),
     payStatus : $('#payStatus').val(),
     sortElement : $('.sort').toArray()[0].classList[0],
     sort : $('.sort').toArray()[0].classList[2]         
   },
   function(response){    
     answer = eval('('+response+')');
     $('.mainTable tr:not(:first)').remove();
     formAnswer(answer);  */
     location.search="?site="+$('#site').val()+"&gender="+$('#gender').val()+"&country="+$('#country').val()+"&platform="+$('#platform').val()+"&sortElement="+$('.sort').toArray()[0].classList[0]+"&sort="+$('.sort').toArray()[0].classList[2]+"&traffic="+$('#traffic').val()+"&userInfo="+encodeURIComponent($.trim($('#userInfoSearch').val()))+"&regTimege="+$('#regTimege').val()+"&regTimel="+$('#regTimel').val();
  //  }
  //);      
}

function sortBy(event)
{
    element = event.target;
    elementClass = element.getAttribute("class");
    if(elementClass.toString().contains("asc"))
    {
      event.target.classList.remove('asc');
      event.target.classList.remove('sort');
      element.classList.add('sort');
      element.classList.add('desc');
      changeCreateria();       
    }
    else if(elementClass.toString().contains("desc"))
    {
      event.target.classList.remove('desc');
      event.target.classList.remove('sort');
      element.classList.add('sort');
      element.classList.add('asc');
      changeCreateria();
    }
    else
    {
      $('.asc').removeClass('asc');
      $('.desc').removeClass('desc');
      $('.sort').removeClass('sort');
      element.classList.add('sort');
      element.classList.add('asc');
      changeCreateria();
    }
}

function showLink(event, build)
{
  $('.relLive').show();
  $('.link').hide();
  $('.key').show();
  element = event.target;
  //element.parentElement
  var imgOld = document.getElementById("qrCode");
  $('#qrCode').remove();
  imgSrc = "http://qrcoder.ru/code/?"+element.parentElement.parentElement.getElementsByClassName(build)[0].getElementsByClassName('autologinLink')[0].textContent+"&2&0";
  img = document.createElement("img");
  img.id = "qrCode";
  img.src = imgSrc;
  img.style = "float:left;"; 
  element.parentElement.parentElement.getElementsByClassName(build)[0].appendChild(img);
  element.parentElement.parentElement.getElementsByClassName('relLive')[0].style.display = 'none';
  element.parentElement.parentElement.getElementsByClassName(build)[0].style.display = 'block';  
}
