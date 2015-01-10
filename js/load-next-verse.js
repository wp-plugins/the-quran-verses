jQuery(document).ready(function($) {

$('#tqv-refresh-button').click(function() {
    $('#tqv-refresh-button').hide();
    $('#tqv-reloading').show();
	$.get("?act=tqv-refresh-contents",
      function(html){
        $('#tqv-contents').html(html);
    		$('#tqv-reloading').hide();
		    $('#tqv-refresh-button').show();
      });
    return false;
  });
});