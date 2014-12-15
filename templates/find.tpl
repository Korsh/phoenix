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
<div id="getScriptLink">
  <a href="../get_script" class="headerLink" title="Click here to generate a new script for automate registration or pay by GreaseMonkey(Firefox)or TamperMonkey(Google Chrome)">Get script for GM/TamperMonkey</a>
</div>
{include file='sync.tpl'}
<div id="pages" title="Select needed page from the list">
{if $pages>1}Pages:{/if} 
{section name=page start=1 loop=$pages}
  {if ($smarty.section.page.index le 3) || (($smarty.get.page-3) lt $smarty.section.page.index && $smarty.section.page.index lt ($smarty.get.page+3)) || ($smarty.section.page.index ge $pages-3)}
    {if ($smarty.section.page.index == $smarty.get.page) || (!$smarty.get.page && $smarty.section.page.first)}
      {$smarty.section.page.index} 
    {else}  
      <a onClick="changePage({$smarty.section.page.index});"  class="headerLink">
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
<a href="../"  class="headerLink" title="Click here to clear all parameters for search">Clear parameters for search<span class="remove"></span></a>
{/if}
</div>
<table class="mainTable">
  <tr>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="site {if $smarty.get.sortElement == "site"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by site">
          site:
        </span>
      </div>
      <select id="site" onChange="changeCreateria();" title="Select site from list">
        <option></option>            
        {foreach name=siteList item=siteList from=$siteSelectList}
          {if $smarty.get.site == $siteList}
            <option selected>{$siteList}</option>
          {else}
            <option>{$siteList}</option>
          {/if}
        {/foreach}
      </select>
    </th>
    <th>
      <div class="fleft">
        gender:
      </div>
      <select id="gender" onChange="changeCreateria();" title="Select gender from list">
        <option></option>
        {foreach name=genderList item=genderList from=$genderSelectList}
          {if $smarty.get.gender == $genderList}
            <option selected>{$genderList}</option>
          {else}
            <option>{$genderList}</option>
          {/if}
        {/foreach}
      </select>
     </th>
    <th>
      <div class="fleft">
        <span onClick="sortBy(event);" class="country {if $smarty.get.sortElement == "country"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by country">
          country:
        </span>
      </div>
      <select id="country" onChange="changeCreateria();" title="Select country from list">
        <option></option>
        {foreach name=countryList item=countryList from=$countrySelectList}
          {if $smarty.get.country == $countryList}                
            <option selected>{$countryList}</option>
          {else}
            <option>{$countryList}</option>
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
        <span onClick="sortBy(event);" class="reg_time {if !$smarty.get.sortElement || $smarty.get.sortElement == ''}sort desc {/if}{if $smarty.get.sortElement == "reg_time"}sort {$smarty.get.sort}{/if}" title="Click on title to sort by date of registration">
          date          
        </span>
        <span id="regTimeDiap" class="iconSearch" title="Click here to set the range of registration date"></span>

        <div id="regTimeDiap" class="dateDiap{if !$smarty.get.regTimege && !$smarty.get.regTimel} hide{/if}">
        <span class="dataInput">>=<input type="text" id="regTimege" size="8" {if $smarty.get.regTimege}value="{$smarty.get.regTimege}"{/if}></span>
        <span class="dataInput"><<input type="text" id="regTimel" size="8" {if $smarty.get.regTimel}value="{$smarty.get.regTimel}"{/if}></span>
        <br>
        <input type="button" onClick="changeCreateria();" value="Submit">
        </div>
        
      </div>
    </th>
    <th>
      <div class="fleft" title="Insert data for search by user information: id, e-mail, phone number">
        user info:
        <input type="text" id="userInfoSearch" onInput="userInfoSearch();" {if $smarty.get.userInfo}value="{$smarty.get.userInfo}"{/if} size="40" title="Insert data for search by user information: id, xe-mail, phone number">
      </div>
    </th>  
    <th>
      <div class="fleft">
        platform:
      </div>
      <select id="platform" onChange="changeCreateria();" title="Select user`s registration type from list">
        <option></option>
        {foreach name=platformList item=platformList from=$platformSelectList}
          {if $smarty.get.platform == $platformList}
            <option selected>{$platformList}</option>
          {else}
            <option>{$platformList}</option>
          {/if}
        {/foreach}
      </select>
    </th>
    <th>
      <div class="fleft">
        traffic:
      </div>
      <select id="traffic" onChange="changeCreateria();" title="Select user`s traffic from list">
        <option></option>
        {foreach name=trafficList item=trafficList from=$trafficSelectList}
          {if $smarty.get.traffic == $trafficList}
            <option selected>{$trafficList}</option>
          {else}
            <option>{$trafficList}</option>  
          {/if}
        {/foreach}
      </select>
    </th>    
  </tr>
  {foreach name=userInfo item=ui from=$userInfo}
  <tr>
       <td>
         {$ui.site}
       </td>
       <td>
         {$ui.gender}
       </td>
       <td>
         {$ui.country}
       </td> 
       <td class="selectable">
       <div class="relLive unselectable link">       
        <span class="button2" onClick="showLink(event,'live');" title="Click here to get autologin link or QRcode">LIVE link</span>
       </div>             
        <span class="live unselectable">
        <a href="https://{$sitesConf[$ui.siteId].domain}/site/autologin/key/{$ui.key}" target="_blank" class="autologinLink">https://{$sitesConf[$ui.siteId].domain}/site/autologin/key/{$ui.key}</a>
       </span>
       </td>
       <td class="selectable">
        {$ui.regTime}
       </td>
       <td> <br><span class="selectable">
        E-mail: {$ui.mail}</span>
        <br> 
        id: {$ui.id}
        <br>                    
        Login: {$ui.login}
        <br>
        Pass: {$ui.password}
        <br>        
        <a class="syncLink unselectable" onClick="syncVal = '{$ui.id}' != '' && '{$ui.site}' != '' ? '{$ui.id}' : '{$ui.mail}'; sync(syncVal);">sync</a>
       </td>
       <td class="unselectable">
         {$ui.platform}
       </td>       
       <td class="unselectable">
         {$ui.traffic}
       </td>
    </tr>
    {/foreach}
  </table>
  
