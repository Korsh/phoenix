<?php /* Smarty version 2.6.19, created on 2014-04-22 12:17:51
         compiled from find.tpl */ ?>
  <script type="text/javascript" src="/js/jquery.user.js"></script>
  <script type="text/javascript" src="/js/jquery-ui.custom.min.js"></script>      
  <script type="text/javascript" src="/js/find_main.js"></script>               
  <link rel="stylesheet" type="text/css" media="all" href="/css/styles.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/css/jquery-ui.custom.min.css" />
  <script>
  <?php echo '

  $(function() {
    $( document ).tooltip();
  });
  

  '; ?>

  </script>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'loading.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="header">
<div id="get_script_link">
  <a href="../get_script" class="header_link" title="Click here to generate a new script for automate registration or pay by GreaseMonkey(Firefox)or TamperMonkey(Google Chrome)">Get script for GM/TamperMonkey</a>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'sync.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="pages" title="Select needed page from the list">
<?php if ($this->_tpl_vars['pages'] > 1): ?>Pages:<?php endif; ?> 
<?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['start'] = (int)1;
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['pages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
$this->_sections['page']['step'] = 1;
if ($this->_sections['page']['start'] < 0)
    $this->_sections['page']['start'] = max($this->_sections['page']['step'] > 0 ? 0 : -1, $this->_sections['page']['loop'] + $this->_sections['page']['start']);
else
    $this->_sections['page']['start'] = min($this->_sections['page']['start'], $this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] : $this->_sections['page']['loop']-1);
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = min(ceil(($this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] - $this->_sections['page']['start'] : $this->_sections['page']['start']+1)/abs($this->_sections['page']['step'])), $this->_sections['page']['max']);
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
                 $this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
                 $this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>
  <?php if (( $this->_sections['page']['index'] <= 3 ) || ( ( $_GET['page']-3 ) < $this->_sections['page']['index'] && $this->_sections['page']['index'] < ( $_GET['page']+3 ) ) || ( $this->_sections['page']['index'] >= $this->_tpl_vars['pages']-3 )): ?>
    <?php if (( $this->_sections['page']['index'] == $_GET['page'] ) || ( ! $_GET['page'] && $this->_sections['page']['first'] )): ?>
      <?php echo $this->_sections['page']['index']; ?>
 
    <?php else: ?>  
      <a onClick="changePage(<?php echo $this->_sections['page']['index']; ?>
);"  class="header_link">
        <?php echo $this->_sections['page']['index']; ?>

      </a>
    <?php endif; ?>  
  <?php else: ?>
    <?php if (( $this->_sections['page']['index'] == $_GET['page']-3 ) || ( $this->_sections['page']['index'] == $_GET['page']+3 )): ?>
    ...    
    <?php elseif (! $_GET['page'] && $this->_sections['page']['index'] == 4): ?>
    ...
    <?php endif; ?>     
  <?php endif; ?>
<?php endfor; endif; ?>
</div>
<?php if ($_GET): ?>
<a href="../"  class="header_link" title="Click here to clear all parameters for search">Clear parameters for search<span class="remove"></span></a>
<?php endif; ?>
</div>
<table class="main_table">
  <tr>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="site <?php if ($_GET['sort_element'] == 'site'): ?>sort <?php echo $_GET['sort']; ?>
