$(function() {
$(".main_table tr").mouseover(function() {

        var tds = $( this ).parent().find("tr"),
            index = $.inArray( this, tds );

        $(".main_table tr:nth-child("+( index + 1 )+")").css("background-color", "#bbccff");
    }).mouseout(function() {
        var tds = $( this ).parent().find("tr"),
            index = $.inArray( this, tds );
        
        $(".main_table tr:nth-child("+( index + 1 )+")").css("background-color", "#ffffff");
        $(".main_table TR:nth-child(odd)").css("background-color", "#eeeeee");
    });  
$("#sync_all").click(function(){
   $.post(
  "/sync_all/",               
   { 
     ajax : true        
   },
   function(response){
     changeCreateria();   
   }
   )
});    
    $( "span#reg_time_diap" ).click(function() {
      $( "div#reg_time_diap" ).toggleClass( "hide", 0 );
      return false;
    });
    
    var date = new Date();
    var curr_date = date.getDate();
    var curr_month = date.getMonth() + 1; //Months are zero based
    var curr_year = date.getFullYear();
    date = curr_year+"-"+curr_month+"-"+curr_date;
    
    $("#reg_time_ge").datepicker({
      dateFormat: "yy-mm-dd",
      maxDate: date,
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        if(!selectedDate == "")
        {
          $("#reg_time_l").datepicker( "option", "minDate", selectedDate );
          $("#reg_time_l").datepicker( "option", "maxDate", date );
        }
      }
    });  
    $("#reg_time_l").datepicker({
      dateFormat: "yy-mm-dd",          
      maxDate: date,
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        if(!selectedDate == "")
        {
          $("#reg_time_ge").datepicker( "option", "minDate", "" );
          $("#reg_time_ge").datepicker( "option", "maxDate", selectedDate );
        }
      }
    });
  });

function user_info_search()
{
  var search_val = $('#user_info_search').val();
  if($.trim(search_val.length) > 7 || search_val.length == 0)
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
  location.search="?site="+$('#site').val()+"&gender="+$('#gender').val()+"&country="+$('#country').val()+"&reg_type="+$('#reg_type').val()+"&sort_element="+$('.sort').toArray()[0].classList[0]+"&sort="+$('.sort').toArray()[0].classList[2]+"&traffic="+$('#traffic').val()+"&pay_status="+$('#pay_status').val()+"&user_info="+encodeURIComponent($.trim($('#user_info_search').val()))+"&page="+page+"&reg_time_ge="+$('#reg_time_ge').val()+"&reg_time_l="+$('#reg_time_l').val()+"&conf_time_ge="+$('#conf_time_ge').val()+"&conf_time_l="+$('#conf_time_l').val();
}

function sortRequest(element, sort)
{
  /*if($('.sort').empty){$('.date').addClass('sort asc')}
  $.post(
  "/find/",               
   { 
     ajax : true,         
     site : $('#site').val(),
     user_info : $.trim($('#user_info_search').val()),
     gender : $('#gender').val(),
     country : $('#country').val(),     
     reg_type : $('#reg_type').val(),
     traffic : $('#traffic').val(),
     pay_status : $('#pay_status').val(),
     sort_element : element,
     sort : sort              
   },
   function(response){    
     answer = eval('('+response+')');
     $('.main_table tr:not(:first)').remove();
     form_answer(answer);*/
     location.search="?site="+$('#site').val()+"&gender="+$('#gender').val()+"&country="+$('#country').val()+"&platform="+$('#platform').val()+"&sort_element="+element+"&sort="+sort+"&traffic="+$('#traffic').val()+"&user_info="+encodeURIComponent($.trim($('#user_info_search').val()))+"&reg_time_ge="+$('#reg_time_ge').val()+"&reg_time_l="+$('#reg_time_l').val();
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
     user_info : $.trim($('#user_info_search').val()),
     gender : $('#gender').val(),
     country : $('#country').val(),
     reg_type : $('#reg_type').val(),
     traffic : $('#traffic').val(),
     pay_status : $('#pay_status').val(),
     sort_element : $('.sort').toArray()[0].classList[0],
     sort : $('.sort').toArray()[0].classList[2]         
   },
   function(response){    
     answer = eval('('+response+')');
     $('.main_table tr:not(:first)').remove();
     form_answer(answer);  */
     location.search="?site="+$('#site').val()+"&gender="+$('#gender').val()+"&country="+$('#country').val()+"&platform="+$('#platform').val()+"&sort_element="+$('.sort').toArray()[0].classList[0]+"&sort="+$('.sort').toArray()[0].classList[2]+"&traffic="+$('#traffic').val()+"&user_info="+encodeURIComponent($.trim($('#user_info_search').val()))+"&reg_time_ge="+$('#reg_time_ge').val()+"&reg_time_l="+$('#reg_time_l').val();
  //  }
  //);      
}

function sortBy(event)
{
    element = event.target;
    element_class = element.getAttribute("class");
    if(element_class.toString().contains("asc"))
    {
      event.target.classList.remove('asc');
      event.target.classList.remove('sort');
      element.classList.add('sort');
      element.classList.add('desc');
      changeCreateria();       
    }
    else if(element_class.toString().contains("desc"))
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

function show_link(event, build)
{
  $('.rel_live').show();
  $('.link').hide();
  $('.key').show();
  element = event.target;
  //element.parentElement
  var img_old = document.getElementById("qr_code");
  $('#qr_code').remove();
  img_src = "http://qrcoder.ru/code/?"+element.parentElement.parentElement.getElementsByClassName(build)[0].getElementsByClassName('autologin_link')[0].textContent+"&2&0";
  img = document.createElement("img");
  img.id = "qr_code";
  img.src = img_src;
  img.style = "float:left;"; 
  element.parentElement.parentElement.getElementsByClassName(build)[0].appendChild(img);
  element.parentElement.parentElement.getElementsByClassName('rel_live')[0].style.display = 'none';
  element.parentElement.parentElement.getElementsByClassName(build)[0].style.display = 'block';  
}