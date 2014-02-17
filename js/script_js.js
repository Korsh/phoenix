    if(document.URL.contains("//m."))
    {

      var script_tabs = document.createElement ('div');
      script_tabs.id = 'script_tabs';     
      document.body.appendChild (script_tabs);  
        
      var script_tab_register = document.createElement ('div');
      script_tab_register.id = 'script_tab_register';         
      document.getElementById('script_tabs').appendChild (script_tab_register);
      
      var script_tab_pay = document.createElement ('div');
      script_tab_pay.id = 'script_tab_pay';         
      document.getElementById('script_tabs').appendChild (script_tab_pay);                
/*      var script_button = document.createElement ('div');
      script_button.id = 'script_button';
      script_button.innerHTML   = 'Script Menu';      
      document.body.appendChild (script_button);    
      
      var script_menu = document.createElement ('div');
      script_menu.id = 'script_menu';     
      document.getElementById('script_button').appendChild(script_menu);

      var script_register_button = document.createElement ('div');
      script_register_button.id = 'script_register_button';
      script_register_button.innerHTML   = 'Register Menu';      
      document.getElementById('script_menu').appendChild(script_register_button);
      
      var script_pay_button         = document.createElement ('div');
      script_pay_button.id = 'script_pay_button';
      script_pay_button.innerHTML   = 'Pay Menu';      
      document.getElementById('script_menu').appendChild(script_pay_button);
      
      var script_pay_menu         = document.createElement ('div');
      script_pay_menu.id = 'script_pay_menu';
      script_pay_menu.innerHTML = '<span id="script_pay_visa">Visa</span><br><span id="script_pay_master">Master</span><br><span id="script_pay_cvv">Wrong CVV</span><br><span id="script_pay_date">Wrong Date</span>'
      document.getElementById('script_pay_button').appendChild(script_pay_menu);
      
      var script_register_menu         = document.createElement ('div');
      script_register_menu.id = 'script_register_menu';      
      script_register_menu.innerHTML = '<span id="script_register_male">Male</span><br><span id="script_register_female">Female</span>'
      document.getElementById('script_register_button').appendChild(script_register_menu);*/                                        
    }
    
  $(function() {
    $( "#script_tabs" ).tabs();
  });
  
// Load UI Styles
$(function() {
    var resources = {
      'ui-bg_highlight-soft_100_eeeeee_1x100.png': GM_getResourceURL('ui-bg_highlight-soft_100_eeeeee_1x100.png'),
      'ui-bg_diagonals-thick_18_b81900_40x40.png': GM_getResourceURL('ui-bg_diagonals-thick_18_b81900_40x40.png'),
      'ui-bg_diagonals-thick_20_666666_40x40.png': GM_getResourceURL('ui-bg_diagonals-thick_20_666666_40x40.png'),
      'ui-bg_flat_10_000000_40x100.png': GM_getResourceURL('ui-bg_flat_10_000000_40x100.png'),
      'ui-bg_glass_100_f6f6f6_1x400.png': GM_getResourceURL('ui-bg_glass_100_f6f6f6_1x400.png'),
      'ui-bg_glass_100_fdf5ce_1x400.png': GM_getResourceURL('ui-bg_glass_100_fdf5ce_1x400.png'),
      'ui-bg_glass_65_ffffff_1x400.png': GM_getResourceURL('ui-bg_glass_65_ffffff_1x400.png'),
      'ui-bg_gloss-wave_35_f6a828_500x100.png': GM_getResourceURL('ui-bg_gloss-wave_35_f6a828_500x100.png'),
      'ui-bg_highlight-soft_75_ffe45c_1x100.png': GM_getResourceURL('ui-bg_highlight-soft_75_ffe45c_1x100.png'),
      'ui-icons_222222_256x240.png': GM_getResourceURL('ui-icons_222222_256x240.png'),
      'ui-icons_228ef1_256x240.png': GM_getResourceURL('ui-icons_228ef1_256x240.png'),
      'ui-icons_ef8c08_256x240.png': GM_getResourceURL('ui-icons_ef8c08_256x240.png'),
      'ui-icons_ffd27a_256x240.png': GM_getResourceURL('ui-icons_ffd27a_256x240.png'),
      'ui-icons_ffffff_256x240.png': GM_getResourceURL('ui-icons_ffffff_256x240.png')
    };
 
    var head = document.getElementsByTagName('head')[0];
 
    var style = document.createElement('style');
    style.type = 'text/css';
 
    var css = GM_getResourceText ('uiStyle');
    $.each(resources, function(resourceName, resourceUrl) {
      console.log(resourceName + ': ' + resourceUrl);
      css = css.replace( 'images/' + resourceName, resourceUrl);
    });
 
    style.innerHTML = css;
    head.appendChild(style);
})();  