jQuery(document).ready(function($) {
	
	$(this).on('click', '.js-wc-attribute-icon', function(e) {
		
		e.preventDefault();
		
		$('.js-wc-attribute-modal').find('.js-wc-attribute-message').text( $(this).data('description') ).end().fadeToggle(300);
		
	});
	
	$(this).on('click', '.js-wc-attribute-modal, .js-wc-attribute-close', function(e) {
		
		if(e.target !== this) { return; }
		
		e.preventDefault();
		
		$('.js-wc-attribute-modal').fadeToggle(300);
		
	});
	
});