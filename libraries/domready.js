$('%%selector%%').each(
	function(){
		var that = this;

		$.ajax({
		  type: 'POST',
		  url: '%%handler%%',
		  data: {
		  	'options': $(that).data()
		  },
		  success: function(data,textStatus,jqXHR) {
				widget_replace(that,data);
		  },
			error: function(jqXHR,textStatus,errorThrown) {
				if ($(that).data().errors == true) {
					widget_replace(that,'{{error}}');
				}
			},
		});
});

widget_replace = function(that,input) {
	if ($(that).is('br')) {
		$(that).replaceWith(input);	
	} else {
		$(that).html(input);
	}
}