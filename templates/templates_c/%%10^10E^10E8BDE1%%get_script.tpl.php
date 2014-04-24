<?php /* Smarty version 2.6.19, created on 2014-03-27 08:04:43
         compiled from get_script.tpl */ ?>
<a href="../">back</a>
<script type="text/javascript" src="/js/jquery.user.js"></script>
<style>
<?php echo '
input{text-transform: uppercase;}
.mail{text-transform: none;}
html{color: #002C51; font-size: 13px;}
'; ?>

</style>
<script>
<?php echo '
function checkForm()
{
   
}

function setButtonField(e)
{
  sd = e;
  element = e.target.getAttribute("id");
  button_code = e.which;
  if(sd.target.value.length > 1)
  {    
    $(\'#\'+element).val($(\'#\'+element).val()[$(\'#\'+element).val().length - 1]);
    $(\'input[name=button_\'+element+\']\').val(button_code);
  }
  else if(sd.target.value.length > 0)
  {
    $(\'input[name=button_\'+element+\']\').val(button_code);
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


var pressed_keys = {};
document.onkeyup=function(e)
{
  if(pressed_keys.indexOf(e.which) != -1)
  {
    
  }
}

document.onkeyup=function(e)
{
  $(\'#text\').val(e.which);
}
'; ?>

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
Ctrl<input type="checkbox" name="ctrl_reg_male"> + Shift<input type="checkbox" checked name="shift_reg_male"> + Alt<input type="checkbox" name="alt_reg_male"> + 
<input type="text" id="reg_male" name="text_reg_male" size="1" onkeyup="setButtonField(event);" value="M">
<input type="hidden" name="button_reg_male" value="77">

<br>
Female:
<br>
Ctrl<input type="checkbox" name="ctrl_reg_female"> + Shift<input type="checkbox" checked name="shift_reg_female"> + Alt<input type="checkbox" name="alt_reg_female"> + 
<input type="text" id="reg_female" name="text_reg_female" size="1" onkeyup="setButtonField(event);" value="F">
<input type="hidden" name="button_reg_female" value="70">
<br>
Couple:
<br>
Ctrl<input type="checkbox" name="ctrl_reg_couple"> + Shift<input type="checkbox" checked name="shift_reg_couple"> + Alt<input type="checkbox" name="alt_reg_couple"> + 
<input type="text" id="reg_couple" name="text_reg_couple" size="1" onkeyup="setButtonField(event);" value="C">
<input type="hidden" name="button_reg_couple" value="67">
</div>
Payment page:
<br>
Success: Visa:
<br>
Ctrl<input type="checkbox" name="ctrl_pay_visa"> + Shift<input type="checkbox" name="shift_pay_visa"> + Alt<input type="checkbox" checked name="alt_pay_visa"> + 
<input type="text" id="pay_visa" name="text_pay_visa" size="1" onkeyup="setButtonField(event);" value="V">
<input type="hidden" name="button_pay_visa" value="86">
<br>
Success: MasterCard:
<br>
Ctrl<input type="checkbox" name="ctrl_pay_master"> + Shift<input type="checkbox" name="shift_pay_master"> + Alt<input type="checkbox" checked name="alt_pay_master"> + 
<input type="text" id="pay_master" name="text_pay_master" size="1" onkeyup="setButtonField(event);" value="M">
<input type="hidden" name="button_pay_master" value="77">
<br>
Unsuccess: Date: 
<br>
Ctrl<input type="checkbox" name="ctrl_pay_wrong_data"> + Shift<input type="checkbox" name="shift_pay_wrong_data"> + Alt<input type="checkbox" checked name="alt_pay_wrong_data"> + 
<input type="text" id="pay_wrong_data" name="text_pay_wrong_data" size="1" onkeyup="setButtonField(event);" value="D">
<input type="hidden" name="button_pay_wrong_data" value="68">
<br>
Unsuccess: CVV: 
<br>
Ctrl<input type="checkbox" name="ctrl_pay_wrong_cvv"> + Shift<input type="checkbox" name="shift_pay_wrong_cvv"> + Alt<input type="checkbox" checked name="alt_pay_wrong_cvv"> + 
<input type="text" id="pay_wrong_cvv" name="text_pay_wrong_cvv" size="1" onkeyup="setButtonField(event);" value="C">
<input type="hidden" name="button_pay_wrong_cvv" value="67">
<br>
Generate Screenname(funnel):
<br>
Ctrl<input type="checkbox" name="ctrl_generate_screenname"> + Shift<input type="checkbox" checked name="shift_generate_screenname"> + Alt<input type="checkbox" name="alt_generate_screenname"> +
<input type="text" id="generate_screenname" name="text_generate_screenname" size="1" onkeyup="setButtonField(event);" value="S">
<input type="hidden" name="button_generate_screenname" value="83">
<br>
<input type="submit" value="submit" style="border: 1px solid;">
</form>
</div>