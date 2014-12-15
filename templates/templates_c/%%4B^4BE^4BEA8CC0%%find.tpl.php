<?php /* Smarty version 2.6.19, created on 2014-11-19 09:13:37
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
<div id="getScriptLink">
  <a href="../get_script" class="headerLink" title="Click here to generate a new script for automate registration or pay by GreaseMonkey(Firefox)or TamperMonkey(Google Chrome)">Get script for GM/TamperMonkey</a>
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
);"  class="headerLink">
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
<a href="../"  class="headerLink" title="Click here to clear all parameters for search">Clear parameters for search<span class="remove"></span></a>
<?php endif; ?>
</div>
<table class="mainTable">
  <tr>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="site <?php if ($_GET['sortElement'] == 'site'): ?>sort <?php echo $_GET['sort']; ?>
<?php endif; ?>" title="Click on title to sort by site">
          site:
        </span>
      </div>
      <select id="site" onChange="changeCreateria();" title="Select site from list">
        <option></option>            
        <?php $_from = $this->_tpl_vars['siteSelectList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['siteList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['siteList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['siteList']):
        $this->_foreach['siteList']['iteration']++;
?>
          <?php if ($_GET['site'] == $this->_tpl_vars['siteList']): ?>
            <option selected><?php echo $this->_tpl_vars['siteList']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['siteList']; ?>
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
        <?php $_from = $this->_tpl_vars['genderSelectList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['genderList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['genderList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['genderList']):
        $this->_foreach['genderList']['iteration']++;
?>
          <?php if ($_GET['gender'] == $this->_tpl_vars['genderList']): ?>
            <option selected><?php echo $this->_tpl_vars['genderList']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['genderList']; ?>
</option>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </select>
     </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="country <?php if ($_GET['sortElement'] == 'country'): ?>sort <?php echo $_GET['sort']; ?>
<?php endif; ?>" title="Click on title to sort by country">
          country:
        </span>
      </div>
      <select id="country" onChange="changeCreateria();" title="Select country from list">
        <option></option>
        <?php $_from = $this->_tpl_vars['countrySelectList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['countryList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['countryList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['countryList']):
        $this->_foreach['countryList']['iteration']++;
?>
          <?php if ($_GET['country'] == $this->_tpl_vars['countryList']): ?>                
            <option selected><?php echo $this->_tpl_vars['countryList']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['countryList']; ?>
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
        <span onClick="sortBy(event);" class="reg_time <?php if (! $_GET['sortElement'] || $_GET['sortElement'] == ''): ?>sort desc <?php endif; ?><?php if ($_GET['sortElement'] == 'reg_time'): ?>sort <?php echo $_GET['sort']; ?>
<?php endif; ?>" title="Click on title to sort by date of registration">
          date          
        </span>
        <span id="regTimeDiap" class="iconSearch" title="Click here to set the range of registration date"></span>

        <div id="regTimeDiap" class="dateDiap<?php if (! $_GET['regTimege'] && ! $_GET['regTimel']): ?> hide<?php endif; ?>">
        <span class="dataInput">>=<input type="text" id="regTimege" size="8" <?php if ($_GET['regTimege']): ?>value="<?php echo $_GET['regTimege']; ?>
"<?php endif; ?>></span>
        <span class="dataInput"><<input type="text" id="regTimel" size="8" <?php if ($_GET['regTimel']): ?>value="<?php echo $_GET['regTimel']; ?>
"<?php endif; ?>></span>
        <br>
        <input type="button" onClick="changeCreateria();" value="Submit">
        </div>
        
      </div>
    </th>
    <th>
      <div class="fleft" title="Insert data for search by user information: id, e-mail, phone number">
        user info:
        <input type="text" id="userInfoSearch" onInput="userInfoSearch();" <?php if ($_GET['userInfo']): ?>value="<?php echo $_GET['userInfo']; ?>
"<?php endif; ?> size="40" title="Insert data for search by user information: id, xe-mail, phone number">
      </div>
    </th>  
    <th>
      <div class="fleft">
        platform:
      </div>
      <select id="platform" onChange="changeCreateria();" title="Select user`s registration type from list">
        <option></option>
        <?php $_from = $this->_tpl_vars['platformSelectList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['platformList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['platformList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['platformList']):
        $this->_foreach['platformList']['iteration']++;
?>
          <?php if ($_GET['platform'] == $this->_tpl_vars['platformList']): ?>
            <option selected><?php echo $this->_tpl_vars['platformList']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['platformList']; ?>
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
        <?php $_from = $this->_tpl_vars['trafficSelectList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['trafficList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['trafficList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['trafficList']):
        $this->_foreach['trafficList']['iteration']++;
?>
          <?php if ($_GET['traffic'] == $this->_tpl_vars['trafficList']): ?>
            <option selected><?php echo $this->_tpl_vars['trafficList']; ?>
</option>
          <?php else: ?>
            <option><?php echo $this->_tpl_vars['trafficList']; ?>
</option>  
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </select>
    </th>    
  </tr>
  <?php $_from = $this->_tpl_vars['userInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['userInfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['userInfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ui']):
        $this->_foreach['userInfo']['iteration']++;
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
       <div class="relLive unselectable link">       
        <span class="button2" onClick="showLink(event,'live');" title="Click here to get autologin link or QRcode">LIVE link</span>
       </div>             
        <span class="live unselectable">
        <a href="https://<?php echo $this->_tpl_vars['sitesConf'][$this->_tpl_vars['ui']['siteId']]['domain']; ?>
/site/autologin/key/<?php echo $this->_tpl_vars['ui']['key']; ?>
" target="_blank" class="autologinLink">https://<?php echo $this->_tpl_vars['sitesConf'][$this->_tpl_vars['ui']['siteId']]['domain']; ?>
/site/autologin/key/<?php echo $this->_tpl_vars['ui']['key']; ?>
</a>
       </span>
       </td>
       <td class="selectable">
        <?php echo $this->_tpl_vars['ui']['regTime']; ?>

       </td>
       <td> <br><span class="selectable">
        E-mail: <?php echo $this->_tpl_vars['ui']['mail']; ?>
</span>
        <br> 
        id: <?php echo $this->_tpl_vars['ui']['id']; ?>

        <br>                    
        Login: <?php echo $this->_tpl_vars['ui']['login']; ?>

        <br>
        Pass: <?php echo $this->_tpl_vars['ui']['password']; ?>

        <br>        
        <a class="syncLink unselectable" onClick="syncVal = '<?php echo $this->_tpl_vars['ui']['id']; ?>
' != '' && '<?php echo $this->_tpl_vars['ui']['site']; ?>
' != '' ? '<?php echo $this->_tpl_vars['ui']['id']; ?>
' : '<?php echo $this->_tpl_vars['ui']['mail']; ?>
'; sync(syncVal);">sync</a>
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
  