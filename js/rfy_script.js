jQuery(document).ready(function(){
	jQuery(document).on('click', '.rf_close_btn', function(){
		jQuery.cookie('rf_hide', 'yes', { expires: 1 });
		jQuery(this).css('display','none');
		jQuery('.rf_floating').stop().animate({'bottom':'-300px'},1000);
		setTimeout(function(){
			jQuery('.rf_floating').css('display','none');
		},1000);
	});
	jQuery(window).scroll(function(){
		var mobile_enabled = jQuery('#rfy_mobile_enabled').val();
		if( 'no' == mobile_enabled && 768 > jQuery(window).width() ){
		} else {
			if (jQuery('.rf_end_of_content').length) {
				var scroll_amt = jQuery(document).scrollTop();
				var height = jQuery(window).height();
				var eoc = jQuery('.rf_end_of_content').offset().top;
				eoc = eoc-height-400;
				if(scroll_amt >= eoc){
					if (jQuery.cookie('rf_hide') == 'yes') {
					}else{
						jQuery('.rf_floating').css('display','block');
						jQuery('.rf_close_btn').css('display','');
						jQuery('.rf_floating').stop().animate({'bottom':'0px'},1000);
					}
				};
			};			
		}
	});
});