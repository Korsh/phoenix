<a href="../">back</a>
<script type="text/javascript" src="/js/jquery.user.js"></script>
<style>
{literal}
input{text-transform: uppercase;}
.mail{text-transform: none;}
html{color: #002C51; font-size: 13px;}
{/literal}
</style>
<script>
{literal}
function checkForm()
{
   
}

function setButtonField(e)
{
  sd = e;
  element = e.target.getAttribute("id");
  buttonCode = e.which;
  if(sd.target.value.length > 1)
  {    
    $('#'+element).val($('#'+element).val()[$('#'+element).val().length - 1]);
    $('input[name=button'+element+']').val(buttonCode);
  }
  else if(sd.target.value.length > 0)
  {
    $('input[name=button'+element+']').val(buttonCode);
  }
}

function in_array(needle, haystack) 
{
	var found = false, key;

	for (key in haystack) {
		if ((haystack[key] === needle) || (haystack[key] == needle)) {
			found = true;
			break;
		}
	}
	return found;
}


var pressedKeys = {};
document.onkeyup=function(e)
{
  if(pressedKeys.indexOf(e.which) != -1)
  {
    
  }
}

document.onkeyup=function(e)
{
  $('#text').val(e.which);
}
{/literal}
</script>
<div style="width:350px;">
<form action="../get_script?action=new" method="POST">
<b>E-mail for registration:</b>
<br>
<input class="mail" type="text" id="mail" name="mail" size="50">
<hr>
<b>Horkeys:</b>
<div>
Register page:
<br>
Male:
<br>
Ctrl<input type="checkbox" name="ctrlRegMale"> + Shift<input type="checkbox" checked name="shiftRegMale"> + Alt<input type="checkbox" name="altRegMale"> + 
<input type="text" id="regNale" name="textRegMale" size="1" onkeyup="setButtonField(event);" value="M">
<input type="hidden" name="buttonRegMale" value="77">

<br>
Female:
<br>
Ctrl<input type="checkbox" name="ctrlRegFemale"> + Shift<input type="checkbox" checked name="shiftRegFemale"> + Alt<input type="checkbox" name="altRegFemale"> + 
<input type="text" id="regFemale" name="textRegFemale" size="1" onkeyup="setButtonField(event);" value="F">
<input type="hidden" name="buttonRegFemale" value="70">
<br>
Couple:
<br>
Ctrl<input type="checkbox" name="ctrlRegCouple"> + Shift<input type="checkbox" checked name="shiftRegCouple"> + Alt<input type="checkbox" name="altRegCouple"> + 
<input type="text" id="regCouple" name="textRegCouple" size="1" onkeyup="setButtonField(event);" value="C">
<input type="hidden" name="buttonRegCouple" value="67">
</div>
Payment page:
<br>
Success: Visa:
<br>
Ctrl<input type="checkbox" name="ctrlPayVisa"> + Shift<input type="checkbox" name="shiftPayVisa"> + Alt<input type="checkbox" checked name="altPayVisa"> + 
<input type="text" id="payVisa" name="textPayVisa" size="1" onkeyup="setButtonField(event);" value="V">
<input type="hidden" name="buttonPayVisa" value="86">
<br>
Success: MasterCard:
<br>
Ctrl<input type="checkbox" name="ctrlPayMaster"> + Shift<input type="checkbox" name="shiftPayMaster"> + Alt<input type="checkbox" checked name="altPayMaster"> + 
<input type="text" id="payMaster" name="textPayMaster" size="1" onkeyup="setButtonField(event);" value="M">
<input type="hidden" name="buttonPayMaster" value="77">
<br>
Unsuccess: Date: 
<br>
Ctrl<input type="checkbox" name="ctrlPayWrongData"> + Shift<input type="checkbox" name="shiftPayWrongData"> + Alt<input type="checkbox" checked name="altPayWrongData"> + 
<input type="text" id="payWrongData" name="textPayWrongData" size="1" onkeyup="setButtonField(event);" value="D">
<input type="hidden" name="buttonPayWrongData" value="68">
<br>
Unsuccess: CVV: 
<br>
Ctrl<input type="checkbox" name="ctrlPayWrongCvv"> + Shift<input type="checkbox" name="shiftPayWrongCvv"> + Alt<input type="checkbox" checked name="altPayWrongCvv"> + 
<input type="text" id="payWrongCvv" name="textPayWrongCvv" size="1" onkeyup="setButtonField(event);" value="C">
<input type="hidden" name="buttonPayWrongCvv" value="67">
<br>
Generate Screenname(funnel):
<br>
Ctrl<input type="checkbox" name="ctrlGenerateScreenname"> + Shift<input type="checkbox" checked name="shiftGenerateScreenname"> + Alt<input type="checkbox" name="altGenerateScreenname"> +
<input type="text" id="generateScreenname" name="textGenerateScreenname" size="1" onkeyup="setButtonField(event);" value="S">
<input type="hidden" name="buttonGenerateScreenname" value="83">
<br>
<input type="submit" value="submit" style="border: 1px solid;">
</form>
</div>
