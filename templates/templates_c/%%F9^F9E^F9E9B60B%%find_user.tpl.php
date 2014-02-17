<?php /* Smarty version 2.6.19, created on 2013-09-25 08:28:40
         compiled from find_user.tpl */ ?>
  <script type="text/javascript" src="/js/jquery.user.js"></script>    
  <script type="text/javascript" src="/js/main.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="/css/styles.css" />

<table class="main_table">
  <tr>
  <th><div class="fleft"><span onClick="sortBy(event);" class="site">site:</span></div>
    <select id="site" onChange="changeCreateria();">
      <option></option>
      <?php $_from = $this->_tpl_vars['site_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['site_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['site_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['site_list']):
        $this->_foreach['site_list']['iteration']++;
?>
          <option><?php echo $this->_tpl_vars['site_list']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
      '.$site_select_list.'
    </select>
  </th>
  <th><div class="fleft">gender:
    <select id="gender" onChange="changeCreateria();">
      <option></option>
      <?php $_from = $this->_tpl_vars['gender_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gender_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gender_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['gender_list']):
        $this->_foreach['gender_list']['iteration']++;
?>
          <option><?php echo $this->_tpl_vars['gender_list']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
    </select>
  </th>
  <th><div class="fleft"><span onClick="sortBy(event);" class="country">country:</span></div>
    <select id="country" onChange="changeCreateria();">
      <option></option>
      <?php $_from = $this->_tpl_vars['country_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['country_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['country_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['country_list']):
        $this->_foreach['country_list']['iteration']++;
?>
          <option><?php echo $this->_tpl_vars['country_list']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
    </select>
  </th>
  <th><div class="fleft">e-mail</div></th>
  <th><div class="fleft"><span onClick="sortBy(event);" class="reg_time sort desc">date</span></div></th>
  <th><div class="fleft">device:</div>
    <select id="device" onChange="changeCreateria();">
      <option></option>
      <?php $_from = $this->_tpl_vars['device_type_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['device_type_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['device_type_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['device_type_list']):
        $this->_foreach['device_type_list']['iteration']++;
?>
          <option><?php echo $this->_tpl_vars['device_type_list']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
    </select>
  </th>
  </tr>
  <?php $_from = $this->_tpl_vars['user_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['user_info'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['user_info']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ui']):
        $this->_foreach['user_info']['iteration']++;
?>
  <tr>
    <td>
      <?php echo $this->_tpl_vars['ui']['site']; ?>

    </td>
    <td>
      <?php echo $this->_tpl_vars['ui']['gender']; ?>

    </td>
    <td>
      <?php echo $this->_tpl_vars['ui']['country']; ?>

    </td>
    <td>
      <?php echo $this->_tpl_vars['ui']['email']; ?>
<a class="sync_link" onClick="sync('<?php echo $this->_tpl_vars['ui']['email']; ?>
')">sync</a>
    </td>
    <td>
      <?php echo $this->_tpl_vars['ui']['reg_time']; ?>

    </td>
    <td>
      <?php echo $this->_tpl_vars['ui']['device_type']; ?>

    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>