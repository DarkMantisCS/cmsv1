if($('quickreply')){ makeReplyForm('quickreply', 'Click to make a reply...'); }

document.observe("dom:loaded", function(){
    $$('div.logo').each(function(e){
        Event.observe(e, 'click', function(event) {
            document.location = e.down().href;
        });
    });
});
