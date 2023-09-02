$(document).ready(function(){
    var profile_dropDown_toggle_status = 0;
    var profile_dropDown_toggle_lock = 0;

    $("#displayUname, #dIcon").click(function(){
      if (profile_dropDown_toggle_status == 1) {
        $(".Sub_menu").css("display", "none");
        $(".Sub_menu").css("z-index" ,"0");
        profile_dropDown_toggle_status = 0;
        
      }
      else if (profile_dropDown_toggle_status == 0) {
        $(".Sub_menu").css("display", "block");
        $(".Sub_menu").css("position" ,"relative");
        $(".Sub_menu").css("z-index" ,"2");
        profile_dropDown_toggle_status = 1;
      }
    });

    $("#Dropdown_menu").mouseleave(function(){
        if (profile_dropDown_toggle_status == 1) {
            $(".Sub_menu").css("display", "none");
            profile_dropDown_toggle_status = 0;
        }
    });
});

