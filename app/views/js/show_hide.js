  function hide_show() {
    if($('#show_hide_password input').attr("type") == "text"){
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass( "bi-eye-slash" );
          $('#show_hide_password i').removeClass( "bi-eye" );
      }else if($('#show_hide_password input').attr("type") == "password"){
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass( "bi-eye-slash" );
          $('#show_hide_password i').addClass( "bi-eye" );
      }
  }