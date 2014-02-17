<?php /* Smarty version 2.6.19, created on 2013-10-21 08:06:22
         compiled from register.tpl */ ?>
<div class="register">
Register:

<form action="/auth/" method="POST">
<input name="action" type="hidden" value="register">
Логин <input name="login" type="text"><br>                    
Пароль <input name="password" type="password"><br>            
<input name="submit" type="submit" value="Зарегистрироваться">
</form>
<a href="/auth/login/">login</a>
</div>