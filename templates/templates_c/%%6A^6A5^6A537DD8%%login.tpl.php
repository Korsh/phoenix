<?php /* Smarty version 2.6.19, created on 2013-10-21 08:06:26
         compiled from login.tpl */ ?>
<p>Login:
<br>
<form method="POST" action="/auth/">
<input name="action" type="hidden" value="login">
Логин <input name="login" type="text"><br> 
Пароль <input name="password" type="password"><br>
Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br>  
<input name="submit" type="submit" value="Войти">  
</form>
</p>
<a href="/auth/register/">register</a>