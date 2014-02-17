  <script type="text/javascript" src="/js/jquery.user.js"></script>
  <script type="text/javascript" src="/js/jquery-ui.custom.min.js"></script>      
  <script type="text/javascript" src="/js/find_main.js"></script>               
  <link rel="stylesheet" type="text/css" media="all" href="/css/styles.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/css/jquery-ui.custom.min.css" />
  <script>
  {literal}

  $(function() {
    $( document ).tooltip();
  });
  

  {/literal}
  </script>
  {include file='loading.tpl'}
<div id="header">
<div id="get_script_link">
  <a href="../get_script" class="header_link" title="Click here to generate a new script for automate registration or pay by GreaseMonkey(Firefox)or TamperMonkey(Google Chrome)">Get script for GM/TamperMonkey</a>
</div>
{include file='sync.tpl'}
<div id="pages" title="Select needed page from the list">
{if $pages>1}Pages:{/if} 
{section name=page start=1 loop=$pages}
  {if ($smarty.section.page.index le 3) || (($smarty.get.page-3) lt $smarty.section.page.index && $smarty.section.page.index lt ($smarty.get.page+3)) || ($smarty.section.page.index ge $pages-3)}
    {if ($smarty.section.page.index == $smarty.get.page) || (!$smarty.get.page && $smarty.section.page.first)}
      {$smarty.section.page.index} 
    {else}  
      <a onClick="changePage({$smarty.section.page.index});"  class="header_link">
        {$smarty.section.page.index}
      </a>
    {/if}  
  {else}
    {if ($smarty.section.page.index == $smarty.get.page-3 )|| ($smarty.section.page.index == $smarty.get.page+3)}
    ...    
    {elseif !$smarty.get.page && $smarty.section.page.index == 4}
    ...
    {/if}     
  {/if}
{/section}
</div>
{if $smarty.get}
<a href="../"  class="header_link" title="Click here to clear all parameters for search">Clear parameters for search<span class="remove"></span></a>
{/if}
</div>
<table class="main_table">
  <tr>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="site {if $smarty.get.sort_element == "site"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by site">
          site:
        </span>
      </div>
      <select id="site" onChange="changeCreateria();" title="Select site from list">
        <option></option>            
        {foreach name=site_list item=site_list from=$site_select_list}
          {if $smarty.get.site == $site_list}
            <option selected>{$site_list}</option>
          {else}
            <option>{$site_list}</option>
          {/if}
        {/foreach}
      </select>
    </th>
    <th>
      <div class="fleft">
        dc
      </div>
    </th>
    <th>
      <div class="fleft">
        gender:
      </div>
      <select id="gender" onChange="changeCreateria();" title="Select gender from list">
        <option></option>
        {foreach name=gender_list item=gender_list from=$gender_select_list}
          {if $smarty.get.gender == $gender_list}
            <option selected>{$gender_list}</option>
          {else}
            <option>{$gender_list}</option>
          {/if}
        {/foreach}
      </select>
     </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="country {if $smarty.get.sort_element == "country"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by country">
          country:
        </span>
      </div>
      <select id="country" onChange="changeCreateria();" title="Select country from list">
        <option></option>
        {foreach name=country_list item=country_list from=$country_select_list}
          {if $smarty.get.country == $country_list}                
            <option selected>{$country_list}</option>
          {else}
            <option>{$country_list}</option>
          {/if}
        {/foreach}
      </select>
    </th>
    <th width="200px;">
      <div class="fleft" title="To generate autologin link or QRcode click needed button below">
        autologin
      </div>
    </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="reg_time {if !$smarty.get.sort_element || $smarty.get.sort_element == ''}sort desc {/if}{if $smarty.get.sort_element == "reg_time"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by date of registration">
          date          
        </span>
        <span id="reg_time_diap" class="icon_search" title="Click here to set the range of registration date"></span>

        <div id="reg_time_diap" class="date_diap{if !$smarty.get.reg_time_ge && !$smarty.get.reg_time_l} hide{/if}">
        <span class="data_input">>=<input type="text" id="reg_time_ge" size="8" {if $smarty.get.reg_time_ge}value="{$smarty.get.reg_time_ge}"{/if}></span>
        <span class="data_input"><<input type="text" id="reg_time_l" size="8" {if $smarty.get.reg_time_l}value="{$smarty.get.reg_time_l}"{/if}></span>
        <br>
        <input type="button" onClick="changeCreateria();" value="Submit">
        </div>
        
      </div>
    </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="conf_time {if $smarty.get.sort_element == "conf_time"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by date of confirmation">
          confirm
        </span>
        <span id="conf_time_diap" class="icon_search" title="Click here to set the range of confirmation date"></span>
                                                               
        <div id="conf_time_diap" class="date_diap{if !$smarty.get.conf_time_ge && !$smarty.get.conf_time_l} hide{/if}">
        <span class="data_input">>=<input type="text" id="conf_time_ge" size="8" {if $smarty.get.conf_time_ge}value="{$smarty.get.conf_time_ge}"{/if}></span>
        <span class="data_input"><<input type="text" id="conf_time_l" size="8" {if $smarty.get.conf_time_l}value="{$smarty.get.conf_time_l}"{/if}></span>
        <br>
        <input type="button" onClick="changeCreateria();" value="Submit">
        </div>

      </div>
    </th>
    <!--<th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="id {if $smarty.get.sort_element == "id"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by userID">
          id
        </span>
      </div>
    </th>    
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="xid {if $smarty.get.sort_element == "xid"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by userXID">
          xid
        </span>
      </div>
    </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="oid {if $smarty.get.sort_element == "oid"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by userOID">
          oid
        </span>
      </div>
    </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="mobile {if $smarty.get.sort_element == "mobile"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by phone number">
          mobile
        </span>
      </div>
    </th>-->
    <th>
      <div class="fleft" title="Insert data for search by user information: id, xid, oid, e-mail, phone number">
        user info:
        <input type="text" id="user_info_search" onInput="user_info_search();" {if $smarty.get.user_info}value="{$smarty.get.user_info}"{/if} size="40" title="Insert data for search by user information: id, xid, oid, e-mail, phone number">
      </div>
    </th>  
    <th>
      <div class="fleft">
        reg type:
      </div>
      <select id="reg_type" onChange="changeCreateria();" title="Select user`s registration type from list">
        <option></option>
        {foreach name=reg_type_list item=reg_type_list from=$reg_type_select_list}
          {if $smarty.get.reg_type == $reg_type_list}
            <option selected>{$reg_type_list}</option>
          {else}
            <option>{$reg_type_list}</option>
          {/if}
        {/foreach}
      </select>
    </th>
    <th>
      <div class="fleft">
        pay_status:
      </div>
      <select id="pay_status" onChange="changeCreateria();" title="Select user`s payment status from list">
        <option></option>
        {foreach name=pay_status_list item=pay_status_list from=$pay_status_select_list}
          {if $smarty.get.pay_status == $pay_status_list}
            <option selected>{$pay_status_list}</option>
          {else}
            <option>{$pay_status_list}</option>
          {/if}
        {/foreach}
      </select>
    </th> 
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="expired {if $smarty.get.sort_element == "expired"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by expired date">
          expired
        </span>         
      </div>
    </th>
    <th>
      <div class="fleft">
        traffic:
      </div>
      <select id="traffic" onChange="changeCreateria();" title="Select user`s traffic from list">
        <option></option>
        {foreach name=traffic_list item=traffic_list from=$traffic_select_list}
          {if $smarty.get.traffic == $traffic_list}
            <option selected>{$traffic_list}</option>
          {else}
            <option>{$traffic_list}</option>  
          {/if}
        {/foreach}
      </select>
    </th>    
  </tr>
  {foreach name=user_info item=ui from=$user_info}
  <tr>
       <td>
         {$ui.site}
       </td>
       <td class="unselectable">
         {$ui.dc}
       </td>
       <td>
         {$ui.gender}
       </td>
       <td>
         {$ui.country}
       </td>
       <td class="unselectable">
       <div class="rel_live">       
        <span class="button_1" onClick="show_link(event,'rel');" title="Click here to get autologin link or QRcode">REL link</span>
        <span class="button_2" onClick="show_link(event,'live');" title="Click here to get autologin link or QRcode">LIVE link</span>
       </div>       
        <span class="link rel">
          <a href="http://{$sites_conf[$ui.site].rel}/{$ui.key}/autologin.php" class="autologin_link">http://{$sites_conf[$ui.site].rel}/{$ui.key}/autologin.php</a>
          <br>
          <span class="button_2" onClick="show_link(event,'live');" title="Click here to get autologin link or QRcode">
            LIVE link
          </span>
        </span>        
        <span class="link live">
        <a href="http://{$sites_conf[$ui.site].live}/{$ui.key}/autologin.php" class="autologin_link">http://{$sites_conf[$ui.site].live}/{$ui.key}/autologin.php</a>
          <br>
          <span class="button_1" onClick="show_link(event,'rel');" title="Click here to get autologin link or QRcode">
            REL link
          </span>
        </span>
       </td>
       <td class="unselectable">
        {$ui.reg_time}
       </td>
       <td class="unselectable">
        {$ui.conf_time}
       </td>
       <!--<td>
        {$ui.id}
       </td>
       <td>
        {$ui.xid}
       </td>
       <td>
        {$ui.oid}
       </td>
       <td>
        {$ui.mobile}
       </td>-->
       <td> <br>
        E-mail: {$ui.mail}
        <br>
        Mobile: {$ui.mobile}
        <br>    
        id: {$ui.id}
        <br>                
        oid: {$ui.oid}
        <br>   
        xid: {$ui.xid}
        <br>
        Screenname: {$ui.screenname}
        <br>
        Pass: {$ui.password}
        <br>
        
        <a class="sync_link unselectable" onClick="sync('{$ui.id}')">sync</a>
       </td>
       <td>
         {$ui.reg_type}
       </td>       
       <td class="unselectable">
         {$ui.pay_status}
       </td>
       <td class="unselectable">
         {$ui.expired}
       </td> 
       <td class="unselectable">
         {$ui.traffic}
       </td>
    </tr>
    {/foreach}
  </table>
  