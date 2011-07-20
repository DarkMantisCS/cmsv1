document.observe('dom:loaded', function(){
    if($('quick_permsC')){ $('quick_permsC').show(); }
});

$('quick_perms').observe('change', function(){
    val = $('quick_perms').getValue();
        if(val==0){ return; }
    parts = val.split(',');
        if(parts.length!=9){ return; }
    
    i=0;
    $$('select[js=changeMe]').each(function(input){
        $(input).value = parts[i];
        i++;
    });
});
