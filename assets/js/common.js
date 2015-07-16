function goTo(id){
    $('html,body').animate({
        scrollTop: $("#"+id).offset().top
    },'slow');
}
$(function(){
    $(document).bind('contextmenu',function(){
        return false;
    });
    $("[data-toggle='popover']").popover();
});