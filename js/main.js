function changeCreateria()
{
  if($('.sort').empty){$('.date').addClass('sort asc')}
  $.post(
  "find_user.php",               
   { 
     ajax : true,         
     site : $('#site').val(),
     gender : $('#gender').val(),
     country : $('#country').val(),
     device : $('#device').val(),
     sort_element : $('.sort').toArray()[0].classList[0],
     sort : $('.sort').toArray()[0].classList[2]
     
   },
   function(response){    
     answer = eval('('+response+')');
     $('.mainTable tr:not(:first)').remove();
     if(answer != "empty")
     { 
        for(var k in answer.data) 
        {
          $('.mainTable').append("<tr>"
            +"<td>"+answer.data[k]['site']+"</td>"
            +"<td>"+answer.data[k]['gender']+"</td>"
            +"<td>"+answer.data[k]['country']+"</td>"
            +"<td>"+answer.data[k]['email']+"</td>"
            +"<td>"+answer.data[k]['reg_time']+"</td>"
            +"<td>"+answer.data[k]['device_type']+"</td>"
          +"</tr>");
        }
        $('.'+answer.sort_element).addClass('sort '+answer.sort);
      }
      else
      {
          $('.mainTable').append("<tr>"
            +"<td>no data</td>"          
          +"</tr>");
      }
    }
  );      
}

function sync(mail)
{
  alert('wait for response...');
  $.get(
  "/sync_by_createria/"+mail+"/",               
   { 
     ajax : true,                     
   },
   function(response){
    alert(response+"\n"+mail);
   }
  );  
}

function sortBy(event)
{
    element = event.target;
    element_class = element.getAttribute("class");
    if(element_class.toString().contains("asc"))
    {
      event.target.classList.remove('asc');
      event.target.classList.remove('sort');
      sortRequest(element.getAttribute("class"), "desc");      
    }
    else if(element_class.toString().contains("desc"))
    {
      event.target.classList.remove('desc');
      event.target.classList.remove('sort');
      sortRequest(element.getAttribute("class"), "asc");
    }
    else
    {
      sortRequest(element.getAttribute("class"), "asc");
    }
}

function sortRequest(element, sort)
{
  if($('.sort').empty){$('.date').addClass('sort asc')}
  $.post(
  "find_user.php",               
   { 
     ajax : true,         
     site : $('#site').val(),
     gender : $('#gender').val(),
     country : $('#country').val(),
     device : $('#device').val(),
     sort_element : element,
     sort : sort
     
   },
   function(response){    
     answer = eval('('+response+')');
     $('.mainTable tr:not(:first)').remove();
     if(answer != "empty")
     { 
        for(var k in answer.data) 
        {
          $('.mainTable').append("<tr>"
            +"<td>"+answer.data[k]['site']+"</td>"
            +"<td>"+answer.data[k]['gender']+"</td>"
            +"<td>"+answer.data[k]['country']+"</td>"
            +"<td>"+answer.data[k]['email']+"</td>"
            +"<td>"+answer.data[k]['reg_time']+"</td>"
            +"<td>"+answer.data[k]['device_type']+"</td>"
          +"</tr>");
        }
        $('.asc').removeClass('asc');
        $('.desc').removeClass('desc');
        $('.sort').removeClass('sort');
        $('.'+answer.sort_element).addClass('sort '+answer.sort);
      }
      else
      {
          $('.mainTable').append("<tr>"
            +"<td>no data</td>"          
          +"</tr>");
      }
    }
  );      
}
