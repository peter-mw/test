<?php

/*

type: layout

name: Minimal

description: Minimal Search template

*/

  ?>


<script>mw.moduleCSS("<?php print MW_modules_url(); ?>search/search.css"); </script>
<?php $rand = uniqid(); ?>
<div class="mw-search mw-search-minimal" id="search_box_holder_<?php  print $params['id'] . $rand ?>">
    <span class="sm-icon-magnify"></span>
    <div class="arrbox item-box pad2 mw-search-minimal-holder">
        <div class="mw-search-minimal-field-holder" onclick="mw.$('#search_field_<?php  print $params['id'] . $rand  ?>').focus();">
          <input type="text"
               id="search_field_<?php  print $params['id'] . $rand  ?>"
               class="mw-ui-field w100"
               placeholder="<?php _e("Search"); ?>"
               onkeyup="mw.autocompleteSearch(mwd.getElementById('search_box_holder_<?php  print $params['id'] . $rand  ?>'), this, event, 'search_results_holder_<?php  print $params['id'] . $rand  ?>');"
               onpaste="mw.autocompleteSearch(mwd.getElementById('search_box_holder_<?php  print $params['id'] . $rand  ?>'), this, event, 'search_results_holder_<?php  print $params['id'] . $rand  ?>');"
           />
        </div>
        <div class="mw-autocomplete-search-results" style="display: none" id="search_results_holder_<?php  print $params['id'] . $rand  ?>"></div>
    </div>

</div>

<script>

mw.autocompleteSearch = function(parent, el, e, holder_id){
      var parent = $(parent);
      if(e.type == 'keyup'){
         if(e.keyCode == 38){
            mw.acnav('up', parent);
          }
          else if(e.keyCode == 40){
             mw.acnav('down', parent);
          }
          else if(e.keyCode == 13){
               mw.acnav('enter', parent);
          }
          else if(e.keyCode == 37){

          }
          else if(e.keyCode == 39){

          }
          else{

              parent.addClass("loading");

              el.timeo = el.timeo || null;
              clearTimeout(el.timeo);
              el.timeo = setTimeout(function(){
                  if(el.value == ''){
                    $(mwd.getElementById(holder_id)).hide();
                    parent.removeClass("loading");
                    return false;
                  }
                  $(mwd.getElementById(holder_id)).show();
                    mw.search(el.value, mwd.getElementById(holder_id), {
                       template:'search',
                       limit:50,
                       hide_paging:true,
                       done:function(){
                         parent.removeClass("loading");
                       }
                    });

              }, 600);
          }
      }
}

mw.acnav = function(a, parent){
   var parent = $(parent)[0];

   var lis = mw.$('.module-posts-template-search > ul > li', parent);
   var active = mw.$('.module-posts-template-search > ul li.active', parent);
   if(a == 'up'){
    if(active.length > 0){
       if(active.prev().length > 0){
          active.removeClass("active");
          active.prev().addClass("active");
       }
       else{
          active.removeClass("active");
          lis.eq(lis.length - 1).addClass("active")
       }
    }
    else{
      lis.eq(lis.length - 1).addClass("active")
    }
   }
   else if(a == 'down'){
      if(active.length > 0){
         if(active.next().length > 0){
            active.removeClass("active");
            active.next().addClass("active");
         }
         else{
            active.removeClass("active");
            lis.eq(0).addClass("active")
         }
      }
      else{
        lis.eq(0).addClass("active")
      }
   }
   else if(a=='enter'){
      if(active.length > 0){
        window.location.href = active.find("a").attr("href");
      }
   }
}

if(!mw.autocompleteBinded){
   mw.autocompleteBinded = true;
   $(mwd.body).bind('keyup mousedown', function(e){
      if(!mw.tools.hasParentsWithClass(e.target, 'mw-search')){
        mw.$('.mw-autocomplete-search-results').hide();
        mw.$('.mw-search-minimal-holder').hide();
      }
   });
   mw.$("#search_box_holder_<?php  print $params['id'] . $rand ?> .sm-icon-magnify").bind('click', function(){
     $(this).next().show().find("input").focus();
   })
}



</script>