<?php endif; ?>" title="Click on title to sort by site">
          site:
        </span>
      </div>
      <select id="site" onChange="changeCreateria();" title="Select site from list">
        <option></option>            
        <?php $_from = $this->_tpl_vars['site_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['site_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['site_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['site_list']):
        $this->_foreach['site_list']['iteration']++;
?>
          <?php if ($_GET['site'] == $this->_tpl_vars['site_list']): ?>
            <option selected><?php echo $this->_tpl_vars['site_list']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['site_list']; ?>
</option>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </select>
    </th>
    <th>
      <div class="fleft">
        gender:
      </div>
      <select id="gender" onChange="changeCreateria();" title="Select gender from list">
        <option></option>
        <?php $_from = $this->_tpl_vars['gender_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gender_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gender_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['gender_list']):
        $this->_foreach['gender_list']['iteration']++;
?>
          <?php if ($_GET['gender'] == $this->_tpl_vars['gender_list']): ?>
            <option selected><?php echo $this->_tpl_vars['gender_list']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['gender_list']; ?>
</option>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </select>
     </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="country <?php if ($_GET['sort_element'] == 'country'): ?>sort <?php echo $_GET['sort']; ?>
<?php endif; ?>" title="Click on title to sort by country">
          country:
        </span>
      </div>
      <select id="country" onChange="changeCreateria();" title="Select country from list">
        <option></option>
        <?php $_from = $this->_tpl_vars['country_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['country_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['country_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['country_list']):
        $this->_foreach['country_list']['iteration']++;
?>
          <?php if ($_GET['country'] == $this->_tpl_vars['country_list']): ?>                
            <option selected><?php echo $this->_tpl_vars['country_list']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['country_list']; ?>
</option>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </select>
    </th>
    <th width="200px;">
      <div class="fleft" title="To generate autologin link or QRcode click needed button below">
        autologin
      </div>
    </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="reg_time <?php if (! $_GET['sort_element'] || $_GET['sort_element'] == ''): ?>sort desc <?php endif; ?><?php if ($_GET['sort_element'] == 'reg_time'): ?>sort <?php echo $_GET['sort']; ?>
<?php endif; ?>" title="Click on title to sort by date of registration">
          date          
        </span>
        <span id="reg_time_diap" class="icon_search" title="Click here to set the range of registration date"></span>

        <div id="reg_time_diap" class="date_diap<?php if (! $_GET['reg_time_ge'] && ! $_GET['reg_time_l']): ?> hide<?php endif; ?>">
        <span class="data_input">>=<input type="text" id="reg_time_ge" size="8" <?php if ($_GET['reg_time_ge']): ?>value="<?php echo $_GET['reg_time_ge']; ?>
"<?php endif; ?>></span>
        <span class="data_input"><<input type="text" id="reg_time_l" size="8" <?php if ($_GET['reg_time_l']): ?>value="<?php echo $_GET['reg_time_l']; ?>
"<?php endif; ?>></span>
        <br>
        <input type="button" onClick="changeCreateria();" value="Submit">
        </div>
        
      </div>
    </th>
    <th>
      <div class="fleft" title="Insert data for search by user information: id, e-mail, phone number">
        user info:
        <input type="text" id="user_info_search" onInput="user_info_search();" <?php if ($_GET['user_info']): ?>value="<?php echo $_GET['user_info']; ?>
"<?php endif; ?> size="40" title="Insert data for search by user information: id, xe-mail, phone number">
      </div>
    </th>  
    <th>
      <div class="fleft">
        platform:
      </div>
      <select id="platform" onChange="changeCreateria();" title="Select user`s registration type from list">
        <option></option>
        <?php $_from = $this->_tpl_vars['platform_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['platform_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['platform_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['platform_list']):
        $this->_foreach['platform_list']['iteration']++;
?>
          <?php if ($_GET['platform'] == $this->_tpl_vars['platform_list']): ?>
            <option selected><?php echo $this->_tpl_vars['platform_list']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['platform_list']; ?>
</option>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </select>
    </th>
    <th>
      <div class="fleft">
        traffic:
      </div>
      <select id="traffic" onChange="changeCreateria();" title="Select user`s traffic from list">
        <option></option>
        <?php $_from = $this->_tpl_vars['traffic_select_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['traffic_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['traffic_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['traffic_list']):
        $this->_foreach['traffic_list']['iteration']++;
?>
          <?php if ($_GET['traffic'] == $this->_tpl_vars['traffic_list']): ?>
            <option selected><?php echo $this->_tpl_vars['traffic_list']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['traffic_list']; ?>
</option>  
          <?php endif; ?>
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
       <td class="selectable">
       <div class="rel_live unselectable">       
        <span class="button_2" onClick="show_link(event,'live');" title="Click here to get autologin link or QRcode">LIVE link</span>
       </div>             
        <span class="link live selectable" style="display:block">
        <a href="https://<?php echo $this->_tpl_vars['sites_conf'][$this->_tpl_vars['ui']['site']]['live']; ?>
/site/autologin/key/<?php echo $this->_tpl_vars['ui']['key']; ?>
" target="_blank" class="autologin_link">https://<?php echo $this->_tpl_vars['sites_conf'][$this->_tpl_vars['ui']['site']]['live']; ?>
/site/autologin/key/<?php echo $this->_tpl_vars['ui']['key']; ?>
</a>
       </span>
       </td>
       <td class="selectable">
        <?php echo $this->_tpl_vars['ui']['reg_time']; ?>

       </td>
       <td> <br>
        E-mail: <?php echo $this->_tpl_vars['ui']['mail']; ?>

        <br> 
        id: <?php echo $this->_tpl_vars['ui']['id']; ?>

        <br>                    
        Login: <?php echo $this->_tpl_vars['ui']['login']; ?>

        <br>
        Pass: <?php echo $this->_tpl_vars['ui']['password']; ?>

        <br>        
        <a class="sync_link unselectable" onClick="sync('<?php echo $this->_tpl_vars['ui']['id']; ?>
')">sync</a>
       </td>
       <td class="unselectable">
         <?php echo $this->_tpl_vars['ui']['platform']; ?>

       </td>       
       <td class="unselectable">
         <?php echo $this->_tpl_vars['ui']['traffic']; ?>

       </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
  </table>
  