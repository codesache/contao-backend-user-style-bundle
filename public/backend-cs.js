
window.addEvent("domready", function(){
    $$('.tl_listing .tl_file input').addEvent('click', function(){
        $$(this).getParent().getParent().toggleClass('active');
    });
    $$('.tl_file').addEvent('click', function(){
        $$(this).toggleClass('active');
    });
});

